<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;
    protected $table='amenities';

    protected $fillable = [
        'title',
        'icon',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function hotel()
    {
        return $this->belongsToMany(HotelRoom::class, 'amenity_hotel_room', 'amenity_id', 'hotel_room_id');
    }
}
