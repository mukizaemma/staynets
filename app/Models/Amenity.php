<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'amenities';

    protected $fillable = [
        'title',
        'icon',
        'facility_category_id',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the facility category
     */
    public function category()
    {
        return $this->belongsTo(FacilityCategory::class, 'facility_category_id');
    }

    /**
     * Get all properties that have this facility
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_facilities', 'facility_id', 'property_id')
                    ->withTimestamps();
    }

    /**
     * Get all units that have this facility
     */
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_facilities', 'facility_id', 'unit_id')
                    ->withTimestamps();
    }

    /**
     * Legacy relationships for backward compatibility
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function hotel()
    {
        return $this->belongsToMany(HotelRoom::class, 'amenity_hotel_rooms', 'amenity_id', 'hotel_room_id');
    }

    /**
     * Scope for active facilities
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
