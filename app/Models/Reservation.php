<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table='reservations';

    protected $fillable = [
        'names',
        'phone',
        'email',
        'nights',
        'guests',
        'message',
        'status',
        'facility_id',
        'room_id',
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function facility(){
        return $this->belongsTo(Facility::class);
    }
}
