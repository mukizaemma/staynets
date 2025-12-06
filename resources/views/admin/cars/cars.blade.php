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
                        <h6 class="mb-0">Our Recent Published Cars</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Car
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Trip Title</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cars as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editTrip',['id'=>$rs->id]) }}">{{ $rs->title }}</a> 
                                    <br> <spam>{{$rs->images->count()}} Images  
                                    </td>
                                    <td><img src="{{ asset('storage/images/trips/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! Str::words($rs->description, 50, '...') !!}</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editTrip',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-images"></i></a>
                                                <a href="{{ route('deleteTrip',['id'=>$rs->id]) }}" class="btn btn-warning"  onclick="return confirm('Are you sure to delete this item?')"><i class="fa fa-trash"></i></a>
                                            </div>
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
                <h4 class="modal-title">Adding New Trip</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeCar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="row mb-3">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label">Advert Type</label>
                                    <select name="advert_type" id="advert_type" class="form-control" required>
                                        <option value="rent">Rent</option>
                                        <option value="sell">Sell</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label">Seervice</label>
                                    <select name="program_id" class="form-control" required>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label">Car Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label">Model</label>
                                    <input type="text" name="model" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Fuel Type</label>
                                        <select name="fuel_type" class="form-control" required>
                                            <option value="" disabled selected>Select Fuel Type</option>
                                            <option value="Petrol">Petrol</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="Hybrid">Hybrid</option>
                                            <option value="Electric">Electric</option>
                                        </select>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Transmission</label>

                                        <select name="transmission" class="form-control" required>
                                            <option value="">Select Transmission</option>
                                            <option value="Automatic">Automatic</option>
                                            <option value="Manual">Manual</option>
                                            <option value="Semi-Automatic">Semi-Automatic</option>
                                        </select>

                                </div>
                                    <div class="col-lg-4 col-sm-12">
                                    <label class="form-label">Seats</label>
                                    <input type="number" name="seats" class="form-control" min="1">
                                </div>
                            </div>


                            <div id="rent_fields">
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Price Per Day</label>
                                        <input type="number" step="0.01" name="price_per_day" id="price_per_day" class="form-control">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label">Price Per Month</label>
                                        <input type="number" step="0.01" name="price_per_month" id="price_per_month" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div id="sell_fields" style="display:none;">
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">Buy Price</label>
                                        <input type="number" step="0.01" name="price_to_buy" id="price_to_buy" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Car Images</label>
                                    <input type="file" name="images[]" class="form-control" multiple>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="5" class="form-control" name="description"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary text-black">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const advertType = document.getElementById('advert_type');
                        const rentFields = document.getElementById('rent_fields');
                        const sellFields = document.getElementById('sell_fields');
                        const pricePerDay = document.getElementById('price_per_day');
                        const pricePerMonth = document.getElementById('price_per_month');
                        const priceToBuy = document.getElementById('price_to_buy');

                        function toggleFields() {
                            if (advertType.value === 'rent') {
                                rentFields.style.display = '';
                                sellFields.style.display = 'none';
                                pricePerDay.required = true;
                                pricePerMonth.required = true;
                                priceToBuy.required = false;
                                priceToBuy.value = '';
                            } else {
                                rentFields.style.display = 'none';
                                sellFields.style.display = '';
                                pricePerDay.required = false;
                                pricePerMonth.required = false;
                                pricePerDay.value = '';
                                pricePerMonth.value = '';
                                priceToBuy.required = true;
                            }
                        }

                        advertType.addEventListener('change', toggleFields);
                        toggleFields();
                    });
                    </script>

                    
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </div>
            </div>
        </div>
        @include('admin.includes.footer')
 @endsection