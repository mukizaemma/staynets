<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_id',
        'company_name',
        'field_of_work',
        'career',
        'birth_date',
        'job_interest',
        'cv',
        'passport',
        'role_id',
        'country_origin_id',
        'country_work_id',
        'plan_id',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    // Hotel bookings
    public function hotelBookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    // Car rentals
    public function carRentals()
    {
        return $this->hasMany(CarRental::class);
    }

    // Tour bookings
    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    // Luggage bookings
    public function luggageBookings()
    {
        return $this->hasMany(LuggageBooking::class);
    }
    
}
