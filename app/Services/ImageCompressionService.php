<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use RuntimeException;

class ImageCompressionService
{
    public const MAX_BYTES = 716800; // 700 KB

    public const MIN_BYTES = 307200; // 300 KB

    /** @var list<string> */
    private array $tempFiles = [];

    public function __destruct()
    {
        foreach ($this->tempFiles as $path) {
            if (is_string($path) && file_exists($path)) {
                @unlink($path);
            }
        }
    }

    public function compressIfNeeded(UploadedFile $file): UploadedFile
    {
        if (! $file->isValid() || ! $this->isCompressibleImage($file)) {
            return $file;
        }

        $size = $file->getSize();
        if ($size === false || $size <= self::MAX_BYTES) {
            return $file;
        }

        try {
            $compressedPath = $this->compress($file->getRealPath() ?: $file->getPathname());
            $newSize = filesize($compressedPath);

            if ($newSize === false || $newSize >= $size) {
                return $file;
            }

            return new UploadedFile(
                $compressedPath,
                $this->buildOutputFilename($file, $compressedPath),
                mime_content_type($compressedPath) ?: $file->getMimeType() ?: 'application/octet-stream',
                null,
                true
            );
        } catch (\Throwable $e) {
            report($e);

            return $file;
        }
    }

    public function isCompressibleImage(UploadedFile $file): bool
    {
        $mime = strtolower((string) $file->getMimeType());
        if (str_starts_with($mime, 'image/')) {
            return ! in_array($mime, ['image/svg+xml', 'image/svg', 'image/x-icon', 'image/vnd.microsoft.icon'], true);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'], true);
    }

    private function compress(string $path): string
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('GD extension is required for image compression.');
        }

        $info = @getimagesize($path);
        if ($info === false) {
            throw new RuntimeException('Unable to read image dimensions.');
        }

        [$width, $height, $type] = $info;
        $source = $this->createImageResource($path, $type);
        if (! $source) {
            throw new RuntimeException('Unable to load image for compression.');
        }

        $hasAlpha = $this->imageHasAlpha($source, $width, $height, $type);
        $usePng = $hasAlpha || $type === IMAGETYPE_PNG;

        $bestInRange = null;
        $bestInRangeSize = 0;
        $bestUnderMax = null;
        $bestUnderMaxSize = PHP_INT_MAX;

        $scale = 1.0;
        for ($scaleAttempt = 0; $scaleAttempt < 14; $scaleAttempt++) {
            $targetW = max(1, (int) round($width * $scale));
            $targetH = max(1, (int) round($height * $scale));
            $canvas = $this->resizeImage($source, $width, $height, $targetW, $targetH, $hasAlpha);

            if ($usePng) {
                foreach ([9, 8, 7, 6, 5, 4, 3, 2, 1, 0] as $level) {
                    $this->evaluateCandidate(
                        $this->writeTemp($canvas, 'png', ['level' => $level]),
                        $bestInRange,
                        $bestInRangeSize,
                        $bestUnderMax,
                        $bestUnderMaxSize
                    );
                }
            } else {
                for ($quality = 92; $quality >= 40; $quality -= 2) {
                    $this->evaluateCandidate(
                        $this->writeTemp($canvas, 'jpeg', ['quality' => $quality]),
                        $bestInRange,
                        $bestInRangeSize,
                        $bestUnderMax,
                        $bestUnderMaxSize
                    );
                }
            }

            imagedestroy($canvas);

            if ($bestInRange !== null) {
                imagedestroy($source);

                return $bestInRange;
            }

            if ($bestUnderMaxSize <= self::MAX_BYTES && $scaleAttempt >= 3) {
                break;
            }

            $scale *= 0.85;
        }

        imagedestroy($source);

        if ($bestInRange !== null) {
            return $bestInRange;
        }

        if ($bestUnderMax !== null) {
            return $bestUnderMax;
        }

        throw new RuntimeException('Unable to compress image into the required size range.');
    }

    private function evaluateCandidate(
        string $path,
        ?string &$bestInRange,
        int &$bestInRangeSize,
        ?string &$bestUnderMax,
        int &$bestUnderMaxSize
    ): void {
        $size = filesize($path);
        if ($size === false) {
            return;
        }

        if ($size <= self::MAX_BYTES && $size >= self::MIN_BYTES) {
            if ($size > $bestInRangeSize) {
                if ($bestInRange !== null && $bestInRange !== $path) {
                    @unlink($bestInRange);
                }
                $bestInRange = $path;
                $bestInRangeSize = $size;
            } elseif ($bestInRange !== $path) {
                @unlink($path);
            }

            return;
        }

        if ($size <= self::MAX_BYTES && $size < self::MIN_BYTES) {
            if ($size < $bestUnderMaxSize) {
                if ($bestUnderMax !== null && $bestUnderMax !== $path) {
                    @unlink($bestUnderMax);
                }
                $bestUnderMax = $path;
                $bestUnderMaxSize = $size;
            } elseif ($bestUnderMax !== $path) {
                @unlink($path);
            }

            return;
        }

        @unlink($path);
    }

    /**
     * @param  resource  $source
     * @return resource
     */
    private function resizeImage($source, int $srcW, int $srcH, int $dstW, int $dstH, bool $hasAlpha)
    {
        $canvas = imagecreatetruecolor($dstW, $dstH);
        if ($hasAlpha) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $dstW, $dstH, $transparent);
        } else {
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefilledrectangle($canvas, 0, 0, $dstW, $dstH, $white);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

        return $canvas;
    }

    /**
     * @return resource|null
     */
    private function createImageResource(string $path, int $type)
    {
        return match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null,
            IMAGETYPE_BMP => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($path) : null,
            default => null,
        };
    }

    /**
     * @param  resource  $image
     */
    private function imageHasAlpha($image, int $width, int $height, int $type): bool
    {
        if ($type !== IMAGETYPE_PNG) {
            return false;
        }

        for ($x = 0; $x < min($width, 40); $x += max(1, (int) ($width / 40))) {
            for ($y = 0; $y < min($height, 40); $y += max(1, (int) ($height / 40))) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba & 0x7F000000) >> 24;
                if ($alpha > 0 && $alpha < 127) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param  resource  $image
     * @param  array{quality?: int, level?: int}  $options
     */
    private function writeTemp($image, string $format, array $options = []): string
    {
        $path = tempnam(sys_get_temp_dir(), 'staynets_img_');
        if ($path === false) {
            throw new RuntimeException('Unable to create temporary image file.');
        }

        if ($format === 'png') {
            imagepng($image, $path, $options['level'] ?? 6);
        } else {
            imagejpeg($image, $path, $options['quality'] ?? 85);
        }

        $this->tempFiles[] = $path;

        return $path;
    }

    private function buildOutputFilename(UploadedFile $file, string $compressedPath): string
    {
        $original = $file->getClientOriginalName();
        $mime = mime_content_type($compressedPath) ?: '';
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));

        if (str_contains($mime, 'jpeg') && ! in_array($extension, ['jpg', 'jpeg'], true)) {
            $base = pathinfo($original, PATHINFO_FILENAME);

            return $base.'.jpg';
        }

        if (str_contains($mime, 'png') && $extension !== 'png') {
            $base = pathinfo($original, PATHINFO_FILENAME);

            return $base.'.png';
        }

        return $original;
    }
}
