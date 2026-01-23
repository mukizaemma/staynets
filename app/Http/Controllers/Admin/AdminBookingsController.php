<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class AdminBookingsController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = HotelBooking::with(['user', 'property', 'unit']);

        // Filter by booking status
        if ($request->has('status') && $request->status) {
            $query->where('booking_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by property
        if ($request->has('property_id') && $request->property_id) {
            $query->where('property_id', $request->property_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%$search%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                  });
            });
        }

        $bookings = $query->latest()->paginate(20);
        $properties = Property::active()->get();
        $setting = \App\Models\Setting::first();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'properties' => $properties,
            'setting' => $setting,
        ]);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = HotelBooking::with(['user', 'property', 'unit'])->findOrFail($id);
        $setting = \App\Models\Setting::first();

        return view('admin.bookings.show', [
            'booking' => $booking,
            'setting' => $setting,
        ]);
    }

    /**
     * Update booking status (approve/reject).
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = HotelBooking::findOrFail($id);

        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'nullable|in:pending,paid,refunded',
        ]);

        $booking->update([
            'booking_status' => $request->booking_status,
            'payment_status' => $request->payment_status ?? $booking->payment_status,
        ]);

        // If confirmed, update unit availability
        if ($request->booking_status === 'confirmed' && $booking->unit_id) {
            $unit = Unit::find($booking->unit_id);
            if ($unit && $unit->available_units > 0) {
                $unit->decrement('available_units');
            }
        }

        // If cancelled, restore unit availability
        if ($request->booking_status === 'cancelled' && $booking->unit_id) {
            $unit = Unit::find($booking->unit_id);
            if ($unit) {
                $unit->increment('available_units');
            }
        }

        return redirect()->back()
            ->with('success', 'Booking status updated successfully');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy($id)
    {
        $booking = HotelBooking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully');
    }
}










