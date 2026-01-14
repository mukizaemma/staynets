<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'added_by',
        'slug',
        'room_type',
        'image',
        'max_occupancy',
        'price_per_night',
        'total_rooms',
        'available_rooms',
        'description',
        'amenities',
        'status',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
         'amenities' => 'array',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/images/rooms/' . $this->image) : asset('assets/img/tour/tour_3_1.jpg');
    }

    public function amenities()
    {
       
        return $this->belongsToMany(Amenity::class, 'amenity_hotel_rooms', 'hotel_room_id', 'amenity_id');
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

