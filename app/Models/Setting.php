<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table ='settings';    

    protected $fillable =[
        'company',
        'address',
        'email',
        'phone',
        'address',
        'logo',
        'deliveryInfo',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'quote',
    ];
}
