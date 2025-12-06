<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'partner_id',
        'name',
        'model',
        'fuel_type',
        'seats',
        'transmission',
        'price_per_day',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function rentals()
    {
        return $this->hasMany(CarRental::class);
    }
}
