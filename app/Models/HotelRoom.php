<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'slug',
        'room_type',
        'max_occupancy',
        'price_per_night',
        'total_rooms',
        'available_rooms',
        'amenities',
        'status',
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities()
    {
       
        return $this->belongsToMany(Amenity::class, 'amenity_hotel_room', 'hotel_room_id', 'amenity_id');
    }

    


    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'room_id');
    }
    public function images()
    {
        return $this->hasMany(HotelRoomImage::class, 'hotel_room_id');
    }




}

