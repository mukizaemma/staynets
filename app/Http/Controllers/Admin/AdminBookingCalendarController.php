<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Property;
use App\Services\RoomBookingCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingCalendarController extends Controller
{
    protected function isPropertySuperAdmin(): bool
    {
        $user = Auth::user();

        return $user && ($user->role == '1' || $user->role === 1);
    }

    protected function ensureVerifiedForPropertyManagers(): ?\Illuminate\Http\RedirectResponse
    {
        if ($this->isPropertySuperAdmin()) {
            return null;
        }
        $user = Auth::user();
        if ($user && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('error', 'Please verify your email address before managing properties and rooms.');
        }

        return null;
    }

    protected function manageableHotelsQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $q = Hotel::query()->orderBy('name');
        if (! $this->isPropertySuperAdmin()) {
            $q->where('added_by', Auth::id());
        }

        return $q;
    }

    protected function manageablePropertiesQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $q = Property::query()->orderBy('name');
        if (! $this->isPropertySuperAdmin()) {
            $q->where('owner_id', Auth::id());
        }

        return $q;
    }

    protected function userMayAccessHotel(Hotel $hotel): bool
    {
        if ($this->isPropertySuperAdmin()) {
            return true;
        }

        return (int) $hotel->added_by === (int) Auth::id();
    }

    protected function userMayAccessProperty(Property $property): bool
    {
        if ($this->isPropertySuperAdmin()) {
            return true;
        }

        return (int) $property->owner_id === (int) Auth::id();
    }

    /**
     * Parse listing filter: "all", "h-{hotelId}", "p-{propertyId}".
     * Legacy: hotel_id query (numeric) maps to h-{id}.
     */
    protected function resolveListing(Request $request): string
    {
        $listing = $request->input('listing');
        $legacyHotelId = $request->input('hotel_id');

        if (($listing === null || $listing === '') && $legacyHotelId !== null && $legacyHotelId !== '' && $legacyHotelId !== 'all') {
            return 'h-'.(int) $legacyHotelId;
        }

        if ($listing === null || $listing === '') {
            return 'all';
        }

        return is_string($listing) ? $listing : 'all';
    }

    public function index(Request $request)
    {
        if ($redirect = $this->ensureVerifiedForPropertyManagers()) {
            return $redirect;
        }

        $year = (int) $request->input('year', now()->year);
        $year = max(2020, min(2035, $year));

        $listing = $this->resolveListing($request);
        if ($listing !== 'all' && ! str_starts_with($listing, 'h-') && ! str_starts_with($listing, 'p-')) {
            $listing = 'all';
        }

        $calendarView = $request->input('calendar_view', RoomBookingCalendarService::VIEW_UPCOMING);
        if (! in_array($calendarView, [RoomBookingCalendarService::VIEW_UPCOMING, RoomBookingCalendarService::VIEW_HISTORY], true)) {
            $calendarView = RoomBookingCalendarService::VIEW_UPCOMING;
        }

        $hotelsList = $this->manageableHotelsQuery()->get(['id', 'name']);
        $propertiesList = $this->manageablePropertiesQuery()->get(['id', 'name']);

        $calendars = [];

        $appendCalendarSorted = function (array &$bucket, iterable $hotels, iterable $properties, int $year) use ($calendarView): void {
            $entries = [];
            foreach ($hotels as $hotel) {
                $entries[] = [
                    'sort' => $hotel->name,
                    'payload' => RoomBookingCalendarService::buildForHotel($hotel, $year, $calendarView),
                ];
            }
            foreach ($properties as $property) {
                $entries[] = [
                    'sort' => $property->name,
                    'payload' => RoomBookingCalendarService::buildForProperty($property, $year, $calendarView),
                ];
            }
            usort($entries, static function ($a, $b) {
                return strcasecmp($a['sort'], $b['sort']);
            });
            foreach ($entries as $e) {
                $bucket[] = $e['payload'];
            }
        };

        if ($listing === 'all') {
            $hotels = $this->manageableHotelsQuery()->with('rooms')->get();
            $properties = $this->manageablePropertiesQuery()->with(['units.unitType'])->get();
            $appendCalendarSorted($calendars, $hotels, $properties, $year);
        } elseif (str_starts_with($listing, 'h-')) {
            $id = (int) substr($listing, 2);
            $hotel = $this->manageableHotelsQuery()->with('rooms')->whereKey($id)->firstOrFail();
            if (! $this->userMayAccessHotel($hotel)) {
                abort(403);
            }
            $calendars[] = RoomBookingCalendarService::buildForHotel($hotel, $year, $calendarView);
        } elseif (str_starts_with($listing, 'p-')) {
            $id = (int) substr($listing, 2);
            $property = $this->manageablePropertiesQuery()->with(['units.unitType'])->whereKey($id)->firstOrFail();
            if (! $this->userMayAccessProperty($property)) {
                abort(403);
            }
            $calendars[] = RoomBookingCalendarService::buildForProperty($property, $year, $calendarView);
        }

        return view('admin.booking-calendar.index', [
            'calendars' => $calendars,
            'year' => $year,
            'listing' => $listing,
            'calendarView' => $calendarView,
            'hotelsList' => $hotelsList,
            'propertiesList' => $propertiesList,
        ]);
    }
}
