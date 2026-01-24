<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Blog;
use App\Models\Car;
use App\Models\CarRental;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Property;
use App\Models\HotelBooking;
use App\Models\Leftbag;
use App\Models\Ticketing;
use App\Models\HotelRoom;
use App\Models\Category;
use App\Models\Trip;
use App\Models\About;
use App\Models\Slide;
use App\Models\Review;
use App\Models\Message;
use App\Models\Program;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Facility;
use App\Models\Promotion;
use App\Models\Subscriber;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingNotification;
use App\Mail\BookingConfirmation;
use App\Mail\AdminNotification;
use Illuminate\Support\Collection;


class HomeController extends Controller
{
    public function index(Request $request)
    {

        $slides = Slide::oldest()->get();
        $category = Category::all();
        $hotels = Hotel::latest()->get();
        $services = Program::oldest()->get();
        $rooms = HotelRoom::oldest()->get();
        $articles = Blog::latest()->paginate(3);
        $trips = Trip::with('images')->oldest()->take(3)->get();
        $locations = Hotel::whereNotNull('location')->where('status', 'Active')->distinct()->pluck('location');
        if ($locations->isEmpty()) {
            $locations = Property::whereNotNull('location')->where('status', 'Active')->distinct()->pluck('location');
        }

        // Get destinations (categories) with hotel/property counts
        $destinations = Category::where('status', 'Active')
            ->withCount([
                'hotels' => function($query) {
                    $query->where('status', 'Active');
                },
                'properties' => function($query) {
                    $query->where('status', 'Active')
                          ->where('property_type', 'hotel');
                }
            ])
            ->where(function($query) {
                $query->whereHas('hotels', function($q) {
                    $q->where('status', 'Active');
                })->orWhereHas('properties', function($q) {
                    $q->where('status', 'Active')
                      ->where('property_type', 'hotel');
                });
            })
            ->oldest()
            ->get();

        // Get latest 3 properties (prefer Property model, fallback to Hotel)
        $latestProperties = Property::where('status', 'Active')
            ->with(['units' => function($q) {
                $q->where('status', 'Available')->orderBy('base_price_per_night', 'asc');
            }, 'reviews'])
            ->latest()
            ->take(3)
            ->get();

        if ($latestProperties->isEmpty()) {
            $latestProperties = Hotel::where('status', 'Active')
                ->with(['rooms' => function($q) {
                    $q->where('status', 'Active')->orderBy('price_per_night', 'asc');
                }, 'reviews'])
                ->latest()
                ->take(3)
                ->get();
        }

        // Get latest 3 trip activities
        $popularTrips = Trip::where('status', 'Active')
            ->with(['images', 'reviews', 'destination'])
            ->latest()
            ->take(3)
            ->get();

        // Get general business reviews (testimonials) - only approved ones, limit to 4
        $businessReviews = Review::where('is_approved', true)
            ->with(['user', 'images'])
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.index',[
            'slides'=>$slides,
            'hotels'=>$hotels,
            'rooms'=>$rooms,
            'articles'=>$articles,
            'trips'=>$trips,
            'services'=>$services,
            'locations'=>$locations,
            'destinations'=>$destinations,
            'latestProperties'=>$latestProperties,
            'popularTrips'=>$popularTrips,
            'businessReviews'=>$businessReviews,
            
        ]);

    }

public function hotelsSearch(Request $request)
{
    $q = $request->input('q');
    $city = $request->input('city');
    $address = $request->input('address');
    $location = $request->input('location');
    $propertyType = $request->input('property_type');
    $guests = $request->input('guests');
    $checkin = $request->input('checkin');
    $checkout = $request->input('checkout');
    $orderby = $request->input('orderby');

    $query = Property::query()
        ->where('status', 'Active');

    // Filter by property type
    if (!empty($propertyType)) {
        $query->where('property_type', $propertyType);
    }

    // Search by name
    if (!empty($q)) {
        $query->where('name', 'like', "%{$q}%");
    }

    // Filter by city
    if (!empty($city)) {
        $query->where('city', 'like', "%{$city}%");
    }

    // Filter by location/destination
    if (!empty($location)) {
        $query->where(function ($q) use ($location) {
            $q->where('location', 'like', "%{$location}%")
              ->orWhere('city', 'like', "%{$location}%");
        });
    }

    // Filter by address
    if (!empty($address)) {
        $query->where(function ($q) use ($address) {
            $q->where('address', 'like', "%{$address}%")
              ->orWhere('location', 'like', "%{$address}%");
        });
    }

    // Filter by guests (if units relationship exists, filter properties with available units)
    // This is a basic implementation - you may want to enhance this based on your Unit model
    if (!empty($guests)) {
        // For now, we'll just store this in session for later use in booking
        session(['search_guests' => $guests]);
    }

    // Store check-in/check-out dates in session for booking flow
    if (!empty($checkin)) {
        session(['search_checkin' => $checkin]);
    }
    if (!empty($checkout)) {
        session(['search_checkout' => $checkout]);
    }

    // Ordering
    switch ($orderby) {
        case 'date':
            $query->orderBy('created_at', 'desc');
            break;

        case 'price':
            $query->orderBy('name', 'asc'); // replace when price exists
            break;

        case 'price-desc':
            $query->orderBy('name', 'desc');
            break;

        case 'rating':
            $query->orderBy('stars', 'desc');
            break;

        default:
            $query->latest();
    }

    $rooms = $query->paginate(12)->appends($request->query());

    // AJAX response
    if ($request->ajax()) {
        $html = view('frontend.partials.accommodations_results', compact('rooms'))->render();
        return response()->json(['html' => $html]);
    }

    return view('frontend.hotelsSearch', compact('rooms'));
}


    public function hotels(Request $request)
{
    $query = Property::query()
        ->where('status', 'Active')
        ->where('property_type', 'hotel');

    // Enhanced search: search by name OR location when q is provided
    if ($request->filled('q')) {
        $searchTerm = $request->q;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('location', 'like', '%' . $searchTerm . '%')
              ->orWhere('city', 'like', '%' . $searchTerm . '%')
              ->orWhere('address', 'like', '%' . $searchTerm . '%');
        });
    }

    // Search by location or city (separate filter)
    if ($request->filled('location')) {
        $query->where(function ($q) use ($request) {
            $q->where('location', 'like', '%' . $request->location . '%')
              ->orWhere('city', 'like', '%' . $request->location . '%');
        });
    }

    // Optional: filter by category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Ordering
    $orderby = $request->input('orderby', 'menu_order');
    switch ($orderby) {
        case 'date':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price':
            $query->orderBy('name', 'asc'); // Replace when price exists
            break;
        case 'price-desc':
            $query->orderBy('name', 'desc');
            break;
        case 'rating':
            $query->orderBy('stars', 'desc');
            break;
        case 'popularity':
            // You can implement popularity based on bookings/views
            $query->orderBy('created_at', 'desc');
            break;
        default:
            $query->latest();
    }

    $rooms = $query->with('units')->paginate(12)->appends($request->query());

    // Get unique locations for the search dropdown
    $locations = Property::where('status', 'Active')
        ->where('property_type', 'hotel')
        ->whereNotNull('location')
        ->where('location', '!=', '')
        ->distinct()
        ->pluck('location')
        ->filter()
        ->sort()
        ->values()
        ->toArray();

    // Also include cities
    $cities = Property::where('status', 'Active')
        ->where('property_type', 'hotel')
        ->whereNotNull('city')
        ->where('city', '!=', '')
        ->distinct()
        ->pluck('city')
        ->filter()
        ->sort()
        ->values()
        ->toArray();

    // Merge and remove duplicates
    $allLocations = array_unique(array_merge($locations, $cities));
    sort($allLocations);

    // AJAX response
    if ($request->ajax()) {
        $html = view('frontend.partials.hotels_results', compact('rooms'))->render();
        return response()->json(['html' => $html]);
    }

    return view('frontend.hotels', compact('rooms', 'allLocations'));
}


    public function apartments(Request $request)
    {
        $q = $request->input('q');
        $orderby = $request->input('orderby');
        $query = Property::query()
            ->where('status', 'Active')
            ->where('property_type', 'apartment');

        if (!empty($q)) {
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('name', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                        ->orWhere('city', 'like', "%{$q}%");
            });
        }

        // ordering
        switch ($orderby) {
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price':
                $query->orderBy('name', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating':
                $query->orderBy('stars', 'desc');
                break;
            case 'popularity':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest();
        }

        $properties = $query->with('units')->paginate(12)->appends($request->query());

        // Get unique locations for the search dropdown (apartments)
        $locations = Property::where('status', 'Active')
            ->where('property_type', 'apartment')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->pluck('location')
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        // Also include cities
        $cities = Property::where('status', 'Active')
            ->where('property_type', 'apartment')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        // Merge and remove duplicates
        $allLocations = array_unique(array_merge($locations, $cities));
        sort($allLocations);

        if ($request->ajax()) {
            // render the partial view and return HTML
            $html = view('frontend.partials.hotels_results', compact('properties'))->render();
            return response()->json(['html' => $html]);
        }

        return view('frontend.hotels', [
            'rooms' => $properties, // Keep 'rooms' for backward compatibility with view
            'allLocations' => $allLocations,
        ]);
    
    }



    public function showCars(Request $request)
    {
        $q = $request->input('q');
        $orderby = $request->input('orderby');

        $query = Car::query()
            ->where('status', 'available')
            ->with('images'); // Eager load images for better performance

        if (!empty($q)) {
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                ->orWhere('model', 'like', "%{$q}%")
                ->orWhere('fuel_type', 'like', "%{$q}%")
                ->orWhere('transmission', 'like', "%{$q}%");
            });
        }

        switch ($orderby) {
            case 'price':
                $query->orderBy('price_per_day', 'asc');
                break;

            case 'price-desc':
                $query->orderBy('price_per_day', 'desc');
                break;

            case 'date':
            default:
                $query->latest();
        }

        $cars = $query->paginate(12)->appends($request->query());

        if ($request->ajax()) {
            $html = view('frontend.partials.cars_results', compact('cars'))->render();
            return response()->json(['html' => $html]);
        }

        return view('frontend.cars', compact('cars'));
    }

    public function carDetails($slug){
        $car = Car::with('images')->where('slug', $slug)->firstOrFail();

        $images = $car->images;
        $allCars = Car::where('id','!=',$car->id)->where('status', 'available')->limit(3)->get();
        return view('frontend.carDetails',[
            'car'=>$car,
            'images'=>$images,
            'allCars'=>$allCars,
        ]);
    }

    public function storeCarBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'car_id' => 'required|exists:cars,id',
                'booking_type' => 'required|in:view_car,rent,buy',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:50',
                'preferred_date' => 'required_if:booking_type,view_car|nullable|date|after_or_equal:today',
                'preferred_time' => 'nullable',
                'pickup_date' => 'required_if:booking_type,rent|nullable|date|after_or_equal:today',
                'dropoff_date' => 'required_if:booking_type,rent|nullable|date|after:pickup_date',
                'pickup_location' => 'nullable|string|max:255',
                'dropoff_location' => 'nullable|string|max:255',
                'message' => 'nullable|string|max:1000',
            ], [
                'car_id.required' => 'Car ID is required.',
                'car_id.exists' => 'Selected car does not exist.',
                'booking_type.required' => 'Please select a booking type.',
                'booking_type.in' => 'Invalid booking type selected.',
                'name.required' => 'Your name is required.',
                'email.required' => 'Your email is required.',
                'email.email' => 'Please enter a valid email address.',
                'phone.required' => 'Your phone number is required.',
                'preferred_date.required_if' => 'Preferred date is required for viewing appointments.',
                'preferred_date.after_or_equal' => 'Preferred date must be today or later.',
                'pickup_date.required_if' => 'Pickup date is required for rentals.',
                'pickup_date.after_or_equal' => 'Pickup date must be today or later.',
                'dropoff_date.required_if' => 'Drop-off date is required for rentals.',
                'dropoff_date.after' => 'Drop-off date must be after pickup date.',
            ]);

            $car = Car::findOrFail($request->car_id);
            
            // Calculate total amount if rent
            $totalAmount = null;
            if ($request->booking_type === 'rent' && $request->pickup_date && $request->dropoff_date) {
                $pickup = new \DateTime($request->pickup_date);
                $dropoff = new \DateTime($request->dropoff_date);
                $days = $pickup->diff($dropoff)->days;
                
                if ($days > 0) {
                    if ($days >= 30 && $car->price_per_month) {
                        $months = floor($days / 30);
                        $remainingDays = $days % 30;
                        $totalAmount = ($months * $car->price_per_month) + ($remainingDays * $car->price_per_day);
                    } elseif ($car->price_per_day) {
                        $totalAmount = $days * $car->price_per_day;
                    }
                }
            } elseif ($request->booking_type === 'buy' && $car->price_to_buy) {
                $totalAmount = $car->price_to_buy;
            }

            // Create booking
            $booking = \App\Models\CarRental::create([
                'car_id' => $car->id,
                'user_id' => auth()->id() ?? null,
                'booking_type' => $request->booking_type,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'preferred_date' => $request->preferred_date,
                'preferred_time' => $request->preferred_time,
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'pickup_date' => $request->pickup_date,
                'dropoff_date' => $request->dropoff_date,
                'message' => $request->message,
                'total_amount' => $totalAmount,
                'rental_status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Notify all admins (role = 1)
            $admins = \App\Models\User::where('role', 1)->get();
            if ($admins->isNotEmpty()) {
                $bookingTypeLabel = match($request->booking_type) {
                    'view_car' => 'View Car Request',
                    'rent' => 'Car Rental Booking',
                    'buy' => 'Car Purchase Request',
                    default => 'Car Booking'
                };

                $adminDetails = [
                    'subject' => 'New Car Booking Request: ' . $bookingTypeLabel,
                    'greeting' => 'Hello Admin,',
                    'body' => "A new car booking request has been submitted.\n\n"
                             . "Car: {$car->name}\n"
                             . "Booking Type: {$bookingTypeLabel}\n"
                             . "Customer: {$request->name} ({$request->email})\n"
                             . "Phone: {$request->phone}\n"
                             . ($totalAmount ? "Total Amount: " . number_format($totalAmount) . " RWF\n" : "")
                             . "\nYou can view and manage this booking in the admin panel:\n"
                             . route('admin.carBookings.index'),
                    'lastline' => 'Please log in to review and respond to this booking request.',
                ];

                foreach ($admins as $admin) {
                    Mail::to($admin->email)
                        ->send(new AdminNotification($adminDetails));
                }
            }

            return redirect()->route('carDetails', $car->slug)
                ->with('success', 'Your booking request has been submitted successfully! We will contact you soon.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Car booking error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong. Please try again: ' . $e->getMessage());
        }
    }


    public function about(){
        $rooms = HotelRoom::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.about',[
            'rooms'=>$rooms,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function leftBags(){
        $data = Leftbag::first();
        $trips = Trip::oldest()->get();
        return view('frontend.leftBags',[
            'data'=>$data,
            'trips'=>$trips,
        ]);
    }

    public function leftBagsRequest(){
        $data = Leftbag::first();
        $trips = Trip::oldest()->get();
        return view('frontend.leftBagsRequest',[
            'data'=>$data,
            'trips'=>$trips,
        ]);
    }

    public function ticketing(){
        $data = Ticketing::first();
        $trips = Trip::oldest()->get();
        return view('frontend.ticketing',[
            'data'=>$data,
            'trips'=>$trips,
        ]);
    }

    public function ticketingRequest(){
        $data = Ticketing::first();
        $trips = Trip::oldest()->get();
        return view('frontend.ticketingRequest',[
            'data'=>$data,
            'trips'=>$trips,
        ]);
    }

    public function services(){
        $services = Program::oldest()->get();
        $trips = Trip::oldest()->get();
        return view('frontend.services',[
            'services'=>$services,
            'trips'=>$trips,
        ]);
    }

    public function service($slug)
    {
        $service = Program::where('slug', $slug)->firstOrFail();
        $hotels = $service->hotels;
        $trips = Trip::Oldest()->get();                         
        return view('frontend.service', [

            'hotels' => $hotels,
            'trips' => $trips,
            'service' => $service,
        ]);
    }

public function accommodations(Request $request)
{
    $q = $request->input('q');
    $orderby = $request->input('orderby');

    // base query: only active hotels (optional)
    $query = \App\Models\Hotel::query()->where('status', 'Active');

    // search by name or location or city
    if (!empty($q)) {
        $query->where(function($qbuilder) use ($q) {
            $qbuilder->where('name', 'like', "%{$q}%")
                     ->orWhere('location', 'like', "%{$q}%")
                     ->orWhere('city', 'like', "%{$q}%");
        });
    }

    // ordering
    switch ($orderby) {
        case 'date':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price':
            // assumes you have hotel min price computed, otherwise skip or join rooms; fallback to name
            $query->orderBy('name', 'asc');
            break;
        case 'price-desc':
            $query->orderBy('name', 'desc');
            break;
        case 'rating':
            // if you have ratings column, order by it; otherwise fallback
            $query->orderBy('name', 'asc');
            break;
        default:
            $query->oldest();
    }

    // paginate (12 per page - adjust as needed)
    $rooms = $query->paginate(12)->appends($request->query());

    // If AJAX: return only the partial HTML used to inject into the page
    if ($request->ajax()) {
        // render the partial view and return HTML
        $html = view('frontend.partials.accommodations_results', compact('rooms'))->render();
        return response()->json(['html' => $html]);
    }

    // non-AJAX: normal full page
    // $trips = \App\Models\Trip::oldest()->get();
    return view('frontend.accommodations', [
        // 'trips' => $trips,
        'rooms' => $rooms,
    ]);
}

public function showAccommodation(Request $request, $slug)
{
    $hotel = Property::with([
        'units' => function($q) {
            $q->where('status', 'Available')
                ->with(['images', 'facilities'])
                ->orderBy('base_price_per_night', 'asc');
        },
        'images' => function($q) {
            $q->orderBy('is_primary', 'desc')->orderBy('sort_order');
        },
        'facilities.category' => function($q) {
            $q->where('is_active', true);
        },
        'reviews' => function($q) {
            $q->latest()->take(10);
        },
        'owner',
        'category'
    ])
    ->where(function($q) use ($slug) {
        if (is_numeric($slug)) {
            $q->where('id', $slug);
        } else {
            $q->where('slug', $slug);
        }
    })
    ->where('status', 'Active') 
    ->firstOrFail();

    // Group amenities by category
    $amenitiesByCategory = $hotel->facilities->groupBy('facility_category_id')->map(function($amenities) {
        return $amenities->first()->category ?? null;
    })->filter();

    return view('frontend.accommodation', [
        'hotel' => $hotel,
        'rooms' => $hotel->units,
        'amenitiesByCategory' => $amenitiesByCategory,
    ]);
}

/**
 * Store a booking for a property unit
 */
public function storeBooking(Request $request)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'unit_id' => 'required|exists:units,id',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'guests_count' => 'required|integer|min:1',
    ]);

    // Check if user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to make a booking.');
    }

    // Check if email is verified
    if (!Auth::user()->hasVerifiedEmail()) {
        return redirect()->back()->with('error', 'Please verify your email address before making a booking. Check your inbox for the verification link.');
    }

    // Get unit to calculate price
    $unit = \App\Models\Unit::findOrFail($request->unit_id);
    $property = Property::findOrFail($request->property_id);

    // Verify unit belongs to property
    if ($unit->property_id != $property->id) {
        return redirect()->back()->with('error', 'Invalid unit for this property.');
    }

    // Calculate number of nights
    $checkIn = new \DateTime($request->check_in);
    $checkOut = new \DateTime($request->check_out);
    $nights = $checkIn->diff($checkOut)->days;

    // Calculate total amount
    $pricePerNight = $unit->base_price_per_night ?? 0;
    $totalAmount = $pricePerNight * $nights;

    // Generate reference number
    $referenceNumber = 'BK' . strtoupper(uniqid());

    // Create booking
    $booking = HotelBooking::create([
        'user_id' => Auth::id(),
        'hotel_id' => null, // Using property_id instead for new system
        'property_id' => $request->property_id,
        'room_id' => null, // Using unit_id instead for new system
        'unit_id' => $request->unit_id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'guests_count' => $request->guests_count,
        'total_amount' => $totalAmount,
        'reference_number' => $referenceNumber,
        'payment_status' => 'pending',
        'booking_status' => 'pending',
    ]);

    // Load relationships for email
    $booking->load(['user', 'property', 'unit']);

    // Send email notification to admin
    try {
        Mail::to('info@iremetech.com')->send(new BookingNotification($booking));
    } catch (\Exception $e) {
        // Log error but don't fail the booking
        \Log::error('Failed to send admin booking notification: ' . $e->getMessage());
    }

    // Send confirmation email to client
    try {
        Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
    } catch (\Exception $e) {
        // Log error but don't fail the booking
        \Log::error('Failed to send client booking confirmation: ' . $e->getMessage());
    }

    return redirect()->route('hotel', $property->slug)->with('success', 'Booking submitted successfully! Reference: ' . $referenceNumber . '. We will contact you soon to confirm your booking.');
}


    public function destinations()
    {
        $destinations = Category::oldest()->get();
        $trips = Trip::oldest()->get();

        return view('frontend.destinations', [
            'trips' => $trips,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Show a destination page with its properties and filters.
     */
    public function destination(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Base query: all active hotels/properties under this destination
        $query = $category
            ->hotels()
            ->where('status', 'Active')
            ->with([
                'rooms' => function ($q) {
                    $q->where('status', 'Active')
                      ->orderBy('price_per_night', 'asc');
                },
                'reviews',
            ]);

        // Filter by property type (stored on hotels.type), e.g. hotel, apartment, etc.
        $propertyType = $request->input('property_type');
        if (!empty($propertyType) && $propertyType !== 'all') {
            $query->where('type', $propertyType);
        }

        // Search by name / location / city within this destination
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($qbuilder) use ($search) {
                $qbuilder->where('name', 'like', '%' . $search . '%')
                         ->orWhere('location', 'like', '%' . $search . '%')
                         ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        // Sort newest first
        $hotels = $query
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->query());

        // Get tour activities for this destination
        $trips = Trip::where('status', 'Active')
            ->where('category_id', $category->id)
            ->with(['images', 'reviews', 'destination'])
            ->latest()
            ->get();

        return view('frontend.destination', [
            'trips' => $trips,
            'category' => $category,
            'hotels' => $hotels,
        ]);
    }

public function hotelRooms($hotelSlug)
{
    $hotel = Hotel::where('slug', $hotelSlug)->firstOrFail();

    $rooms = $hotel->rooms()
        ->where('status', 'Available')
        ->orderBy('price_per_night', 'asc')
        ->paginate(12);

    $trips = Trip::oldest()->get();

    return view('frontend.hotelRooms', [
        'hotel' => $hotel,
        'rooms' => $rooms,
        'trips' => $trips,
    ]);
}

public function roomDetails($hotelSlug, $roomSlug)
{
    $hotel = Hotel::where('slug', $hotelSlug)->firstOrFail();

    $room = HotelRoom::where('hotel_id', $hotel->id)
        ->where('slug', $roomSlug)
        ->firstOrFail();

    $images = [];

    if (!empty($room->image)) {
        $decoded = json_decode($room->image, true);
        if (is_array($decoded)) {
            $images = $decoded;
        } else {
            if (strpos($room->image, ',') !== false) {
                $images = array_map('trim', explode(',', $room->image));
            } elseif (strpos($room->image, '|') !== false) {
                $images = array_map('trim', explode('|', $room->image));
            } else {
                $images = [$room->image];
            }
        }
    }

    if (empty($images) && !empty($hotel->image)) {
        $images[] = $hotel->image;
    }

    if (empty($images)) {
        $images = [
            'assets/img/tour/tour_inner_2_1.jpg',
            'assets/img/tour/tour_inner_2_2.jpg',
            'assets/img/tour/tour_inner_2_3.jpg'
        ];
    }

    $images = array_map(function($img) {
        $img = trim($img);
        if (preg_match('#^(https?:)?//#', $img)) {
            return $img;
        }
        if (\Illuminate\Support\Str::startsWith($img, 'assets/')) {
            return asset($img);
        }
        if (\Illuminate\Support\Str::startsWith($img, 'storage/') || \Illuminate\Support\Str::startsWith($img, 'public/')) {
            return asset($img);
        }
        $roomPath = storage_path('app/public/images/rooms/' . $img);
        $hotelPath = storage_path('app/public/images/hotels/' . $img);
        if (file_exists($roomPath)) {
            return asset('storage/images/rooms/' . $img);
        } elseif (file_exists($hotelPath)) {
            return asset('storage/images/hotels/' . $img);
        }
        return asset('assets/img/tour/tour_inner_2_1.jpg');
    }, $images);

    $amenities = collect();

    if (!empty($room->amenities)) {
        if (is_array($room->amenities)) {
            $raw = $room->amenities;
        } else {
            $raw = json_decode($room->amenities, true) ?? [];
        }

        if (!empty($raw) && array_is_list($raw) && is_numeric($raw[0] ?? null)) {
            if (class_exists(\App\Models\Amenity::class)) {
                $amenities = \App\Models\Amenity::whereIn('id', $raw)->get()->map(function($a){ return $a->title ?? (string)$a; });
            } else {
                $amenities = collect(array_map(function($id){ return 'Amenity '.$id; }, $raw));
            }
        } elseif (!empty($raw) && is_array($raw) && isset($raw[0]) && (is_array($raw[0]) || is_object($raw[0]))) {
            $amenities = collect($raw)->map(function($a){
                if (is_array($a)) return (object)$a;
                return $a;
            });
        } elseif (!empty($raw) && is_array($raw)) {
            $amenities = collect($raw);
        } else {
            $amenities = collect();
        }
    }

    $relatedRooms = HotelRoom::where('hotel_id', $hotel->id)
        ->where('id', '!=', $room->id)
        ->where('status', 'Available')
        ->orderBy('price_per_night', 'asc')
        ->take(6)
        ->get();

    $trips = \App\Models\Trip::oldest()->get();

    return view('frontend.roomDetails', [
        'hotel' => $hotel,
        'room' => $room,
        'images' => collect($images),
        'amenities' => $amenities,
        'relatedRooms' => $relatedRooms,
        'trips' => $trips,
    ]);
}




    public function facilities(){
        $facilities = Facility::with('images')->oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.facilities',[
            'facilities'=>$facilities,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function facility($slug){
        $facility = Facility::with('images')->where('slug', $slug)->firstOrFail();

        $images = $facility->images;
        $allFacilities = Facility::where('id','!=',$facility->id)->get();
        $facilities = Facility::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.facility',[
            'facility'=>$facility,
            'images'=>$images,
            'allFacilities'=>$allFacilities,
            'facilities'=>$facilities,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }


    public function promotions(){
        $promotions = Promotion::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.promotions',[
            'promotions'=>$promotions,
            'about'=>$about,
            'setting'=>$setting,
        ]);
    }

    public function promotion($slug){
        $promotion = Promotion::where('slug', $slug)->firstOrFail();
        $allPromotions = Promotion::where('id','!=',$promotion->id)->get();

        $setting = Setting::first();
        $about = About::first();
        return view('frontend.promotion',[
            'promotion'=>$promotion,
            'allPromotions'=>$allPromotions,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function events(){
        $event = Eventpage::with('images')->first();
        $images = $event->images;
        return view('frontend.events',[
            'event'=>$event,
            'images'=>$images,
        ]);
    }

public function gallery()
{
    // Fetch images from both tables
    $roomImages = \DB::table('rooms')
        ->select('image', 'created_at')
        ->addSelect(\DB::raw("'room' as type"))
        ->get();

    $facilityImages = \DB::table('facilities')
        ->select('image', 'created_at')
        ->addSelect(\DB::raw("'facility' as type"))
        ->get();

    // Merge & sort by latest
    $merged = $roomImages
        ->merge($facilityImages)
        ->sortByDesc('created_at')
        ->values();

    // Paginate manually
    $perPage = 12;
    $page = request()->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $gallery = new LengthAwarePaginator(
        $merged->slice($offset, $perPage)->values(),
        $merged->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $setting = Setting::first();

    return view('frontend.gallery', [
        'gallery' => $gallery,
        'setting' => $setting,
    ]);
}



public function terms(){
    $properties = \App\Models\Property::where('status', 'Active')
        ->latest()
        ->take(10)
        ->get();
    $trips = Trip::oldest()->get();
    $setting = Setting::first();
    $about = About::first();
    $terms = \App\Models\Term::first();
    return view('frontend.terms',[
        'setting'=>$setting,
        'about'=>$about,
        'properties'=>$properties,
        'trips'=>$trips,
        'terms'=>$terms,
    ]);
}

public function bookNow(Request $request)
{
    try {
        // Validate based on service type
        $rules = [
            'service_type' => 'required|in:enquiry,hotel_booking,tour_booking,question,ticketing,left_bags',
            'names' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'message' => 'required|string',
        ];

        // Add validation rules based on service type
        if ($request->service_type === 'hotel_booking') {
            $rules['room_id'] = 'required|exists:hotel_rooms,id';
            $rules['nights'] = 'nullable|integer|min:1';
            $rules['guests'] = 'nullable|integer|min:1';
            $rules['checkin_date'] = 'nullable|date|after_or_equal:today';
            $rules['checkout_date'] = 'nullable|date|after:checkin_date';
            $rules['facility_id'] = 'nullable|exists:facilities,id';
        } elseif ($request->service_type === 'tour_booking') {
            $rules['tour_id'] = 'nullable|exists:trips,id';
            $rules['tour_date'] = 'nullable|date|after_or_equal:today';
            $rules['tour_people'] = 'nullable|integer|min:1';
        }

        $validated = $request->validate($rules);

        // Prepare data based on service type
        $bookingData = [
            'service_type' => $request->service_type,
            'names' => $request->names,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 'pending',
        ];

        // Add hotel booking specific fields
        if ($request->service_type === 'hotel_booking') {
            $bookingData['room_id'] = $request->room_id;
            $bookingData['facility_id'] = $request->facility_id;
            $bookingData['nights'] = $request->nights;
            $bookingData['guests'] = $request->guests;
            $bookingData['checkin_date'] = $request->checkin_date;
            $bookingData['checkout_date'] = $request->checkout_date;
        }

        // Add tour booking specific fields
        if ($request->service_type === 'tour_booking') {
            $bookingData['tour_id'] = $request->tour_id;
            $bookingData['tour_date'] = $request->tour_date;
            $bookingData['tour_people'] = $request->tour_people;
        }

        $booking = \App\Models\Reservation::create($bookingData);

        if ($booking) {
            $successMessages = [
                'enquiry' => "✅ Your enquiry has been received! We'll contact you soon.",
                'hotel_booking' => "✅ Your hotel booking request has been received! We'll contact you soon to confirm availability.",
                'tour_booking' => "✅ Your tour booking request has been received! We'll contact you soon to confirm details.",
                'question' => "✅ Your question has been received! We'll get back to you soon.",
            ];

            $message = $successMessages[$request->service_type] ?? "✅ Your request has been received! We'll contact you soon.";
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->withInput()->with('error', '❌ Sorry, your request could not be submitted. Please try again.');
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withInput()->withErrors($e->errors());
    } catch (\Exception $e) {
        \Log::error('Contact form error: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', '❌ Something went wrong. Please try again.');
    }
}



    public function tours(){
        // Show trip destinations instead of trips directly
        $destinations = \App\Models\TripDestination::where('status', 'Active')->with('trips')->oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.tours',[
            'destinations'=>$destinations,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function tripDestination($slug){
        $destination = \App\Models\TripDestination::with(['trips' => function($query) {
            $query->where('status', 'Active')->oldest();
        }, 'images'])->where('slug', $slug)->where('status', 'Active')->firstOrFail();
        
        $relatedDestinations = \App\Models\TripDestination::where('id', '!=', $destination->id)
            ->where('status', 'Active')
            ->oldest()
            ->take(3)
            ->get();
        
        $setting = Setting::first();
        $about = About::first();
        
        return view('frontend.tripDestination',[
            'destination'=>$destination,
            'relatedDestinations'=>$relatedDestinations,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function tour($slug){
        $tour = Trip::with('images')->where('slug',$slug)->firstOrFail();
        $images = $tour->images ?? collect();
        $tours = Trip::where('id','!=',$tour->id)->oldest()->get();
        $allTrips = Trip::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.trip',[
            'tour'=>$tour,
            'images'=>$images,
            'tours'=>$tours,
            'allTrips'=>$allTrips,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function connect(){
        $rooms = Hotel::latest()->get();
        $facilities = Trip::latest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.contact',[

            'setting'=>$setting,
            'about'=>$about,
            'rooms'=>$rooms,
            'facilities'=>$facilities,
        ]);
    }

    public function tripInquiry(Request $request)
    {
        $validatedData = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'number_of_people' => 'nullable|integer|min:1',
            'message' => 'nullable|string',
        ]);

        $trip = \App\Models\Trip::find($validatedData['trip_id']);

        // Build the message with all details
        $messageContent = "Trip Reservation Inquiry\n\n";
        $messageContent .= "Trip: " . ($request->input('trip_title') ?? 'N/A') . "\n";
        if ($request->filled('preferred_date')) {
            $messageContent .= "Preferred Date: " . $request->input('preferred_date') . "\n";
        }
        if ($request->filled('number_of_people')) {
            $messageContent .= "Number of People: " . $request->input('number_of_people') . "\n";
        }
        if ($request->filled('message')) {
            $messageContent .= "\nAdditional Message:\n" . $request->input('message');
        }

        // Create reservation using the Reservation model
        $reservation = \App\Models\Reservation::create([
            'names' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'message' => $messageContent,
            'service_type' => 'tour_booking',
            'tour_id' => $validatedData['trip_id'],
            'selected_trip_ids' => json_encode([$validatedData['trip_id']]),
            'trip_destination_id' => $trip?->trip_destination_id,
            'guests' => $request->input('number_of_people') ?? 1,
            'status' => 'pending',
        ]);

        if ($reservation) {
            return redirect()->back()->with('success', '✅ Your reservation inquiry has been received! We\'ll contact you soon to confirm your booking.');
        } else {
            return redirect()->back()->with('error', '❌ Sorry, your inquiry could not be submitted. Please try again.');
        }
    }

    public function tripRequestMultiple(Request $request)
    {
        $validatedData = $request->validate([
            'trip_destination_id' => 'required|exists:trip_destinations,id',
            'trip_ids' => 'required|array|min:1',
            'trip_ids.*' => 'exists:trips,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'number_of_people' => 'nullable|integer|min:1',
            'message' => 'nullable|string',
        ]);

        $trips = \App\Models\Trip::whereIn('id', $validatedData['trip_ids'])->get();
        $tripTitles = $trips->pluck('title')->filter()->implode(', ');

        $messageContent = "Multi-Activity Trip Request\n\n";
        $messageContent .= "Selected Activities: " . ($tripTitles ?: 'N/A') . "\n";
        if ($request->filled('preferred_date')) {
            $messageContent .= "Preferred Date: " . $request->input('preferred_date') . "\n";
        }
        if ($request->filled('number_of_people')) {
            $messageContent .= "Number of People: " . $request->input('number_of_people') . "\n";
        }
        if ($request->filled('message')) {
            $messageContent .= "\nAdditional Message:\n" . $request->input('message');
        }

        $reservation = \App\Models\Reservation::create([
            'service_type' => 'tour_booking',
            'names' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'message' => $messageContent,
            'selected_trip_ids' => json_encode($validatedData['trip_ids']),
            'trip_destination_id' => $validatedData['trip_destination_id'],
            'guests' => $request->input('number_of_people') ?? 1,
            'status' => 'pending',
        ]);

        if ($reservation) {
            return redirect()->back()->with('success', '✅ Your trip request has been received! We will send you a plan and quote.');
        }

        return redirect()->back()->with('error', '❌ Sorry, your request could not be submitted. Please try again.');
    }


    public function singleBlog($slug) {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $latestBlogs = Blog::where('status', 'Published')->where('id', '!=',$blog->id)->latest()->paginate(10);

        $setting = Setting::first();

        if ($blog) {
            $blog->increment('views');
            $comments = BlogComment::where('status','Published')->latest()->get();
            $commentsCount = $comments->count();

            $relatedBlogs = Blog::where('id', '!=', $blog->id)
                                    ->where('status', 'Published')
                                    ->take(5) 
                                    ->get();
        } else {

            return redirect()->route('blogs')->with('error', 'Article not found');
        }
    

        return view('frontend.blog', [
            'blog' => $blog, 
            'latestBlogs' => $latestBlogs, 
            'comments' => $comments, 
            'commentsCount' => $commentsCount, 
            'setting' => $setting, 
            'relatedBlogs'=>$relatedBlogs,
        ]);
    }
    public function blogs() {
        $articles = Blog::where('status', 'Published')->latest()->get();
        $latestBlogs = Blog::where('status', 'Published')->latest()->paginate(10);
        $setting = Setting::first();
        $rooms = Room::oldest()->get();
        return view('frontend.blogs', [
            'articles' => $articles, 
            'latestBlogs' => $latestBlogs, 
            'setting' => $setting, 
            'rooms'=>$rooms,
        ]);
    }


    public function subscribe(Request $request) {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email'),
            ],
        ]);

        $email = $request->input('email');

        $subscribed = Subscriber::create([
            'email' => $email,
        ]);


        if($subscribed){
            //$subscriber = Subscriber::where('email', $email)->firstOrFail();
            //Mail::to("mukizaemma34@gmail.com")->send(new NewSubscriberNotification($subscriber));
    
            return redirect()->back()->with('success', 'Thank you for subscribing to StayNets Resort, we will get back to you');
        }

        else{
            return redirect()->back()->with('error', 'Something Went Wrong. Try again later!');
        }        
    
    }
   

    public function sendMessage(Request $request) {
        $validatedData = $request->validate([
            'names' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
    
        // Now create the message with the validated data
        $message = Message::create($validatedData);  // Pass validated data
    
        // Mail::to("mukizaemma34@gmail.com")->send(new MessageNotification($message));
    
        return redirect()->back()->with('success', 'Thank you for reaching out... we will get back to you soon');
    }
    
    

    public function testimony(Request $request){

        $review = Review::create([
            'names' => $request->input('names'),
            'email' => $request->input('email'),
            'testimony' => $request->input('testimony'),
        ]);
    
        if (!$review) {
            return redirect()->back()->with('error', 'Failed to submit your testimony. Please try again.');
        }
    
        return redirect()->back()->with('success', 'Your testimony has submitted successfully!');
    }

    public function sendComment(Request $request) {
        $user = auth()->user();
    
        $comment = BlogComment::create([
            'blog_id' => $request->input('blog_id'),
            'names' => $request->input('names'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'user_id' => $user ? $user->id : null,
        ]);
    
        if ($comment) {
            // Mail::to('mukizaemma34@gmail.com')->send(new BlogCommentsNotofications($comment));
            return redirect()->back()->with('success', 'Comment added successfully');
        }
    
        else{
            return redirect()->back()->with('error', 'Failed to add the comment. Please try again.');
        }
    }

    /**
     * Logout the authenticated user
     */
    public function logouts()
    {
        Auth::logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

}
