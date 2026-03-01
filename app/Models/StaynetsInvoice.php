<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaynetsInvoice extends Model
{
    protected $table = 'staynets_invoices';

    protected $fillable = [
        'invoice_number',
        'property_id',
        'period_start',
        'period_end',
        'total_booking_amount',
        'commission_amount',
        'status',
        'created_by',
        'sent_at',
        'notes',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'sent_at' => 'datetime',
        'total_booking_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoiceBookings()
    {
        return $this->hasMany(StaynetsInvoiceBooking::class, 'staynets_invoice_id');
    }

    public function hotelBookings()
    {
        return $this->belongsToMany(HotelBooking::class, 'staynets_invoice_bookings', 'staynets_invoice_id', 'hotel_booking_id')
            ->withPivot(['booking_total', 'commission'])
            ->withTimestamps();
    }
}
