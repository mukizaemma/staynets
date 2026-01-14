<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'category_id',
        'program_id',
        'partner_id',
        'name',
        'slug',
        'property_type',
        'stars',
        'description',
        'address',
        'city',
        'location',
        'latitude',
        'longitude',
        'map_embed_code',
        'phone',
        'email',
        'website',
        'featured_image',
        'status',
        'is_featured',
        'is_verified',
        'meta_data',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'meta_data' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the property owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the category (destination)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the program (service)
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the partner
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get all units (rooms/apartments) for this property
     */
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get all property images
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    /**
     * Get all facilities/amenities for this property
     */
    public function facilities()
    {
        return $this->belongsToMany(Amenity::class, 'property_facilities', 'property_id', 'facility_id')
                    ->withTimestamps();
    }

    /**
     * Get all bookings for this property
     */
    public function bookings()
    {
        return $this->hasMany(HotelBooking::class, 'property_id');
    }

    /**
     * Get all reviews for this property
     */
    public function reviews()
    {
        return $this->hasMany(PropertyReview::class, 'property_id')->where('is_approved', true);
    }

    /**
     * Get average rating attribute
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews attribute
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get minimum price attribute (from units)
     */
    public function getMinPriceAttribute()
    {
        return $this->units()->min('base_price_per_night');
    }

    /**
     * Scope for hotels only
     */
    public function scopeHotels($query)
    {
        return $query->where('property_type', 'hotel');
    }

    /**
     * Scope for apartments only
     */
    public function scopeApartments($query)
    {
        return $query->where('property_type', 'apartment');
    }

    /**
     * Scope for active properties
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}


