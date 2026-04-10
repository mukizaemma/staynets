<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Services\RoomBookingCalendarService;
use Illuminate\Http\Request;

class AdminBookingCalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $year = max(2020, min(2035, $year));

        $hotelId = $request->input('hotel_id', 'all');

        $hotelsList = Hotel::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $calendars = [];

        if ($hotelId === null || $hotelId === '' || $hotelId === 'all') {
            $hotels = Hotel::query()->with('rooms')->orderBy('name')->get();
            foreach ($hotels as $hotel) {
                $calendars[] = RoomBookingCalendarService::buildForHotel($hotel, $year);
            }
        } else {
            $hotel = Hotel::query()->findOrFail((int) $hotelId);
            $calendars[] = RoomBookingCalendarService::buildForHotel($hotel, $year);
        }

        return view('admin.booking-calendar.index', [
            'calendars' => $calendars,
            'year' => $year,
            'hotelId' => $hotelId,
            'hotelsList' => $hotelsList,
        ]);
    }
}
