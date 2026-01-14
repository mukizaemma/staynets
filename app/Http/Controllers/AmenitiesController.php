<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\FacilityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AmenitiesController extends Controller
{
    /**
     * Display a listing of amenities.
     */
    public function index()
    {
        $amenities = Amenity::with('category')->latest()->get();
        $categories = FacilityCategory::where('is_active', true)->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();
        
        return view('admin.amenities.index', [
            'amenities' => $amenities,
            'categories' => $categories,
            'setting' => $setting,
        ]);
    }

    /**
     * Store a newly created amenity.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'facility_category_id' => 'required|exists:facility_categories,id',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (Amenity::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $amenity = Amenity::create([
            'title' => $request->title,
            'slug' => $slug,
            'facility_category_id' => $request->facility_category_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity has been created successfully',
                'amenity' => [
                    'id' => $amenity->id,
                    'title' => $amenity->title,
                    'icon' => $amenity->icon ?? null,
                    'facility_category_id' => $amenity->facility_category_id,
                ]
            ]);
        }

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity has been created successfully');
    }

    /**
     * Show the form for editing the specified amenity.
     */
    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        $categories = FacilityCategory::where('is_active', true)->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();
        
        return view('admin.amenities.edit', [
            'amenity' => $amenity,
            'categories' => $categories,
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified amenity.
     */
    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'facility_category_id' => 'required|exists:facility_categories,id',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique (excluding current amenity)
        if ($slug !== $amenity->slug) {
            $originalSlug = $slug;
            $counter = 1;
            while (Amenity::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $amenity->update([
            'title' => $request->title,
            'slug' => $slug,
            'facility_category_id' => $request->facility_category_id,
            'icon' => $request->icon,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity has been updated successfully');
    }

    /**
     * Remove the specified amenity.
     */
    public function destroy(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity has been deleted successfully'
            ]);
        }

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity has been deleted successfully');
    }
}


