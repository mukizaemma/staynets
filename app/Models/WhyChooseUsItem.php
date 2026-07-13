<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class WhyChooseUsItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Safe for public pages when the migration has not been run yet.
     */
    public static function tableReady(): bool
    {
        try {
            return Schema::hasTable((new static)->getTable());
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function activeOrderedOrEmpty(): Collection
    {
        try {
            if (! static::tableReady()) {
                return collect();
            }

            return static::active()->ordered()->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}
