<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelBooking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'hotel_id',
        'property_id',
        'room_id',
        'unit_id',
        'check_in',
        'check_out',
        'guests_count',
        'guest_name',
        'guest_email',
        'guest_country',
        'guest_phone',
        'special_requests',
        'total_amount',
        'payment_status',
        'booking_status',
        'reference_number',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room()
    {
        return $this->belongsTo(HotelRoom::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
