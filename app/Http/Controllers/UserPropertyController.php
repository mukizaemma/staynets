<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserPropertyController extends Controller
{
    public function index()
    {
        $hotels = collect();

        if (auth()->check()) {
            $hotels = \App\Models\Hotel::where('added_by', auth()->id())->latest()->get();
        }

        return view('frontend.myProperties', [
            'hotels' => $hotels,
        ]);
    }

    public function myPropertyCreate()
    {
        $userId = auth()->id();
        $destinations = Category::all();
        $services = Program::all();
        $hotels = Hotel::where('added_by', $userId)->latest()->get();
        return view('frontend.myPropertyCreate',[
            'destinations'=>$destinations,
            'services'=>$services,
            'hotels'=>$hotels,
        ]);
    }


    public function storeHotel(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:hotels,slug',
            'type' => 'nullable|string|max:100',
            'stars' => 'nullable|string|max:10',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'category_id' => 'nullable|integer',
            'program_id' => 'nullable|integer',
        ]);

        $data['added_by'] = auth()->id();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images/hotels');
            $data['image'] = basename($path);
        }

        $hotel = Hotel::create($data);

        return redirect()->route('frontend.myProperties', $hotel)->with('success', 'Hotel created successfully. Add rooms next.');
    }

    public function editHotel(Hotel $hotel)
    {
        $this->authorizeOwner($hotel);
        return view('frontend.myProperties', compact('hotel'));
    }

    public function updateHotel(Request $request, Hotel $hotel)
    {
        $this->authorizeOwner($hotel);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable','string','max:255', Rule::unique('hotels','slug')->ignore($hotel->id)],
            'type' => 'nullable|string|max:100',
            'stars' => 'nullable|string|max:10',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'category_id' => 'nullable|integer',
            'program_id' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($hotel->image && Storage::exists('public/images/hotels/' . $hotel->image)) {
                Storage::delete('public/images/hotels/' . $hotel->image);
            }
            $path = $request->file('image')->store('public/images/hotels');
            $data['image'] = basename($path);
        }

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(5);

        $hotel->update($data);

        return redirect()->route('frontend.myProperties')->with('success', 'Hotel updated.');
    }

    public function showHotel(Hotel $hotel)
    {
        $this->authorizeOwner($hotel);
        $rooms = $hotel->rooms()->latest()->get();
        return view('frontend.myProperties', compact('hotel','rooms'));
    }

    public function createRoom(Hotel $hotel)
    {
        $this->authorizeOwner($hotel);
        return view('frontend.myProperties', compact('hotel'));
    }

    public function storeRoom(Request $request, Hotel $hotel)
    {
        $this->authorizeOwner($hotel);

        $data = $request->validate([
            'room_type' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:hotel_rooms,slug',
            'image' => 'nullable|image|max:4096',
            'max_occupancy' => 'nullable|integer',
            'price_per_night' => 'required|numeric',
            'total_rooms' => 'nullable|integer',
            'available_rooms' => 'nullable|integer',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
        ]);

        $data['hotel_id'] = $hotel->id;
        $data['added_by'] = auth()->id();
        $data['slug'] = $data['slug'] ?? Str::slug($data['room_type']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images/rooms');
            $data['image'] = basename($path);
        }

        if (!empty($data['amenities'])) {
            $data['amenities'] = json_encode(array_values(array_filter($data['amenities'])));
        }

        HotelRoom::create($data);

        return redirect()->route('frontend.myProperties', $hotel)->with('success', 'Room added.');
    }

    public function editRoom(HotelRoom $room)
    {
        $hotel = $room->hotel;
        $this->authorizeOwner($hotel);
        return view('frontend.myProperties', compact('room','hotel'));
    }

    public function updateRoom(Request $request, HotelRoom $room)
    {
        $hotel = $room->hotel;
        $this->authorizeOwner($hotel);

        $data = $request->validate([
            'room_type' => 'required|string|max:255',
            'slug' => ['nullable','string','max:255', Rule::unique('hotel_rooms','slug')->ignore($room->id)],
            'image' => 'nullable|image|max:4096',
            'max_occupancy' => 'nullable|integer',
            'price_per_night' => 'required|numeric',
            'total_rooms' => 'nullable|integer',
            'available_rooms' => 'nullable|integer',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'status' => ['nullable', Rule::in(['Available','Unavailable'])],
        ]);

        if ($request->hasFile('image')) {
            if ($room->image && Storage::exists('public/images/rooms/'.$room->image)) {
                Storage::delete('public/images/rooms/'.$room->image);
            }
            $path = $request->file('image')->store('public/images/rooms');
            $data['image'] = basename($path);
        }

        if (!empty($data['amenities'])) $data['amenities'] = json_encode(array_values(array_filter($data['amenities'])));

        $room->update($data);

        return redirect()->route('frontend.myProperties', $hotel)->with('success', 'Room updated.');
    }

    protected function authorizeOwner(Hotel $hotel)
    {
        if ($hotel->added_by !== auth()->id()) {
            abort(403);
        }
    }
}
