<?php

namespace App\Http\Middleware;

use App\Services\ImageCompressionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class CompressUploadedImages
{
    public function __construct(
        private readonly ImageCompressionService $compressor
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->files->count() > 0) {
            $request->files->replace(
                $this->processFiles($request->allFiles())
            );
        }

        return $next($request);
    }

    /**
     * @param  array<string, mixed>  $files
     * @return array<string, mixed>
     */
    private function processFiles(array $files): array
    {
        $processed = [];

        foreach ($files as $key => $file) {
            if ($file instanceof UploadedFile) {
                $processed[$key] = $this->compressor->compressIfNeeded($file);
            } elseif (is_array($file)) {
                $processed[$key] = $this->processFiles($file);
            } else {
                $processed[$key] = $file;
            }
        }

        return $processed;
    }
}
