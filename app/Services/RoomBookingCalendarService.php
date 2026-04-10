<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\HotelBooking;
use Carbon\Carbon;

class RoomBookingCalendarService
{
    /**
     * Build a month-by-month grid: for each room type row, counts of overlapping bookings per day.
     * Occupancy % row = sum(min(day_count, total_rooms)) / sum(total_rooms) * 100 per day.
     */
    public static function buildForHotel(Hotel $hotel, int $year): array
    {
        $hotel->loadMissing('rooms');
        $rooms = $hotel->rooms->sortBy('room_type')->values();

        $yearStart = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $yearEnd = Carbon::createFromDate($year, 12, 31)->endOfDay();

        $bookings = HotelBooking::query()
            ->where('hotel_id', $hotel->id)
            ->whereNotNull('room_id')
            ->where('booking_status', '!=', 'cancelled')
            ->whereDate('check_in', '<=', $yearEnd->toDateString())
            ->whereDate('check_out', '>', $yearStart->toDateString())
            ->get(['room_id', 'check_in', 'check_out']);

        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = (int) Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $monthStart = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $monthEnd = Carbon::createFromDate($year, $month, $daysInMonth)->endOfDay();

            $roomRows = [];
            $capacitySum = 0;

            foreach ($rooms as $room) {
                $capacity = max(1, (int) ($room->total_rooms ?? 1));
                $capacitySum += $capacity;
                $days = array_fill(1, $daysInMonth, 0);

                foreach ($bookings as $b) {
                    if ((int) $b->room_id !== (int) $room->id) {
                        continue;
                    }
                    $checkIn = Carbon::parse($b->check_in)->startOfDay();
                    $checkOut = Carbon::parse($b->check_out)->startOfDay();
                    $lastNight = $checkOut->copy()->subDay();

                    $cursor = $checkIn->copy()->max($monthStart);
                    while ($cursor->lte($lastNight) && $cursor->lte($monthEnd)) {
                        if ($cursor->month === $month && $cursor->year === $year) {
                            $d = $cursor->day;
                            if ($d >= 1 && $d <= $daysInMonth) {
                                $days[$d]++;
                            }
                        }
                        $cursor->addDay();
                    }
                }

                $roomRows[] = [
                    'id' => $room->id,
                    'label' => $room->room_type ?: 'Room #'.$room->id,
                    'total_rooms' => $capacity,
                    'days' => $days,
                ];
            }

            $occupancy = [];
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $bookedUnits = 0;
                foreach ($roomRows as $row) {
                    $bookedUnits += min((int) ($row['days'][$d] ?? 0), (int) $row['total_rooms']);
                }
                $occupancy[$d] = $capacitySum > 0
                    ? round(($bookedUnits / $capacitySum) * 100, 2)
                    : 0.0;
            }

            $months[$month] = [
                'name' => Carbon::createFromDate($year, $month, 1)->format('F'),
                'days_in_month' => $daysInMonth,
                'rooms' => $roomRows,
                'occupancy' => $occupancy,
            ];
        }

        return [
            'year' => $year,
            'hotel_id' => $hotel->id,
            'hotel_name' => $hotel->name,
            'months' => $months,
        ];
    }

    /**
     * @return array<int, array> hotel_id => buildForHotel payload
     */
    public static function buildForHotels(iterable $hotels, int $year): array
    {
        $out = [];
        foreach ($hotels as $hotel) {
            if ($hotel instanceof Hotel) {
                $out[$hotel->id] = self::buildForHotel($hotel, $year);
            }
        }

        return $out;
    }
}
