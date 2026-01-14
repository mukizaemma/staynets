<?php

namespace App\Http\Controllers;

use App\Models\PropertyReview;
use App\Models\CarReview;
use App\Models\TripReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
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
