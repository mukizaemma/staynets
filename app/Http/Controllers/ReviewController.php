<?php

namespace App\Http\Controllers;

use App\Models\PropertyReview;
use App\Models\CarReview;
use App\Models\TripReview;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;

class ReviewController extends Controller
{
    /**
     * Display all reviews (paginated)
     */
    public function index()
    {
        $reviews = Review::where('is_approved', true)
            ->with(['user', 'images'])
            ->latest()
            ->paginate(12);

        return view('frontend.reviews.index', compact('reviews'));
    }

    /**
     * Display a single review
     */
    public function show($id)
    {
        $review = Review::with(['user', 'images'])
            ->where('is_approved', true)
            ->findOrFail($id);

        return view('frontend.reviews.show', compact('review'));
    }

    /**
     * Store a general review (testimonial)
     */
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'testimony' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
            'website' => 'nullable|url|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max per image
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'names' => $request->names,
            'email' => $request->email,
            'testimony' => $request->testimony,
            'rating' => $request->rating,
            'website' => $request->website,
            'is_approved' => true, // Set to active by default
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('reviews', 'public');
                
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        // Send email notification to admins
        $admins = User::where('role', 1)->get();
        if ($admins->count() > 0) {
            $adminDetails = [
                'subject' => 'New Review Submitted',
                'title' => 'New Review Submission',
                'message' => "A new review has been submitted:\n\n"
                    . "Reviewer: {$review->names} ({$review->email})\n"
                    . "Rating: {$review->rating}/5 stars\n"
                    . "Review: {$review->testimony}\n"
                    . "\nYou can view and manage this review in the admin panel:\n"
                    . route('admin.reviews.index'),
                'lastline' => 'Please log in to review and manage this submission.',
            ];

            foreach ($admins as $admin) {
                Mail::to($admin->email)
                    ->send(new AdminNotification($adminDetails));
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! It has been published.',
                'review' => $review->load('images')
            ]);
        }

        return back()->with('success', 'Thank you for your review! It has been published.');
    }
    /**
     * Store a property review
     */
    public function storeProperty(Request $request, $hotelId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'title' => 'nullable|string|max:255',
        ]);

        $review = PropertyReview::create([
            'user_id' => Auth::id(),
            'hotel_id' => $hotelId,
            'reviewable_type' => 'hotel',
            'rating' => $request->rating,
            'comment' => $request->comment,
            'title' => $request->title,
            'is_approved' => false, // Requires admin approval
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully. It will be published after approval.',
                'review' => $review
            ]);
        }

        return back()->with('success', 'Review submitted successfully. It will be published after approval.');
    }

    /**
     * Store a car review
     */
    public function storeCar(Request $request, $carId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'title' => 'nullable|string|max:255',
        ]);

        $review = CarReview::create([
            'user_id' => Auth::id(),
            'car_id' => $carId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'title' => $request->title,
            'is_approved' => false, // Requires admin approval
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully. It will be published after approval.',
                'review' => $review
            ]);
        }

        return back()->with('success', 'Review submitted successfully. It will be published after approval.');
    }

    /**
     * Store a trip review
     */
    public function storeTrip(Request $request, $tripId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'title' => 'nullable|string|max:255',
        ]);

        $review = TripReview::create([
            'user_id' => Auth::id(),
            'trip_id' => $tripId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'title' => $request->title,
            'is_approved' => false, // Requires admin approval
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully. It will be published after approval.',
                'review' => $review
            ]);
        }

        return back()->with('success', 'Review submitted successfully. It will be published after approval.');
    }
}
