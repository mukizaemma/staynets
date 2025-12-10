@extends('layouts.frontbase')

@section('content')
<div class="container" style="width:90%; margin:20px auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="box-title">My Properties</h2>
        <a href="{{ route('myPropertyCreate') }}" class="th-btn style4 th-icon">Add New Hotel</a>
        
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($hotels->isEmpty())
        <div class="card p-4 text-center">
            <h4>You don't have any properties yet</h4>
            <p class="mb-3">Click the button below to add your first hotel.</p>
            <a href="{{ route('myPropertyCreate') }}" class="th-btn style4 th-icon">Add First Hotel</a>

        </div>
    @else
        <div class="row gy-4">
            @foreach($hotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <div class="tour-box th-ani">
                        <div class="tour-box_img global-img">
                            @php
                                $img = $hotel->image && file_exists(storage_path('app/public/images/hotels/' . $hotel->image))
                                    ? asset('storage/images/hotels/' . $hotel->image)
                                    : asset('assets/img/tour/tour_3_1.jpg');
                            @endphp
                            <img src="{{ $img }}" alt="{{ $hotel->name }}" style="height:220px; object-fit:cover;">
                        </div>

                        <div class="tour-content">
                            <h3 class="box-title">{{ $hotel->name }}</h3>
                            <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($hotel->description), 120) }}</p>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('myProperties', $hotel) }}" class="th-btn style4 th-icon">View</a>
                                <a href="{{ route('myProperties', $hotel) }}" class="th-btn style3">Edit</a>
                                <a href="{{ route('myProperties', $hotel) }}" class="th-btn style4">Add Room</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


</div>

        <div class="modal fade" id="slideImage">
            <div class="modal-dialog modal-lg">
            <form class="form" action="{{ route('storeHotel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Adding New Hotel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-body">

                            <!-- Partner Logo -->
                            <div class="row mb-4">
                                <div class="col-lg-4 col-sm-12">
                                    <label>Service</label>
                                    <select class="form-control" name="program_id" required>
                                        <option value="" disabled selected>Select Service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <label>Hotel Cover Image</label>
                                    <label id="projectinput7" class="file center-block">
                                        <input type="file" id="image" name="image" required>
                                        <span class="file-custom"></span>
                                    </label>
                                </div>

                            </div>

                            <!-- Name & Website -->
                            <div class="row mb-3">
                                <div class="col-lg-8 col-sm-12">
                                    <label>Hotel Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Business name" required>
                                </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>Location</label>
                                <select class="form-control" name="category_id" required>
                                    <option value="" disabled selected>Select Type</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            </div>

                            <!-- Partner Type -->
                           <div class="row mb-3">

                            <!-- Partner Type -->
                            <div class="col-lg-4 col-sm-12">
                                <label>Partner Type</label>
                                <select class="form-control" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="lodge">Lodge</option>
                                    <option value="guest_house">Guest House</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="motel">Motel</option>
                                    <option value="resort">Resort</option>
                                </select>
                            </div>

                            <!-- Stars / Rating -->
                            <div class="col-lg-4 col-sm-12">
                                <label>Stars</label>
                                <select class="form-control" name="stars" required>
                                    <option value="">Select Rating</option>
                                    <option value="0">Not Ranked</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>

                            <!-- Location - All Districts -->
                            <div class="col-lg-4 col-sm-12">
                                <label>Location (District)</label>
                                <select class="form-control" name="location" required>
                                    <option value="">Select District</option>

                                    <!-- Kigali -->
                                    <optgroup label="Kigali City">
                                        <option value="Gasabo">Gasabo</option>
                                        <option value="Kicukiro">Kicukiro</option>
                                        <option value="Nyarugenge">Nyarugenge</option>
                                    </optgroup>

                                    <!-- Northern Province -->
                                    <optgroup label="Northern Province">
                                        <option value="Burera">Burera</option>
                                        <option value="Gakenke">Gakenke</option>
                                        <option value="Gicumbi">Gicumbi</option>
                                        <option value="Musanze">Musanze</option>
                                        <option value="Rulindo">Rulindo</option>
                                    </optgroup>

                                    <!-- Southern Province -->
                                    <optgroup label="Southern Province">
                                        <option value="Gisagara">Gisagara</option>
                                        <option value="Huye">Huye</option>
                                        <option value="Kamonyi">Kamonyi</option>
                                        <option value="Muhanga">Muhanga</option>
                                        <option value="Nyamagabe">Nyamagabe</option>
                                        <option value="Nyanza">Nyanza</option>
                                        <option value="Nyaruguru">Nyaruguru</option>
                                        <option value="Ruhango">Ruhango</option>
                                    </optgroup>

                                    <!-- Eastern Province -->
                                    <optgroup label="Eastern Province">
                                        <option value="Bugesera">Bugesera</option>
                                        <option value="Gatsibo">Gatsibo</option>
                                        <option value="Kayonza">Kayonza</option>
                                        <option value="Kirehe">Kirehe</option>
                                        <option value="Ngoma">Ngoma</option>
                                        <option value="Nyagatare">Nyagatare</option>
                                        <option value="Rwamagana">Rwamagana</option>
                                    </optgroup>

                                    <!-- Western Province -->
                                    <optgroup label="Western Province">
                                        <option value="Karongi">Karongi</option>
                                        <option value="Ngororero">Ngororero</option>
                                        <option value="Nyabihu">Nyabihu</option>
                                        <option value="Nyamasheke">Nyamasheke</option>
                                        <option value="Rubavu">Rubavu</option>
                                        <option value="Rutsiro">Rutsiro</option>
                                        <option value="Rusizi">Rusizi</option>
                                    </optgroup>
                                </select>
                            </div>

                        </div>


                            <!-- Email & Phone -->
                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="example@email.com">
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" placeholder="+250 7XX XXX XXX">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label>Hotel Website URL</label>
                                    <input type="text" class="form-control" name="website" placeholder="Eg: https://www.example.com">
                                </div>
                            </div>

                            <!-- Address & City -->
                            <div class="row mb-3">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Street, Building, etc">
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" placeholder="Kigali, Musanze, Rubavu…">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-label">Hotel Description</label>
                                    <textarea id="hotelDescription" rows="5" class="form-control" name="description"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-black">
                            <i class="fa fa-save"></i> Add New
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>

            </div>
        </div>

@endsection
