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

                            <div class="d-flex flex-wrap gap-1" style="font-size: 0.85rem;">
                                <button class="btn btn-sm btn-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewHotelModal{{ $hotel->id }}">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editHotelModal{{ $hotel->id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addRoomModal"
                                    onclick="selectHotel({{ $hotel->id }})">
                                    <i class="fa fa-plus"></i> Add Room
                                </button>

                                <form action="{{ route('my.properties.hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this property?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- VIEW HOTEL MODAL --}}
                <div class="modal fade" id="viewHotelModal{{ $hotel->id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $hotel->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{-- Property Details --}}
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Property Details</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Name:</strong></td>
                                                <td>{{ $hotel->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Type:</strong></td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $hotel->type ?? 'N/A')) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Stars:</strong></td>
                                                <td>{{ $hotel->stars ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($hotel->status == 'Active')
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif($hotel->status == 'Pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Location:</strong></td>
                                                <td>{{ $hotel->location ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>City:</strong></td>
                                                <td>{{ $hotel->city ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address:</strong></td>
                                                <td>{{ $hotel->address ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ $hotel->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $hotel->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Website:</strong></td>
                                                <td>{{ $hotel->website ? '<a href="'.$hotel->website.'" target="_blank">'.$hotel->website.'</a>' : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                        @if($hotel->description)
                                            <div class="mt-3">
                                                <strong>Description:</strong>
                                                <p class="text-muted small">{{ $hotel->description }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Property Images --}}
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Property Images</h6>
                                        <div class="row g-2">
                                            @php
                                                $coverImg = $hotel->image && file_exists(storage_path('app/public/images/hotels/'.$hotel->image))
                                                    ? asset('storage/images/hotels/'.$hotel->image)
                                                    : asset('assets/img/tour/tour_3_1.jpg');
                                            @endphp
                                            <div class="col-6">
                                                <div class="position-relative">
                                                    <img src="{{ $coverImg }}" alt="Cover" class="img-fluid rounded" style="height:150px;object-fit:cover;width:100%;">
                                                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">Cover</span>
                                                </div>
                                            </div>
                                            @if($hotel->images && $hotel->images->count() > 0)
                                                @foreach($hotel->images->take(5) as $img)
                                                    <div class="col-6">
                                                        <div class="position-relative">
                                                            <img src="{{ asset('storage/images/hotels/'.$img->image) }}" alt="Image" class="img-fluid rounded" style="height:150px;object-fit:cover;width:100%;">
                                                            <form action="{{ route('my.properties.hotels.images.destroy', $img->id) }}" 
                                                                  method="POST" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this image?');"
                                                                  style="position: absolute; top: 5px; right: 5px;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 2px 6px;">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($hotel->images->count() > 5)
                                                    <div class="col-12">
                                                        <p class="text-muted small">+ {{ $hotel->images->count() - 5 }} more images</p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-12">
                                                    <p class="text-muted small">No additional images</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyGalleryModal{{ $hotel->id }}">
                                                <i class="fa fa-plus"></i> Add Images
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Rooms Section --}}
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Rooms ({{ $hotel->rooms->count() }})</h6>
                                    @if($hotel->rooms && $hotel->rooms->count() > 0)
                                        <div class="row g-3">
                                            @foreach($hotel->rooms as $room)
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="row g-0">
                                                            <div class="col-4">
                                                                @php
                                                                    $roomImg = $room->image && file_exists(storage_path('app/public/images/rooms/'.$room->image))
                                                                        ? asset('storage/images/rooms/'.$room->image)
                                                                        : asset('assets/img/tour/tour_3_1.jpg');
                                                                @endphp
                                                                <img src="{{ $roomImg }}" class="img-fluid rounded-start" style="height:100px;object-fit:cover;width:100%;" alt="{{ $room->room_type }}">
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="card-body p-2">
                                                                    <h6 class="card-title mb-1" style="font-size:0.9rem;">{{ $room->room_type }}</h6>
                                                                    <p class="card-text small mb-1">
                                                                        <strong>Price:</strong> ${{ number_format($room->price_per_night ?? 0, 2) }}/night<br>
                                                                        <strong>Max Occupancy:</strong> {{ $room->max_occupancy ?? 'N/A' }}<br>
                                                                        <strong>Available:</strong> {{ $room->available_rooms ?? 0 }}/{{ $room->total_rooms ?? 0 }}
                                                                    </p>
                                                                    @if($room->status)
                                                                        <span class="badge bg-{{ $room->status == 'Available' ? 'success' : 'danger' }}">{{ $room->status }}</span>
                                                                    @endif
                                                                    <div class="mt-2 d-flex gap-1">
                                                                        <button class="btn btn-sm btn-warning" 
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#editRoomModal{{ $room->id }}">
                                                                            <i class="fa fa-edit"></i> Edit
                                                                        </button>
                                                                        <form action="{{ route('my.properties.rooms.destroy', $room->id) }}" 
                                                                            method="POST" 
                                                                            onsubmit="return confirm('Are you sure you want to delete this room?');"
                                                                            style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                                <i class="fa fa-trash"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- EDIT ROOM MODAL --}}
                                                <div class="modal fade" id="editRoomModal{{ $room->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form action="{{ route('my.properties.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Room</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label>Room Type</label>
                                                                            <input type="text" class="form-control" name="room_type" value="{{ $room->room_type }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Currency</label>
                                                                            <select name="currency" class="form-control">
                                                                                <option value="USD" {{ ($room->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                                                <option value="EUR" {{ ($room->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                                                <option value="GBP" {{ ($room->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                                                                <option value="RWF" {{ ($room->currency ?? '') == 'RWF' ? 'selected' : '' }}>RWF (Fr)</option>
                                                                                <option value="KES" {{ ($room->currency ?? '') == 'KES' ? 'selected' : '' }}>KES (KSh)</option>
                                                                                <option value="UGX" {{ ($room->currency ?? '') == 'UGX' ? 'selected' : '' }}>UGX (USh)</option>
                                                                                <option value="TZS" {{ ($room->currency ?? '') == 'TZS' ? 'selected' : '' }}>TZS (TSh)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Price Display Type</label>
                                                                            <select name="price_display_type" class="form-control">
                                                                                <option value="per_night" {{ ($room->price_display_type ?? 'per_night') == 'per_night' ? 'selected' : '' }}>Per Night</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Price per Night</label>
                                                                            <input type="number" step="0.01" class="form-control" name="price_per_night" value="{{ $room->price_per_night }}" required>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label>Max Occupancy</label>
                                                                            <input type="number" class="form-control" name="max_occupancy" value="{{ $room->max_occupancy }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Total Rooms</label>
                                                                            <input type="number" class="form-control" name="total_rooms" value="{{ $room->total_rooms }}">
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>Available Rooms</label>
                                                                            <input type="number" class="form-control" name="available_rooms" value="{{ $room->available_rooms }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label>Status</label>
                                                                            <select class="form-control" name="status">
                                                                                <option value="Available" @selected($room->status == 'Available')>Available</option>
                                                                                <option value="Unavailable" @selected($room->status == 'Unavailable')>Unavailable</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Change Room Image</label>
                                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                                            @if($room->image)
                                                                                <small class="text-muted">Current: {{ $room->image }}</small>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Description</label>
                                                                        <textarea class="form-control" name="description" rows="3">{{ $room->description }}</textarea>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-lg-12">
                                                                            <label class="form-label">Select Room Amenities</label>
                                                                            <div class="row">
                                                                                @php
                                                                                    $selectedAmenities = $room->amenities ? (is_array($room->amenities) ? $room->amenities : json_decode($room->amenities, true)) : [];
                                                                                @endphp
                                                                                @foreach($amenities as $amenity)
                                                                                    <div class="col-md-4 mb-2">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="checkbox"
                                                                                                name="amenities[]" 
                                                                                                value="{{ $amenity->id }}" 
                                                                                                id="amenity{{ $room->id }}_{{ $amenity->id }}"
                                                                                                @if(in_array($amenity->id, $selectedAmenities ?? [])) checked @endif>

                                                                                            <label class="form-check-label" for="amenity{{ $room->id }}_{{ $amenity->id }}">
                                                                                                {{ $amenity->title }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Room Gallery Section --}}
                                                                    <div class="row mt-4">
                                                                        <div class="col-12">
                                                                            <hr>
                                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                <h6 class="mb-0">
                                                                                    <i class="fas fa-images me-2"></i>Room Gallery 
                                                                                    <span class="badge bg-primary">{{ $room->images->count() ?? 0 }} Images</span>
                                                                                </h6>
                                                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomGalleryModal{{ $room->id }}">
                                                                                    <i class="fa fa-plus"></i> Add Images
                                                                                </button>
                                                                            </div>
                                                                            
                                                                            @if($room->images && $room->images->count() > 0)
                                                                                <div class="row g-2">
                                                                                    @foreach($room->images as $galleryImage)
                                                                                        <div class="col-md-3 col-sm-4">
                                                                                            <div class="position-relative">
                                                                                                <img src="{{ asset('storage/images/rooms/' . $galleryImage->image) }}" 
                                                                                                     alt="Gallery Image" 
                                                                                                     class="img-fluid rounded" 
                                                                                                     style="width: 100%; height: 120px; object-fit: cover;">
                                                                                                <form action="{{ route('my.properties.rooms.images.destroy', $galleryImage->id) }}" 
                                                                                                      method="POST" 
                                                                                                      onsubmit="return confirm('Are you sure you want to delete this image?');"
                                                                                                      style="position: absolute; top: 5px; right: 5px;">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit" class="btn btn-sm btn-danger" style="padding: 2px 6px;">
                                                                                                        <i class="fa fa-times"></i>
                                                                                                    </button>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @else
                                                                                <p class="text-muted small mb-0">No gallery images yet. Click "Add Images" to upload.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button class="btn btn-primary" type="submit">
                                                                        <i class="fa fa-save"></i> Update Room
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- ADD ROOM GALLERY MODAL --}}
                                                <div class="modal fade" id="addRoomGalleryModal{{ $room->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('my.properties.rooms.images.store', $room->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Add Images to {{ $room->room_type }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="images{{ $room->id }}" class="form-label">Select Images</label>
                                                                        <input type="file" 
                                                                               class="form-control" 
                                                                               id="images{{ $room->id }}" 
                                                                               name="image[]" 
                                                                               multiple 
                                                                               accept="image/*" 
                                                                               required>
                                                                        <small class="text-muted">You can select multiple images at once. Max size: 2MB per image.</small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="fa fa-upload"></i> Upload Images
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No rooms added yet. Click "Add Room" to add rooms to this property.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EDIT HOTEL MODAL --}}
                <div class="modal fade" id="editHotelModal{{ $hotel->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                        <form action="{{ route('my.properties.hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" value="{{ $hotel->status ?? 'Pending' }}" disabled readonly>
                                        <small class="text-muted">Only admins can change property status. Contact admin for approval.</small>
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

                                {{-- Property Gallery Section --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">
                                                <i class="fas fa-images me-2"></i>Property Gallery 
                                                <span class="badge bg-primary">{{ $hotel->images->count() ?? 0 }} Images</span>
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyGalleryModal{{ $hotel->id }}">
                                                <i class="fa fa-plus"></i> Add Images
                                            </button>
                                        </div>
                                        
                                        @if($hotel->images && $hotel->images->count() > 0)
                                            <div class="row g-2">
                                                @foreach($hotel->images as $galleryImage)
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="position-relative">
                                                            <img src="{{ asset('storage/images/hotels/' . $galleryImage->image) }}" 
                                                                 alt="Gallery Image" 
                                                                 class="img-fluid rounded" 
                                                                 style="width: 100%; height: 120px; object-fit: cover;">
                                                            <form action="{{ route('my.properties.hotels.images.destroy', $galleryImage->id) }}" 
                                                                  method="POST" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this image?');"
                                                                  style="position: absolute; top: 5px; right: 5px;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 2px 6px;">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted small mb-0">No gallery images yet. Click "Add Images" to upload.</p>
                                        @endif
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

                {{-- ADD PROPERTY GALLERY MODAL --}}
                <div class="modal fade" id="addPropertyGalleryModal{{ $hotel->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('my.properties.hotels.images.store', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Images to {{ $hotel->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="propertyImages{{ $hotel->id }}" class="form-label">Select Images</label>
                                        <input type="file" 
                                               class="form-control" 
                                               id="propertyImages{{ $hotel->id }}" 
                                               name="image[]" 
                                               multiple 
                                               accept="image/*" 
                                               required>
                                        <small class="text-muted">You can select multiple images at once. Max size: 4MB per image.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-upload"></i> Upload Images
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

            <form id="add-room-form" action="" method="POST" enctype="multipart/form-data">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Currency</label>
                            <select name="currency" class="form-control">
                                <option value="USD" selected>USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="RWF">RWF (Fr)</option>
                                <option value="KES">KES (KSh)</option>
                                <option value="UGX">UGX (USh)</option>
                                <option value="TZS">TZS (TSh)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Price Display Type</label>
                            <select name="price_display_type" class="form-control">
                                <option value="per_night" selected>Per Night</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Price per Night</label>
                            <input type="number" step="0.01" class="form-control" name="price_per_night" required>
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
        // Point the form to the correct rooms store route for this hotel
        var form = document.getElementById('add-room-form');
        form.action = "{{ url('/my-properties/hotels') }}/" + id + "/rooms";
    }
</script>
@endsection
