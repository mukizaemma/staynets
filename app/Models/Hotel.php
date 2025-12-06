<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'partner_id',
        'category_id',
        'program_id',
        'added_by',
        'type',
        'slug',
        'name',
        'address',
        'phone',
        'email',
        'description',
        'image',
        'city',
        'stars',
        'location',
        'latitude',
        'longitude',
        'description',
        'status',
    ];

    public function destination()
    {
        return $this->belongsTo(Category::class);
    }
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class);
    }
}
