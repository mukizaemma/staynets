@extends('layouts.frontbase')

@section('content')
<div class="container" style="width:90%; margin:20px auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="box-title">My Properties</h2>
        <a href="{{ route('myPropertyCreate') }}" class="th-btn style4">Add New Hotel</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($hotels->isEmpty())
        <div class="card p-4 text-center">
            <h4>You don't have any properties yet</h4>
            <a href="{{ route('myPropertyCreate') }}" class="th-btn style4">Add First Hotel</a>
        </div>
    @else
        <div class="row gy-4">
            @foreach($hotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <div class="tour-box">
                        <div class="tour-box_img">
                            @php
                                $img = $hotel->image && file_exists(storage_path('app/public/images/hotels/'.$hotel->image))
                                    ? asset('storage/images/hotels/'.$hotel->image)
                                    : asset('assets/img/tour/tour_3_1.jpg');
                            @endphp
                            <img src="{{ $img }}" alt="{{ $hotel->name }}" style="height:220px;object-fit:cover;">
                        </div>

                        <div class="tour-content">
                            <h3 class="box-title">{{ $hotel->name }}</h3>
                            <p class="small text-muted">
                                {{ Str::limit(strip_tags($hotel->description),120) }}
                            </p>

                            <div class="d-flex justify-content-between">
                                <button class="th-btn style3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editHotelModal{{ $hotel->id }}">
                                    Edit
                                </button>

                                <button class="th-btn style4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addRoomModal"
                                    onclick="selectHotel({{ $hotel->id }})">
                                    Add Room
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EDIT HOTEL MODAL --}}
                <div class="modal fade" id="editHotelModal{{ $hotel->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                        <form action="{{ route('updateHotel', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Property</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                {{-- Name & Image --}}
                                <div class="row mb-3">
                                    <div class="col-lg-8 col-sm-12">
                                        <label>Property Name</label>
                                        <input type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ $hotel->name }}"
                                            required>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Change Cover Image</label>
                                        <input type="file"
                                            name="image"
                                            class="form-control"
                                            accept="image/*">
                                    </div>
                                </div>

                                {{-- Type & Stars --}}
                                <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label>Property Type</label>
                                        <select class="form-control" name="type" required>
                                            <option value="hotel" @selected($hotel->type=='hotel')>Hotel</option>
                                            <option value="lodge" @selected($hotel->type=='lodge')>Lodge</option>
                                            <option value="guest_house" @selected($hotel->type=='guest_house')>Guest House</option>
                                            <option value="apartment" @selected($hotel->type=='apartment')>Apartment</option>
                                            <option value="motel" @selected($hotel->type=='motel')>Motel</option>
                                            <option value="resort" @selected($hotel->type=='resort')>Resort</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Stars</label>
                                        <select class="form-control" name="stars" required>
                                            <option value="0" @selected($hotel->stars==='0')>Not Ranked</option>
                                            <option value="1" @selected($hotel->stars=='1')>1 Star</option>
                                            <option value="2" @selected($hotel->stars=='2')>2 Stars</option>
                                            <option value="3" @selected($hotel->stars=='3')>3 Stars</option>
                                            <option value="4" @selected($hotel->stars=='4')>4 Stars</option>
                                            <option value="5" @selected($hotel->stars=='5')>5 Stars</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="Active" @selected($hotel->status=='Active')>Active</option>
                                            <option value="Inactive" @selected($hotel->status=='Inactive')>Inactive</option>
                                            <option value="Draft" @selected($hotel->status=='Draft')>Draft</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label>Location (District)</label>
                                        <select class="form-control" name="location" required>
                                            <option value="Gasabo" @selected($hotel->location=='Gasabo')>Gasabo</option>
                                            <option value="Kicukiro" @selected($hotel->location=='Kicukiro')>Kicukiro</option>
                                            <option value="Nyarugenge" @selected($hotel->location=='Nyarugenge')>Nyarugenge</option>
                                            <option value="Musanze" @selected($hotel->location=='Musanze')>Musanze</option>
                                            <option value="Rubavu" @selected($hotel->location=='Rubavu')>Rubavu</option>
                                            <option value="Huye" @selected($hotel->location=='Huye')>Huye</option>
                                            {{-- add others if needed --}}
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Address</label>
                                        <input type="text"
                                            class="form-control"
                                            name="address"
                                            value="{{ $hotel->address }}">
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>City</label>
                                        <input type="text"
                                            class="form-control"
                                            name="city"
                                            value="{{ $hotel->city }}">
                                    </div>
                                </div>

                                {{-- Contacts --}}
                                <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label>Contact Email</label>
                                        <input type="email"
                                            class="form-control"
                                            name="email"
                                            value="{{ $hotel->email }}">
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Contact Phone</label>
                                        <input type="text"
                                            class="form-control"
                                            name="phone"
                                            value="{{ $hotel->phone }}">
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label>Website</label>
                                        <input type="text"
                                            class="form-control"
                                            name="website"
                                            value="{{ $hotel->website }}">
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label>Property Description</label>
                                        <textarea rows="5"
                                                class="form-control"
                                                name="description">{{ $hotel->description }}</textarea>
                                    </div>
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="modal-footer">
                                <button class="btn btn-primary text-black" type="submit">
                                    <i class="fa fa-save"></i> Update Property
                                </button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </form>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ADD ROOM MODAL --}}
<div class="modal fade" id="addRoomModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('storeRoom') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hotel_id" id="selectedHotel">

                <div class="modal-header">
                    <h5>Add Room to {{ $properry->name ?? '' }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Room Type</label>
                            <input type="text" class="form-control" name="room_type" required>
                        </div>
                        <div class="col-md-6">
                            <label>Price per Night</label>
                            <input type="number" class="form-control" name="price_per_night" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Max Occupancy</label>
                            <input type="number" class="form-control" name="max_occupancy" required>
                        </div>
                        <div class="col-md-4">
                            <label>Total Rooms</label>
                            <input type="number" class="form-control" name="total_rooms" required>
                        </div>
                        <div class="col-md-4">
                            <label>Available Rooms</label>
                            <input type="number" class="form-control" name="available_rooms" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Room Image</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <label class="form-label">Select Room Amenities</label>
                            <div class="row">
                                @foreach($amenities as $amenity)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="amenities[]" 
                                                value="{{ $amenity->id }}" 
                                                id="amenity{{ $amenity->id }}">

                                            <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                                {{ $amenity->title }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    
                    <button class="btn btn-primary">Save Room</button>
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function selectHotel(id) {
        document.getElementById('selectedHotel').value = id;
    }
</script>
@endsection
