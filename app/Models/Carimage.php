<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carimage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'car_id',
        'image',
        'caption',
        'added_by',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
