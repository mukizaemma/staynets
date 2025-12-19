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

            <div class="container-fluid px-4">


                <ul class="nav mt-10">
                    <li class="nav-item mr-20 ">
                        <a href="{{ route('getCars') }}" class="btn btn-dark">Back</a>
                    </li>
                    <li class="nav-item ">
                        
                    <li class="breadcrumb-item active">Updating <strong> {{$car->title}}</strong></li>

                    </li>
                    <li class="nav-item ms-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newImage">
                            Add New Image
                        </button>
                    </li>
                </ul>

                <div class="container-fluid px-4">

                    <div class="card mb-4">

                        <div class="card-body">
                        <form action="{{ route('updateCar', $car->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-body">

                                {{-- Advert title --}}
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">Advert title</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $car->name) }}" required>
                                    </div>
                                </div>

                                {{-- Cover Image --}}
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-label">Current Cover Image</label><br>
                                        <img src="{{ asset('storage/images/cars/' . $car->image) }}" width="150" class="rounded">
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-label">Change Cover Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                {{-- Fuel / Transmission / Seats --}}
                                <div class="row mb-3 mt-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Fuel Type</label>
                                        <select name="fuel_type" class="form-control">
                                            <option value="">Select</option>
                                            @foreach(['Petrol','Diesel','Hybrid','Electric'] as $fuel)
                                                <option value="{{ $fuel }}" {{ $car->fuel_type === $fuel ? 'selected' : '' }}>
                                                    {{ $fuel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Transmission</label>
                                        <select name="transmission" class="form-control">
                                            <option value="">Select</option>
                                            @foreach(['Automatic','Manual','Semi-Automatic'] as $trans)
                                                <option value="{{ $trans }}" {{ $car->transmission === $trans ? 'selected' : '' }}>
                                                    {{ $trans }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Seats</label>
                                        <input type="number" name="seats" class="form-control" min="1"
                                            value="{{ old('seats', $car->seats) }}">
                                    </div>
                                </div>

                                {{-- Pricing --}}
                                <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Price / Day</label>
                                        <input type="number" step="0.01" name="price_per_day"
                                            class="form-control"
                                            value="{{ old('price_per_day', $car->price_per_day) }}">
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Price / Month</label>
                                        <input type="number" step="0.01" name="price_per_month"
                                            class="form-control"
                                            value="{{ old('price_per_month', $car->price_per_month) }}">
                                    </div>

                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label">Buy Price</label>
                                        <input type="number" step="0.01" name="price_to_buy"
                                            class="form-control"
                                            value="{{ old('price_to_buy', $car->price_to_buy) }}">
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="5"
                                                name="description">{{ old('description', $car->description) }}</textarea>
                                    </div>
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="form-actions mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Car
                                </button>

                                <a href="{{ route('getCars') }}" class="btn btn-light">
                                    Back
                                </a>
                            </div>
                        </form>

                        </div>
                    </div>

                        <!-- Image Gallery Section -->
                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <h5 class="mb-0">
                                    <span style="color: yellow">{{ $totalImages }}</span> Images
                                </h5>
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#newImage">
                                    Add New Image
                                </button>
                            </div>
                            
                            <div class="card-body">
                                @if($images->count() == 0)
                                    <p class="text-muted">No images yet.</p>
                                @else
                                    <div class="row">
                                        @foreach($images as $image)
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            {{-- <div class="card shadow" style="position: relative; overflow: hidden; transition: 0.3s;">
                                                <img src="{{ asset('storage/images/trips/' . $image->images) }}" 
                                                    class="card-img-top rounded" alt="Blog Image" style="width: 100%; height: auto;">
                                                <button onclick="confirmDelete('{{ route('deleteTripImage', $image->id) }}')" 
                                                        style="position: absolute; top: 10px; right: 10px; background: rgba(255, 0, 0, 0.8); color: white; border: none; padding: 6px 10px; border-radius: 50%; cursor: pointer; transition: 0.3s;">
                                                    ×
                                                </button>
                                                <div class="card-body text-center">
                                                    <h6 class="card-title text-truncate" style="max-width: 100%;">{{ $image->caption }}</h6>
                                                </div>
                                            </div> --}}
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                
                </div>



            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')


        <!-- Add Image Modal -->
<div class="modal fade" id="newImage">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Adding New Image to {{ $car->title ?? '' }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form class="form" action="{{ route('addTripImage',['id'=>$car->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-sm-12">
                            <label for="image" class="form-label">Upload Images</label>
                            <div class="input-group">
                                <input type="hidden" name="trip_id" value="{{ $car->id }}">
                                <input type="file" name="image[]" class="form-control" id="image" multiple>
                            </div>
                            <small class="text-muted">You can upload one or multiple images.</small>
                        </div>
                    </div>
                </div>
            
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary text-black">
                        <i class="fa fa-save"></i> Upload
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this image? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="" id="deleteConfirmBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        document.getElementById('deleteConfirmBtn').setAttribute('href', deleteUrl);
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }
</script>

 @endsection