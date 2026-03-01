<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaynetsInvoiceBooking extends Model
{
    protected $table = 'staynets_invoice_bookings';

    protected $fillable = [
        'staynets_invoice_id',
        'hotel_booking_id',
        'booking_total',
        'commission',
    ];

    protected $casts = [
        'booking_total' => 'decimal:2',
        'commission' => 'decimal:2',
    ];

    public function staynetsInvoice()
    {
        return $this->belongsTo(StaynetsInvoice::class, 'staynets_invoice_id');
    }

    public function hotelBooking()
    {
        return $this->belongsTo(HotelBooking::class, 'hotel_booking_id');
    }
}
