<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarRental extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_id',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'dropoff_date',
        'total_amount',
        'rental_status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
