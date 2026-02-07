<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Property;
use App\Models\UnitType;
use App\Models\Amenity;
use App\Models\FacilityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminUnitsController extends Controller
{
    /**
     * Display a listing of units.
     */
    public function index(Request $request)
    {
        $query = Unit::with(['property', 'unitType', 'addedBy']);

        if ($request->has('property_id') && $request->property_id) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('slug', 'LIKE', "%$search%");
            });
        }

        $units = $query->latest()->paginate(15);
        $properties = Property::active()->get();
        $setting = \App\Models\Setting::first();

        return view('admin.units.index', [
            'units' => $units,
            'properties' => $properties,
            'setting' => $setting,
        ]);
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create(Request $request)
    {
        $propertyId = $request->get('property_id');
        $properties = Property::active()->get();
        $unitTypes = UnitType::where('is_active', true)->get();
        $amenities = Amenity::with('category')->active()->orderBy('title')->get();
        $facilityCategories = FacilityCategory::with(['facilities' => function($query) {
            $query->active()->orderBy('title');
        }])->where('is_active', true)->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();

        return view('admin.units.create', [
            'propertyId' => $propertyId,
            'properties' => $properties,
            'unitTypes' => $unitTypes,
            'amenities' => $amenities,
            'facilityCategories' => $facilityCategories,
            'setting' => $setting,
        ]);
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:1',
            'beds' => 'nullable|integer|min:1',
            'size_sqm' => 'nullable|integer|min:0',
            'total_units' => 'required|integer|min:1',
            'available_units' => 'required|integer|min:0',
            'base_price_per_night' => 'nullable|numeric|min:0',
            'base_price_per_month' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'price_display_type' => 'nullable|in:per_night,per_month,both',
            'featured_image' => 'nullable|image|max:4096',
            'status' => 'nullable|in:Available,Unavailable,Maintenance', // Status will default to Available if not provided
            'is_active' => 'nullable|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:amenities,id',
        ]);

        $name = $request->name ?: 'Unit ' . Str::random(6);
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        while (Unit::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $fileName = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $path = $file->store('public/images/units');
            $fileName = basename($path);
        }

        $unit = Unit::create([
            'property_id' => $request->property_id,
            'unit_type_id' => $request->unit_type_id,
            'added_by' => auth()->id(),
            'name' => $name,
            'slug' => $slug,
            'description' => $request->description,
            'max_occupancy' => $request->max_occupancy,
            'bedrooms' => $request->bedrooms ?? 0,
            'bathrooms' => $request->bathrooms ?? 1,
            'beds' => $request->beds ?? 1,
            'size_sqm' => $request->size_sqm,
            'total_units' => $request->total_units,
            'available_units' => $request->available_units,
            'base_price_per_night' => $request->base_price_per_night,
            'base_price_per_month' => $request->base_price_per_month,
            'currency' => $request->currency ?? 'USD',
            'price_display_type' => $request->price_display_type ?? 'per_night',
            'featured_image' => $fileName,
            'status' => $request->status ?? 'Available', // Use provided status or default to Available
            'is_active' => $request->has('is_active'),
        ]);

        // Attach facilities
        if ($request->has('facilities')) {
            $unit->facilities()->sync($request->facilities);
        }

        return redirect()->route('admin.units.index', ['property_id' => $request->property_id])
            ->with('success', 'Unit created successfully');
    }

    /**
     * Show the form for editing the specified unit.
     */
    public function edit($id)
    {
        $unit = Unit::with(['facilities', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')->orderBy('sort_order');
        }])->findOrFail($id);
        $properties = Property::active()->get();
        $unitTypes = UnitType::where('is_active', true)->get();
        $amenities = Amenity::with('category')->active()->orderBy('title')->get();
        $facilityCategories = FacilityCategory::with(['facilities' => function($query) {
            $query->active()->orderBy('title');
        }])->where('is_active', true)->orderBy('sort_order')->get();
        $setting = \App\Models\Setting::first();

        return view('admin.units.edit', [
            'unit' => $unit,
            'properties' => $properties,
            'unitTypes' => $unitTypes,
            'amenities' => $amenities,
            'facilityCategories' => $facilityCategories,
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified unit.
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:1',
            'beds' => 'nullable|integer|min:1',
            'size_sqm' => 'nullable|integer|min:0',
            'total_units' => 'required|integer|min:1',
            'available_units' => 'required|integer|min:0',
            'base_price_per_night' => 'nullable|numeric|min:0',
            'base_price_per_month' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'price_display_type' => 'nullable|in:per_night,per_month,both',
            'featured_image' => 'nullable|image|max:4096',
            'status' => 'required|in:Available,Unavailable,Maintenance',
            'is_active' => 'nullable|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:amenities,id',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($unit->featured_image && Storage::exists('public/images/units/' . $unit->featured_image)) {
                Storage::delete('public/images/units/' . $unit->featured_image);
            }
            $file = $request->file('featured_image');
            $path = $file->store('public/images/units');
            $unit->featured_image = basename($path);
        }

        $unit->update([
            'property_id' => $request->property_id,
            'unit_type_id' => $request->unit_type_id,
            'name' => $request->name,
            'description' => $request->description,
            'max_occupancy' => $request->max_occupancy,
            'bedrooms' => $request->bedrooms ?? 0,
            'bathrooms' => $request->bathrooms ?? 1,
            'beds' => $request->beds ?? 1,
            'size_sqm' => $request->size_sqm,
            'total_units' => $request->total_units,
            'available_units' => $request->available_units,
            'base_price_per_night' => $request->base_price_per_night,
            'base_price_per_month' => $request->base_price_per_month,
            'currency' => $request->currency ?? 'USD',
            'price_display_type' => $request->price_display_type ?? 'per_night',
            'status' => $request->status,
            'is_active' => $request->has('is_active'),
        ]);

        // Sync facilities
        if ($request->has('facilities')) {
            $unit->facilities()->sync($request->facilities);
        } else {
            $unit->facilities()->detach();
        }

        return redirect()->route('admin.units.index', ['property_id' => $unit->property_id])
            ->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified unit.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $propertyId = $unit->property_id;
        $unit->delete();

        return redirect()->route('admin.units.index', ['property_id' => $propertyId])
            ->with('success', 'Unit deleted successfully');
    }
}

