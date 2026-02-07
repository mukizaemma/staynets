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
                    <h6 class="mb-0">Edit Property</h6>
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Basic Information</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Property Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" value="{{ old('name', $property->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="property_type" class="form-label">Property Type <span class="text-danger">*</span></label>
                            <select name="property_type" class="form-select @error('property_type') is-invalid @enderror" id="property_type" required>
                                <option value="hotel" {{ old('property_type', $property->property_type) == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="apartment" {{ old('property_type', $property->property_type) == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="guesthouse" {{ old('property_type', $property->property_type) == 'guesthouse' ? 'selected' : '' }}>Guest House</option>
                                <option value="lodge" {{ old('property_type', $property->property_type) == 'lodge' ? 'selected' : '' }}>Lodge</option>
                            </select>
                            @error('property_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stars" class="form-label">Stars (Hotels)</label>
                            <input type="text" name="stars" class="form-control @error('stars') is-invalid @enderror" 
                                   id="stars" value="{{ old('stars', $property->stars) }}" placeholder="e.g., 3, 4, 5">
                            @error('stars')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="owner_id" class="form-label">Owner <span class="text-danger">*</span></label>
                            <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" id="owner_id" required>
                                <option value="">Select Owner</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('owner_id', $property->owner_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" id="status" required>
                                <option value="Pending" {{ old('status', $property->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Active" {{ old('status', $property->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $property->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label d-block">Settings</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" 
                                       {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_verified" id="is_verified" value="1" 
                                       {{ old('is_verified', $property->is_verified) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_verified">Verified</label>
                            </div>
                        </div>
                    </div>

                    <!-- Categories & Relationships -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Categories & Relationships</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category_id" class="form-label">Category/Destination</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="program_id" class="form-label">Program/Service</label>
                            <select name="program_id" class="form-select @error('program_id') is-invalid @enderror" id="program_id">
                                <option value="">Select Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id', $property->program_id) == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="partner_id" class="form-label">Partner</label>
                            <select name="partner_id" class="form-select @error('partner_id') is-invalid @enderror" id="partner_id">
                                <option value="">Select Partner</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}" {{ old('partner_id', $property->partner_id) == $partner->id ? 'selected' : '' }}>
                                        {{ $partner->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('partner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Location</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" value="{{ old('address', $property->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" value="{{ old('city', $property->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" value="{{ old('location', $property->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Map Embed Code -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Map Location</h5>
                            <p class="text-muted mb-3">
                                <small>Paste an embedded Google Maps iframe code to display the location on the property page.</small>
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="map_embed_code" class="form-label">Google Maps Embed Code (Optional)</label>
                            <textarea name="map_embed_code" class="form-control @error('map_embed_code') is-invalid @enderror" 
                                      id="map_embed_code" rows="4" 
                                      placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ old('map_embed_code', $property->map_embed_code) }}</textarea>
                            <small class="text-muted">Paste the full iframe code from Google Maps embed.</small>
                            @error('map_embed_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Contact Information</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" value="{{ old('phone', $property->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ old('email', $property->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" value="{{ old('website', $property->website) }}">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Description</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="propertyDescription" class="form-label">Property Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      id="propertyDescription" rows="6">{{ old('description', $property->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Featured Image</h5>
                            <p class="text-muted mb-3">Main featured image for the property (displayed as the primary image).</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="featured_image" class="form-label">Upload Featured Image</label>
                            @if($property->featured_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/images/properties/' . $property->featured_image) }}" alt="Current featured image" class="img-thumbnail" style="max-width: 100%; height: auto; max-height: 300px;">
                                </div>
                            @endif
                            <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Facilities/Amenities -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Facilities/Amenities</h5>
                            <p class="text-muted mb-3">Select amenities for this property, grouped by category:</p>
                        </div>
                        @php
                            $selectedFacilities = old('facilities', $property->facilities->pluck('id')->toArray());
                        @endphp
                        @foreach($facilityCategories as $category)
                            @if($category->facilities->count() > 0)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }} me-2"></i>
                                                @endif
                                                {{ $category->name }}
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-light" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#addAmenityModal"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->name }}"
                                                    title="Add New Amenity">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="card-body" style="max-height: 300px; overflow-y: auto; padding: 1rem;" id="amenities-list-{{ $category->id }}">
                                            @foreach($category->facilities as $amenity)
                                                <div class="d-flex align-items-center mb-2 amenity-item" data-amenity-id="{{ $amenity->id }}">
                                                    <div class="form-check me-3 flex-grow-1">
                                                        <input class="form-check-input" type="checkbox" name="facilities[]" 
                                                               value="{{ $amenity->id }}" id="facility_{{ $amenity->id }}"
                                                               {{ in_array($amenity->id, $selectedFacilities) ? 'checked' : '' }}>
                                                        <label class="form-check-label mb-0" for="facility_{{ $amenity->id }}">
                                                            {{ $amenity->title }}
                                                        </label>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger delete-amenity-btn" 
                                                            data-amenity-id="{{ $amenity->id }}"
                                                            data-amenity-title="{{ $amenity->title }}"
                                                            title="Delete Amenity">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 border-top pt-3">
                                <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i>Update Property
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Content End -->

    @include('admin.includes.footer')

    <!-- Add Amenity Modal -->
    <div class="modal fade" id="addAmenityModal" tabindex="-1" aria-labelledby="addAmenityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAmenityModalLabel">Add New Amenity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addAmenityForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amenity_title" class="form-label">Amenity Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" id="amenity_title" required>
                        </div>
                        <div class="mb-3">
                            <label for="amenity_category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="facility_category_id" class="form-select" id="amenity_category" required>
                                <option value="">Select Category</option>
                                @foreach($facilityCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amenity_icon" class="form-label">Icon Class (Optional)</label>
                            <input type="text" name="icon" class="form-control" id="amenity_icon" placeholder="e.g., fas fa-wifi">
                            <small class="text-muted">Font Awesome icon class</small>
                        </div>
                        <div class="mb-3">
                            <label for="amenity_description" class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" id="amenity_description" rows="2"></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="amenity_is_active" value="1" checked>
                            <label class="form-check-label" for="amenity_is_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-2"></i>Save Amenity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#propertyDescription').summernote({
                placeholder: 'Property Description',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Handle modal open - set category
            $('#addAmenityModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var categoryId = button.data('category-id');
                var categoryName = button.data('category-name');
                
                $('#amenity_category').val(categoryId);
                $('#addAmenityModalLabel').text('Add New Amenity to ' + categoryName);
            });

            // Handle form submission
            $('#addAmenityForm').on('submit', function(e) {
                e.preventDefault();
                
                var form = $(this);
                var submitBtn = form.find('button[type="submit"]');
                var originalText = submitBtn.html();
                
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i>Saving...');
                
                $.ajax({
                    url: '{{ route("amenities.store") }}',
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        console.log('Success response:', response);
                        if (response.success) {
                            // Add new amenity to the appropriate category card
                            var categoryId = response.amenity.facility_category_id;
                            var amenityList = $('#amenities-list-' + categoryId);
                            
                            // Remove "No amenities" message if exists
                            amenityList.find('.text-muted.text-center').remove();
                            
                            // Create new amenity row
                            var newAmenityHtml = '<div class="d-flex align-items-center mb-2 amenity-item" data-amenity-id="' + response.amenity.id + '">' +
                                '<div class="form-check me-3 flex-grow-1">' +
                                    '<input class="form-check-input" type="checkbox" name="facilities[]" value="' + response.amenity.id + '" id="facility_' + response.amenity.id + '" checked>' +
                                    '<label class="form-check-label mb-0" for="facility_' + response.amenity.id + '">' + response.amenity.title + '</label>' +
                                '</div>' +
                                '<button type="button" class="btn btn-sm btn-danger delete-amenity-btn" ' +
                                    'data-amenity-id="' + response.amenity.id + '" ' +
                                    'data-amenity-title="' + response.amenity.title + '" ' +
                                    'title="Delete Amenity">' +
                                    '<i class="fa fa-trash"></i>' +
                                '</button>' +
                            '</div>';
                            
                            amenityList.append(newAmenityHtml);
                            
                            // Close modal and reset form
                            $('#addAmenityModal').modal('hide');
                            form[0].reset();
                            
                            // Show success message
                            alert('Amenity added successfully!');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error response:', xhr);
                        var errors = xhr.responseJSON?.errors || {};
                        var errorMsg = 'Error adding amenity. ';
                        
                        if (xhr.responseJSON?.message) {
                            errorMsg += xhr.responseJSON.message;
                        } else if (Object.keys(errors).length > 0) {
                            errorMsg += Object.values(errors).flat().join(', ');
                        } else if (xhr.status === 0) {
                            errorMsg += 'Network error. Please check your connection.';
                        } else {
                            errorMsg += 'Please try again. Status: ' + xhr.status;
                        }
                        
                        alert(errorMsg);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Handle amenity deletion
            $(document).on('click', '.delete-amenity-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var btn = $(this);
                var amenityId = btn.data('amenity-id');
                var amenityTitle = btn.data('amenity-title');
                var amenityItem = btn.closest('.amenity-item');
                
                console.log('Delete clicked for amenity:', amenityId, amenityTitle);
                
                // Show confirmation dialog
                if (confirm('Are you sure you want to delete "' + amenityTitle + '"?\n\nThis action cannot be undone.')) {
                    // Disable button during deletion
                    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                    
                    $.ajax({
                        url: '{{ route("amenities.destroy", ":id") }}'.replace(':id', amenityId),
                        method: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            console.log('Delete success response:', response);
                            if (response.success) {
                                // Remove the amenity item from the DOM
                                amenityItem.fadeOut(300, function() {
                                    $(this).remove();
                                    
                                    // Check if category is now empty
                                    var categoryCard = amenityItem.closest('.card');
                                    var amenitiesList = categoryCard.find('.card-body');
                                    if (amenitiesList.find('.amenity-item').length === 0) {
                                        amenitiesList.html('<p class="text-muted text-center mb-0">No amenities in this category</p>');
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log('Delete error response:', xhr);
                            btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                            var errorMsg = 'Error deleting amenity. ';
                            
                            if (xhr.responseJSON?.message) {
                                errorMsg += xhr.responseJSON.message;
                            } else if (xhr.status === 0) {
                                errorMsg += 'Network error. Please check your connection.';
                            } else {
                                errorMsg += 'Please try again. Status: ' + xhr.status;
                            }
                            
                            alert(errorMsg);
                        }
                    });
                }
            });
        });
    </script>
@endsection
