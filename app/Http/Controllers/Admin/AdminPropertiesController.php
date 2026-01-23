<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Hotel;
use App\Models\Category;
use App\Models\Program;
use App\Models\Partner;
use App\Models\Amenity;
use App\Models\FacilityCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class AdminPropertiesController extends Controller
{
    /**
     * Display a listing of properties.
     * Shows both admin-created properties (Property model) and user-created properties (Hotel model).
     */
    public function index(Request $request)
    {
        // Query admin-created properties (Property model)
        $propertyQuery = Property::with(['owner', 'category', 'program', 'partner']);

        // Query user-created properties (Hotel model)
        $hotelQuery = Hotel::with(['owner']);

        // Filter by type
        if ($request->has('type') && $request->type) {
            if ($request->type == 'hotel') {
                $propertyQuery->where('property_type', 'hotel');
                // Hotels from Hotel model are all hotels, so no filter needed
            } elseif ($request->type == 'apartment') {
                $propertyQuery->where('property_type', 'apartment');
                $hotelQuery->whereRaw('1 = 0'); // Exclude hotels if filtering for apartments
            }
        }

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $propertyQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('location', 'LIKE', "%$search%")
                  ->orWhere('city', 'LIKE', "%$search%")
                  ->orWhere('phone', 'LIKE', "%$search%");
            });
            $hotelQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('location', 'LIKE', "%$search%")
                  ->orWhere('city', 'LIKE', "%$search%")
                  ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $propertyQuery->where('status', $request->status);
            $hotelQuery->where('status', $request->status);
        }

        // Get all properties and hotels
        $properties = $propertyQuery->latest()->get();
        $hotels = $hotelQuery->latest()->get();

        // Transform hotels to match property structure for unified display
        $allProperties = $properties->map(function($property) {
            return (object)[
                'id' => $property->id,
                'name' => $property->name,
                'type' => $property->property_type ?? 'hotel',
                'property_type' => $property->property_type ?? 'hotel',
                'owner' => $property->owner,
                'location' => $property->location,
                'city' => $property->city,
                'status' => $property->status ?? 'Pending',
                'stars' => $property->stars,
                'is_featured' => $property->is_featured ?? false,
                'is_verified' => $property->is_verified ?? false,
                'units' => $property->units ?? collect(),
                'image' => $property->featured_image ?? null,
                'phone' => $property->phone,
                'email' => $property->email,
                'is_hotel_model' => false, // Flag to identify Property model
            ];
        });

        $allHotels = $hotels->map(function($hotel) {
            return (object)[
                'id' => $hotel->id,
                'name' => $hotel->name,
                'type' => $hotel->type ?? 'hotel',
                'property_type' => $hotel->type ?? 'hotel',
                'owner' => $hotel->owner,
                'location' => $hotel->location,
                'city' => $hotel->city,
                'status' => $hotel->status ?? 'Pending',
                'stars' => $hotel->stars,
                'is_featured' => false,
                'is_verified' => false,
                'units' => $hotel->rooms ?? collect(),
                'image' => $hotel->image,
                'phone' => $hotel->phone,
                'email' => $hotel->email,
                'is_hotel_model' => true, // Flag to identify Hotel model
            ];
        });

        // Merge and sort by created_at
        $merged = $allProperties->merge($allHotels)->sortByDesc(function($item) {
            return $item->is_hotel_model 
                ? Hotel::find($item->id)->created_at 
                : Property::find($item->id)->created_at;
        });

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 15;
        $total = $merged->count();
        $items = $merged->slice(($page - 1) * $perPage, $perPage)->values();

        // Create paginator manually
        $properties = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = Category::all();
        $programs = Program::all();
        $partners = Partner::all();
        $setting = \App\Models\Setting::first();
        
        // Get counts for status badges (include both Property and Hotel models)
        $pendingCount = Property::where('status', 'Pending')->count() + Hotel::where('status', 'Pending')->count();
        $activeCount = Property::where('status', 'Active')->count() + Hotel::where('status', 'Active')->count();
        $inactiveCount = Property::where('status', 'Inactive')->count() + Hotel::where('status', 'Inactive')->count();

        return view('admin.properties.index', [
            'properties' => $properties,
            'categories' => $categories,
            'programs' => $programs,
            'partners' => $partners,
            'setting' => $setting,
            'pendingCount' => $pendingCount,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $categories = Category::all();
        $programs = Program::all();
        $partners = Partner::all();
        $users = User::all();
        $amenities = Amenity::with('category')->orderBy('title')->get();
        $facilityCategories = FacilityCategory::with(['facilities' => function($query) {
            $query->active()->orderBy('title');
        }])->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();

        return view('admin.properties.create', [
            'categories' => $categories,
            'programs' => $programs,
            'partners' => $partners,
            'users' => $users,
            'amenities' => $amenities,
            'facilityCategories' => $facilityCategories,
            'setting' => $setting,
        ]);
    }

    /**
     * Store a newly created property.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'property_type' => 'required|in:hotel,apartment',
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'program_id' => 'nullable|exists:programs,id',
            'partner_id' => 'nullable|exists:partners,id',
            'stars' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'map_embed_code' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'featured_image' => 'nullable|image|max:4096',
            'status' => 'nullable|in:Active,Inactive,Pending', // Status will default to Pending if not provided
            'is_featured' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:amenities,id',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Property::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $fileName = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $path = $file->store('public/images/properties');
            $fileName = basename($path);
        }

        $property = Property::create([
            'owner_id' => $request->owner_id,
            'category_id' => $request->category_id,
            'program_id' => $request->program_id,
            'partner_id' => $request->partner_id,
            'name' => $request->name,
            'slug' => $slug,
            'property_type' => $request->property_type,
            'stars' => $request->stars,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map_embed_code' => $request->map_embed_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'featured_image' => $fileName,
            'status' => $request->status ?? 'Pending', // Use provided status or default to Pending
            'is_featured' => $request->has('is_featured'),
            'is_verified' => $request->has('is_verified'),
        ]);

        // Attach facilities
        if ($request->has('facilities')) {
            $property->facilities()->sync($request->facilities);
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully');
    }

    /**
     * Display the specified property.
     * Handles both Property model (admin-created) and Hotel model (user-created) properties.
     */
    public function show($id)
    {
        // Try Property model first
        $property = Property::with(['owner', 'category', 'program', 'partner', 'units', 'images', 'facilities'])->find($id);
        $isHotelModel = false;
        
        // If not found, try Hotel model
        if (!$property) {
            $hotel = Hotel::with(['owner', 'rooms'])->findOrFail($id);
            $isHotelModel = true;
            // Transform hotel to match property structure for view compatibility
            $property = (object)[
                'id' => $hotel->id,
                'name' => $hotel->name,
                'property_type' => $hotel->type ?? 'hotel',
                'owner' => $hotel->owner,
                'location' => $hotel->location,
                'city' => $hotel->city,
                'status' => $hotel->status ?? 'Pending',
                'stars' => $hotel->stars,
                'description' => $hotel->description,
                'phone' => $hotel->phone,
                'email' => $hotel->email,
                'website' => $hotel->website,
                'address' => $hotel->address,
                'image' => $hotel->image,
                'units' => $hotel->rooms,
                'images' => collect(),
                'facilities' => collect(),
                'is_hotel_model' => true,
                'hotel' => $hotel, // Keep reference to original hotel model
            ];
        }
        
        $setting = \App\Models\Setting::first();

        return view('admin.properties.show', [
            'property' => $property,
            'setting' => $setting,
            'isHotelModel' => $isHotelModel,
        ]);
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit($id)
    {
        $property = Property::with(['facilities', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }])->findOrFail($id);
        $categories = Category::all();
        $programs = Program::all();
        $partners = Partner::all();
        $users = User::all();
        $amenities = Amenity::with('category')->active()->orderBy('title')->get();
        $facilityCategories = FacilityCategory::with(['facilities' => function($query) {
            $query->active()->orderBy('title');
        }])->where('is_active', true)->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();

        return view('admin.properties.edit', [
            'property' => $property,
            'categories' => $categories,
            'programs' => $programs,
            'partners' => $partners,
            'users' => $users,
            'amenities' => $amenities,
            'facilityCategories' => $facilityCategories,
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified property.
     */
    public function update(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);

            $request->validate([
            'name' => 'required|string|max:255',
            'property_type' => 'required|in:hotel,apartment,guesthouse,lodge',
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'program_id' => 'nullable|exists:programs,id',
            'partner_id' => 'nullable|exists:partners,id',
            'stars' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'map_embed_code' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'featured_image' => 'nullable|image|max:4096',
            'status' => 'required|in:Active,Inactive,Pending',
            'is_featured' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:amenities,id',
        ]);

        $slug = Str::slug($request->name);
        if ($slug !== $property->slug) {
            $originalSlug = $slug;
            $counter = 1;
            while (Property::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        if ($request->hasFile('featured_image')) {
            if ($property->featured_image && Storage::exists('public/images/properties/' . $property->featured_image)) {
                Storage::delete('public/images/properties/' . $property->featured_image);
            }
            $file = $request->file('featured_image');
            $path = $file->store('public/images/properties');
            $property->featured_image = basename($path);
        }

        $property->update([
            'owner_id' => $request->owner_id,
            'category_id' => $request->category_id,
            'program_id' => $request->program_id,
            'partner_id' => $request->partner_id,
            'name' => $request->name,
            'slug' => $slug,
            'property_type' => $request->property_type,
            'stars' => $request->stars,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map_embed_code' => $request->map_embed_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured'),
            'is_verified' => $request->has('is_verified'),
        ]);

            // Sync facilities
            if ($request->has('facilities')) {
                $property->facilities()->sync($request->facilities);
            } else {
                $property->facilities()->detach();
            }

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating the property: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update property status (Approve/Inactive/Active).
     * Supports both POST (with status in request body) and GET (with status in URL parameter).
     * Handles both Property model (admin-created) and Hotel model (user-created) properties.
     */
    public function updateStatus(Request $request, $id, $status = null)
    {
        try {
            // Get status from URL parameter (GET request) or request body (POST request)
            $newStatus = $status ?? $request->input('status');
            
            // Try to find in Property model first (admin-created properties)
            $property = Property::find($id);
            if ($property) {
                $property->update(['status' => $newStatus]);
                $propertyName = $property->name;
            } else {
                // If not found in Property, try Hotel model (user-created properties)
                $hotel = Hotel::find($id);
                if ($hotel) {
                    $hotel->update(['status' => $newStatus]);
                    $propertyName = $hotel->name;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Property not found'
                    ], 404);
                }
            }
            
            // Validate status
            if (!$newStatus || !in_array($newStatus, ['Active', 'Inactive', 'Pending'])) {
                if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid status. Must be Active, Inactive, or Pending.',
                    ], 422);
                }
                return redirect()->route('admin.properties.index')
                    ->with('error', 'Invalid status. Must be Active, Inactive, or Pending.');
            }

            $statusMessages = [
                'Active' => 'Property approved and set to Active',
                'Inactive' => 'Property set to Inactive',
                'Pending' => 'Property set to Pending',
            ];

            $finalStatus = $newStatus;

            // Always return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => $statusMessages[$newStatus] ?? 'Status updated successfully',
                    'status' => $finalStatus,
                ]);
            }

            return redirect()->route('admin.properties.index')
                ->with('success', $statusMessages[$newStatus] ?? 'Status updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Remove the specified property.
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully');
    }
}

