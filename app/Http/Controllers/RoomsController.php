<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Setting;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelRoomImage;
use App\Models\Roomimage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{

    public function index(Request $request)
    {
        $userId = auth()->id();
        $search = $request->search;
        $hotels = Hotel::latest()->get();
        $hotelIds = Hotel::where('added_by', $userId)->pluck('id');

        $rooms = HotelRoom::whereIn('hotel_id', $hotelIds)
            ->when($search, function ($q) use ($search) {
                $q->where('room_type', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->orWhere('price_per_night', 'LIKE', "%$search%")
                ->orWhereJsonContains('amenities', $search);
            })
            ->latest()
            ->get();

        return view('admin.hotels.rooms', [
            'rooms'     => $rooms,
            'hotels'     => $hotels,
            'amenities' => Amenity::all(),
            'setting'   => Setting::first(),
            'search'    => $search,
        ]);
    }


    


    public function store(Request $request): RedirectResponse
    {
        $fileName = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('public/images/rooms');
            $fileName = basename($path);
        }
    
        $slug = Str::of($request->input('title'))->slug();
    
        $room = new HotelRoom();
        $room->room_type = $request->input('room_type');
        $room->max_occupancy = $request->input('max_occupancy');
        $room->price_per_night = $request->input('price_per_night');
        $room->total_rooms = $request->input('total_rooms');
        $room->available_rooms = $request->input('available_rooms');
        $room->description = $request->input('description');
        $room->hotel_id = $request->input('hotel_id');
        $room->image = $fileName;
        $room->slug = $slug;
        $room->added_by = $request->user()->id;
        $room->save();

        if ($request->has('amenities')) {
        $room->amenities()->sync($request->input('amenities'));
    }
    
        return redirect()->route('getRooms')->with('success', 'New Room has been saved successfully');
    }

    
public function edit($id)
{
    $room = HotelRoom::with('images')->findOrFail($id);
    $hotels = Hotel::latest()->get();
    $selectedAmenities = $room->amenities ? json_decode($room->amenities, true) : [];

    $images = $room->images ?? collect();
    $totalImages = $images->count();

    $allAmenities = Amenity::all();
    
    return view('admin.hotels.roomUpdate', [
        'room' => $room,
        'allAmenities' => $allAmenities,
        'selectedAmenities' => $selectedAmenities,
        'images' => $images,
        'hotels' => $hotels,
        'totalImages' => $totalImages,
    ]);
}


    public function view($id)
    {
        $room = HotelRoom::find($id);
        $program= Hotel::all();
        return view('admin.posts.blogView', [
            'service'=>$room,
            'program'=>$program,
        ]);
    }

public function update(Request $request, $id)
{
    try {
        $room = HotelRoom::findOrFail($id);

        // Upload new cover image
        if ($request->hasFile('image')) {
            Storage::delete('public/images/rooms/' . $room->image);

            $path = $request->file('image')->store('public/images/rooms');
            $room->image = basename($path);
        }

        // Update fields directly
        $room->hotel_id = $request->hotel_id;
        $room->room_type = $request->room_type;
        $room->price_per_night = $request->price_per_night;
        $room->max_occupancy = $request->max_occupancy;
        $room->total_rooms = $request->total_rooms;
        $room->available_rooms = $request->available_rooms;
        $room->description = $request->description;

        // Handle amenities as JSON
        $room->amenities = json_encode($request->amenities ?? []);

        // Slug only updates if room_type changed
        if ($room->isDirty('room_type')) {
            $slug = Str::slug($room->room_type);

            if (HotelRoom::where('slug', $slug)->where('id', '!=', $room->id)->exists()) {
                $slug .= '-' . uniqid();
            }

            $room->slug = $slug;
        }

        $room->save();

        return redirect()->route('getRooms')->with('success', 'Room updated successfully');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong');
    }
}

    


    public function destroy($id)
    {
        $room = HotelRoom::find($id); 
        if (!$room) {
            return back()->with('error', 'Content not found');
        }
        if ($room->image) {
            Storage::delete('public/images/rooms/' . $room->image);
        }
        $room->delete($id);
        return back()
            ->with('success', 'Story deleted successfully');
    }

    
    public function addRoomImage(Request $request)
        {
            $request->validate([
                'image.*'           => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
                'hotel_room_id' => 'required|exists:hotel_rooms,id', // Ensure the wedding gallery exists
            ]);

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $dir = 'public/images/rooms';
                    $path = $image->store($dir);
                    $fileName = str_replace($dir . '/', '', $path);

                    HotelRoomImage::create([
                        'image'             => $fileName,
                        'hotel_room_id' => $request->hotel_room_id, 
                        'added_by' => $request->user()->id
                    ]);
                }

                return redirect()->back()->with('success', 'Images uploaded successfully!');
            }

            return redirect()->back()->with('error', 'No images were uploaded.');
        }

    public function deleteRoomImage($id){
        $image = HotelRoomImage::findOrFail($id);

        $imagePath = 'public/images/rooms/' . $image->filename;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }

}
