<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ListingAgreementSignature extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING = 'pending_approval';

    public const STATUS_SIGNED = 'signed';

    protected $fillable = [
        'signable_id',
        'signable_type',
        'status',
        'owner_signature_path',
        'host_printed_name',
        'start_date',
        'admin_signature_path',
        'admin_approved_at',
        'admin_approved_by',
        'admin_notes',
        'signed_at',
        'template_version_at',
        'signer_ip',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'template_version_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'start_date' => 'date',
    ];

    public function signable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isFullySigned(): bool
    {
        return $this->status === self::STATUS_SIGNED
            && $this->signed_at
            && $this->owner_signature_path
            && ($this->admin_signature_path || $this->resolvePlatformSignaturePath());
    }

    public function isPendingApproval(): bool
    {
        return $this->status === self::STATUS_PENDING && $this->owner_signature_path;
    }

    public function resolvePlatformSignaturePath(): ?string
    {
        if ($this->admin_signature_path) {
            return $this->admin_signature_path;
        }

        $template = ListingAgreementTemplate::query()->first();

        return $template?->platform_signature_path;
    }

    public function isCurrentForTemplate(?ListingAgreementTemplate $template): bool
    {
        if (! $template || ! $this->isFullySigned() || ! $this->template_version_at) {
            return false;
        }

        return abs($template->updated_at->getTimestamp() - $this->template_version_at->getTimestamp()) < 2;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_SIGNED => 'Signed',
            self::STATUS_PENDING => 'Pending approval',
            default => 'Draft',
        };
    }
}
