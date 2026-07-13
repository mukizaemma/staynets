<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'partner_id',
        'added_by',
        'program_id',
        'name',
        'slug',
        'model',
        'fuel_type',
        'seats',
        'transmission',
        'price_per_day',
        'price_per_month',
        'price_to_buy',
        'currency',
        'image', // Cover image
        'images', // JSON array (for backward compatibility)
        'description',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Columns used on public fleet listing pages.
     * Skips columns that are not migrated yet (e.g. currency on older DBs).
     *
     * @return array<int, string>
     */
    public static function publicListColumns(): array
    {
        $columns = [
            'id', 'name', 'slug', 'model', 'image', 'price_per_day', 'price_per_month',
            'price_to_buy', 'currency', 'fuel_type', 'transmission', 'seats', 'description', 'created_at',
        ];

        try {
            if (! Schema::hasTable('cars')) {
                return ['id'];
            }

            return array_values(array_filter($columns, static function (string $column) {
                return Schema::hasColumn('cars', $column);
            }));
        } catch (\Throwable $e) {
            return array_values(array_filter($columns, static fn (string $column) => $column !== 'currency'));
        }
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function rentals()
    {
        return $this->hasMany(CarRental::class);
    }

    public function carImages()
    {
        return $this->hasMany(Carimage::class);
    }

    public function reviews()
    {
        return $this->hasMany(CarReview::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function getCurrencyCodeAttribute(): string
    {
        $code = $this->attributes['currency'] ?? null;

        return strtoupper($code ?: 'RWF');
    }

    public function getDisplayPriceAttribute()
    {
        if ($this->price_to_buy > 0) {
            return [
                'amount' => $this->price_to_buy,
                'label' => 'for sale',
                'currency' => $this->currency_code,
            ];
        }

        if ($this->price_per_day > 0) {
            return [
                'amount' => $this->price_per_day,
                'label' => '/day',
                'currency' => $this->currency_code,
            ];
        }

        if ($this->price_per_month > 0) {
            return [
                'amount' => $this->price_per_month,
                'label' => '/month',
                'currency' => $this->currency_code,
            ];
        }

        return null;
    }

    public function formattedPriceLine(): ?string
    {
        $price = $this->display_price;

        if (! $price) {
            return null;
        }

        return formatMoney($price['amount'], $price['currency']) . $price['label'];
    }
}
