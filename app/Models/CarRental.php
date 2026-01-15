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
        'booking_type', // 'view_car', 'rent', 'buy'
        'name',
        'email',
        'phone',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'dropoff_date',
        'preferred_date', // For viewing appointments
        'preferred_time', // For viewing appointments
        'message',
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
