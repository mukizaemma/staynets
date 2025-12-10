@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">


            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Our Rooms</h6>

                        <div class="d-flex gap-2">

                            <!-- Search Bar -->
                            <form method="GET" action="{{ route('getRooms') }}" class="d-flex">
                                <div class="input-group">
                                    <input type="text" id="roomSearch" name="search"
                                        placeholder="Search rooms by type, price, amenities..."
                                        value="{{ request('search') }}"
                                        class="form-control">
                                    
                                    @if(request('search'))
                                        <a href="{{ route('getRooms') }}" 
                                        class="btn btn-outline-secondary">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif

                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- Add New Room Button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Room
                            </button>

                        </div>
                    </div>

                    <div class="table-responsive">

                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="roomTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Room Details</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Price (USD)</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" style="width:120px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($rooms as $rs)
                                <tr>

                                    <!-- Room Type -->
                                    <td>
                                        <a href="{{ route('editRoom', ['id' => $rs->id]) }}">
                                            {{ $rs->room_type }}
                                        </a>
                                        <br>
                                        <span class="text-muted">
                                            {{ $rs->max_occupancy }} Persons • 
                                            {{ $rs->available_rooms }}/{{ $rs->total_rooms }} Available<br>
                                            {{ $rs->hotel->name ?? '' }}
                                        </span>
                                    </td>

                                    <!-- Cover Image -->
                                    <td>
                                        <img src="{{ asset('storage/images/rooms/' . $rs->image) }}" 
                                            alt="Room Image" 
                                            width="120px" 
                                            class="rounded">
                                    </td>

                                    <!-- Price -->
                                    <td>
                                        ${{ number_format($rs->price_per_night, 2) }}
                                    </td>

                                    <!-- Description -->
                                    <td>{!! Str::words($rs->description, 40, '...') !!}</td>

                                    <!-- Action -->
                                    <td>
                                        <div class="btn-group" role="group">
                                                <a href="{{ route('editRoom',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-images"></i></a>

                                            <a href="{{ route('deleteRoom', ['id' => $rs->id]) }}" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure to delete this room?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>
        <!-- Content End -->


        <!-- The Modal -->
        <div class="modal fade" id="NewProduct">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Adding New Room</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeRoom') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <!-- Select Hotel -->
                            <div class="row mb-3">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label">Select Hotel</label>
                                    <select name="hotel_id" class="form-control" required>
                                        <option value="">-- Select Hotel --</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}">
                                                {{ $hotel->name }} ({{ $hotel->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Room Type, Price, Image -->
                            <div class="row mb-3">

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Room Type / Room Name</label>
                                    <input type="text" name="room_type" class="form-control"
                                        placeholder="Eg: Double Room" required>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Price per Night (USD)</label>
                                    <input type="number" step="0.01" name="price_per_night" class="form-control"
                                        placeholder="Eg: 50" required>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Cover Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                            </div>

                            <!-- Occupancy + Rooms Count -->
                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Max Occupancy</label>
                                    <input type="number" name="max_occupancy" class="form-control"
                                        placeholder="Eg: 2" required>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Total Rooms</label>
                                    <input type="number" name="total_rooms" class="form-control"
                                        placeholder="Eg: 10" required>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Available Rooms</label>
                                    <input type="number" name="available_rooms" class="form-control"
                                        placeholder="Eg: 8" required>
                                </div>
                            </div>

                            <!-- Room Description -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-label">Room Description</label>
                                    <textarea id="description" rows="5" class="form-control" 
                                        name="description"></textarea>
                                </div>
                            </div>

                            <!-- Amenities -->
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

                        <!-- Submit -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary text-black">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>

                    </form>


                    
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </div>
            </div>
        </div>

        <script>
            document.getElementById('roomSearch').addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#roomTable tbody tr');

                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        </script>


        @include('admin.includes.footer')
 @endsection