<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Blog;
use App\Models\Hotel;
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
use Illuminate\Support\Collection;


class HomeController extends Controller
{
    public function index(Request $request)
    {

        $slides = Slide::oldest()->get();
        $category = Category::all();
        $hotels = Hotel::where('type','hotel')->latest()->get();
        $services = Program::oldest()->get();
        $rooms = HotelRoom::oldest()->get();
        $articles = Blog::latest()->paginate(3);
        $trips = Trip::with('images')->oldest()->take(3)->get();

        return view('frontend.index',[
            'slides'=>$slides,
            'hotels'=>$hotels,
            'rooms'=>$rooms,
            'articles'=>$articles,
            'trips'=>$trips,
            'services'=>$services,
            
        ]);

    }

    public function hotels(Request $request)
    {
        $q = $request->input('q');
        $orderby = $request->input('orderby');
        $query = \App\Models\Hotel::query()->where('status','Active')->where('type','hotel');

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
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->oldest();
        }

        $rooms = $query->paginate(12)->appends($request->query());

        if ($request->ajax()) {
            // render the partial view and return HTML
            $html = view('frontend.partials.accommodations_results', compact('rooms'))->render();
            return response()->json(['html' => $html]);
        }

        return view('frontend.hotels', [
            'rooms' => $rooms,
        ]);
    
    }

    public function apartments(Request $request)
    {
        $q = $request->input('q');
        $orderby = $request->input('orderby');
        $query = \App\Models\Hotel::query()->where('status','Active')->where('type','apartment');

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
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->oldest();
        }

        $rooms = $query->paginate(12)->appends($request->query());

        if ($request->ajax()) {
            // render the partial view and return HTML
            $html = view('frontend.partials.accommodations_results', compact('rooms'))->render();
            return response()->json(['html' => $html]);
        }

        return view('frontend.hotels', [
            'rooms' => $rooms,
        ]);
    
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
        $trips = Trip::Oldest()->get();                         
        return view('frontend.service', [

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


public function destinations()
{
    $destinations = Category::oldest()->get();
    $trips = Trip::Oldest()->get();                    

    return view('frontend.destinations', [

        'trips' => $trips,
        'destinations' => $destinations,
    ]);
}
public function destination($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $trips = Trip::Oldest()->get();
    $hotels = $category
        ->hotels()
        ->where('status', 'Active')           
        ->orderBy('created_at', 'desc')         
        ->paginate(9);                      


    return view('frontend.destination', [

        'trips' => $trips,
        'category' => $category,
        'hotels'   => $hotels,
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
            if (preg_match('#^(https?:)?//#', $img) || str_starts_with($img, 'assets/')) {
                return $img;
            }
            if (str_starts_with($img, 'storage/') || str_starts_with($img, 'public/')) {
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

        $amenities = [];
        if (!empty($room->amenities)) {
            $amenities = is_array($room->amenities) ? $room->amenities : (json_decode($room->amenities, true) ?? []);
        }

        return view('frontend.roomDetails', [
            'hotel'     => $hotel,
            'room'      => $room,
            'images'    => $images,
            'amenities' => $amenities,
        ]);
    }


    public function room(){
        $room = HotelRoom::all();
        $setting = Setting::first();
        $about = About::first();
            $trips = Trip::Oldest()->get();
        return view('frontend.roomDetails',[
            'room'=>$room,
            'setting'=>$setting,
            'about'=>$about,
            'trips'=>$trips,
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
        $rooms = Room::all();
        $trips = Trip::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.terms',[
            'setting'=>$setting,
            'about'=>$about,
            'rooms'=>$rooms,
            'trips'=>$trips,
        ]);
    }

public function bookNow(Request $request)
{
    $booking = \App\Models\Reservation::create([
        'room_id'     => $request->room_id,
        'facility_id' => $request->facility_id,
        'nights'      => $request->nights,
        'guests'      => $request->guests,
        'message'     => $request->message,
        'names'       => $request->names,
        'email'       => $request->email,
        'phone'       => $request->phone,
        'status'      => 'pending',
    ]);

    if ($booking) {
        return redirect()->back()->with('success', '✅ Your booking request has been received! We’ll contact you soon to confirm availability.');
    } else {
        return redirect()->back()->with('error', '❌ Sorry, your booking could not be submitted. Please try again.');
    }
}



    public function tours(){
        $tours = Trip::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.tours',[
            'tours'=>$tours,
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
        return view('frontend.tour',[
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
    
            return redirect()->back()->with('success', 'Thank you for subscribing to Accoomodation Booking Engine Resort, we will get back to you');
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


}
