<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/logouts', [App\Http\Controllers\AdminController::class, 'logouts'])->name('logouts');
    
    // Users Management Routes - Only accessible to admins (role == 1)
    Route::get('/Users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/Users/{id}/show', [App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/Users/{id}/verify', [App\Http\Controllers\AdminController::class, 'verifyUserEmail'])->name('admin.users.verify');
    Route::get('/Users/{id}/makeAdmin', [App\Http\Controllers\AdminController::class, 'makeAdmin'])->name('makeAdmin');
    Route::get('/deleteUser/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');
    
    Route::get('/Comments', [App\Http\Controllers\AdminController::class, 'blogsComment'])->name('blogsComment');

 
    Route::post('/Comment/approve/{comment}', [App\Http\Controllers\AdminController::class, 'commentApprove'])->name('commentApprove');
    Route::get('/CommentDelete/{id}', [App\Http\Controllers\AdminController::class, 'destroyBlogComment'])->name('destroyBlogComment');

    Route::get('/Subscribers', [App\Http\Controllers\AdminController::class, 'subscribers'])->name('subscribers');
    Route::get('/Subscribers/{id}', [App\Http\Controllers\AdminController::class, 'destroySub'])->name('destroySub');

    Route::get('/getMessages', [App\Http\Controllers\AdminController::class, 'getMessages'])->name('getMessages');
    Route::get('/deleteMessages/{id}', [App\Http\Controllers\AdminController::class, 'deleteMessages'])->name('deleteMessages');

    // Reviews Management (Admin)
    Route::get('/admin/reviews', [App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/admin/reviews/create', [App\Http\Controllers\Admin\AdminReviewController::class, 'create'])->name('admin.reviews.create');
    Route::post('/admin/reviews', [App\Http\Controllers\Admin\AdminReviewController::class, 'store'])->name('admin.reviews.store');
    Route::get('/admin/reviews/{id}', [App\Http\Controllers\Admin\AdminReviewController::class, 'show'])->name('admin.reviews.show');
    Route::get('/admin/reviews/{id}/edit', [App\Http\Controllers\Admin\AdminReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/admin/reviews/{id}', [App\Http\Controllers\Admin\AdminReviewController::class, 'update'])->name('admin.reviews.update');
    Route::post('/admin/reviews/{id}/approve', [App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('/admin/reviews/{id}/reject', [App\Http\Controllers\Admin\AdminReviewController::class, 'reject'])->name('admin.reviews.reject');
    Route::post('/admin/reviews/{id}/respond', [App\Http\Controllers\Admin\AdminReviewController::class, 'respond'])->name('admin.reviews.respond');
    Route::delete('/admin/reviews/{id}', [App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    Route::delete('/admin/reviews/{reviewId}/images/{imageId}', [App\Http\Controllers\Admin\AdminReviewController::class, 'deleteImage'])->name('admin.reviews.deleteImage');

    
    Route::get('/setting',[App\Http\Controllers\SettingsController::class,'setting'])->name('setting');
    Route::post('/saveSetting',[App\Http\Controllers\SettingsController::class,'saveSetting'])->name('saveSetting');
    
    Route::get('/getLeftBags',[App\Http\Controllers\SettingsController::class,'getLeftBags'])->name('getLeftBags');
    Route::post('/updateBags',[App\Http\Controllers\SettingsController::class,'updateBags'])->name('updateBags');
    
    Route::get('/getTicketing',[App\Http\Controllers\SettingsController::class,'getTicketing'])->name('getTicketing');
    Route::post('/updateTicketing',[App\Http\Controllers\SettingsController::class,'updateTicketing'])->name('updateTicketing');
    
    Route::get('/homePage',[App\Http\Controllers\SettingsController::class,'homePage'])->name('homePage');
    Route::post('/saveHome',[App\Http\Controllers\SettingsController::class,'saveHome'])->name('saveHome');
    
    Route::get('/aboutPage',[App\Http\Controllers\SettingsController::class,'aboutPage'])->name('aboutPage');
    Route::post('/saveAbout',[App\Http\Controllers\SettingsController::class,'saveAbout'])->name('saveAbout');

    Route::get('/eventsPage',[App\Http\Controllers\PagesController::class,'eventsPage'])->name('eventsPage');
    Route::post('/saveEvent',[App\Http\Controllers\PagesController::class,'saveEvent'])->name('saveEvent');    
    Route::post('/addEventImage', [App\Http\Controllers\PagesController::class, 'addEventImage'])->name('addEventImage');
    Route::get('/deleteEventImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteEventImage'])->name('deleteEventImage');

    Route::get('/restoPage',[App\Http\Controllers\PagesController::class,'resto'])->name('resto');
    Route::post('/updateRestaurant',[App\Http\Controllers\PagesController::class,'saveResto'])->name('saveResto');    
    Route::post('/addRestoImage', [App\Http\Controllers\PagesController::class, 'addRestoImage'])->name('addRestoImage');
    Route::get('/deleteRestoImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteRestoImage'])->name('deleteRestoImage');
    

        
    // Categories
    Route::get('/getCategories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('getCategories');
    Route::post('/postCategory', [App\Http\Controllers\CategoriesController::class, 'store'])->name('postCategory');
    Route::get('/editCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('editCategory');
    Route::post('/updateCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('updateCategory');
    Route::get('/deleteCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('deleteCategory');
        
    // Categories
    Route::get('/getDestinations', [App\Http\Controllers\DestinationsController::class, 'index'])->name('getDestinations');
    Route::post('/postDestination', [App\Http\Controllers\DestinationsController::class, 'store'])->name('postDestination');
    Route::get('/editDestination/{id}', [App\Http\Controllers\DestinationsController::class, 'edit'])->name('editDestination');
    Route::post('/updateDestination/{id}', [App\Http\Controllers\DestinationsController::class, 'update'])->name('updateDestination');
    Route::get('/deleteDestination/{id}', [App\Http\Controllers\DestinationsController::class, 'destroy'])->name('deleteDestination');
        
    // BLogs
    Route::get('/getBlogs', [App\Http\Controllers\BlogsController::class, 'index'])->name('getBlogs');
    Route::post('/saveBlog', [App\Http\Controllers\BlogsController::class, 'store'])->name('saveBlog');
    Route::get('/blog/{id}', [App\Http\Controllers\BlogsController::class, 'edit'])->name('editBlog');
    Route::get('/blogView/{id}', [App\Http\Controllers\BlogsController::class, 'view'])->name('viewBlog');
    Route::post('/updateBlog/{id}', [App\Http\Controllers\BlogsController::class, 'update'])->name('updateBlog');
    Route::get('/deleteBlog/{id}', [App\Http\Controllers\BlogsController::class, 'destroy'])->name('deleteBlog');
    Route::get('/Blog/{blog}/publish', [App\Http\Controllers\BlogsController::class, 'publish'])->name('publishBlog');


    // Services
    Route::get('/getServices', [App\Http\Controllers\ServicesController::class, 'index'])->name('getServices');
    Route::post('/storeService', [App\Http\Controllers\ServicesController::class, 'store'])->name('storeService');
    Route::get('/EditService/{id}', [App\Http\Controllers\ServicesController::class, 'edit'])->name('editService');
    Route::post('/UpdateService/{id}', [App\Http\Controllers\ServicesController::class, 'update'])->name('updateService');
    Route::get('/DeleteService/{id}', [App\Http\Controllers\ServicesController::class, 'destroy'])->name('deleteService');

    // Amenities Management
    Route::get('/amenities', [App\Http\Controllers\AmenitiesController::class, 'index'])->name('amenities.index');
    Route::post('/amenities', [App\Http\Controllers\AmenitiesController::class, 'store'])->name('amenities.store');
    Route::get('/amenities/{id}/edit', [App\Http\Controllers\AmenitiesController::class, 'edit'])->name('amenities.edit');
    Route::post('/amenities/{id}', [App\Http\Controllers\AmenitiesController::class, 'update'])->name('amenities.update');
    Route::get('/amenities/{id}/delete', [App\Http\Controllers\AmenitiesController::class, 'destroy'])->name('amenities.destroy');
    
    // Properties Management (Hotels & Apartments)
    Route::get('/admin/properties', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'index'])->name('admin.properties.index');
    Route::get('/admin/properties/create', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'create'])->name('admin.properties.create');
    Route::post('/admin/properties', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'store'])->name('admin.properties.store');
    Route::get('/admin/properties/{id}/edit', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'edit'])->name('admin.properties.edit');
    Route::get('/admin/properties/{id}/delete', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'destroy'])->name('admin.properties.destroy');
    Route::get('/admin/properties/{id}/status/{status}', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'updateStatus'])->name('admin.properties.updateStatus.get'); // GET route for direct status updates (must come before generic {id} route)
    Route::post('/admin/properties/{id}/status', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'updateStatus'])->name('admin.properties.updateStatus'); // POST route for AJAX status updates
    Route::put('/admin/properties/{id}', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'update'])->name('admin.properties.update');
    Route::post('/admin/properties/{id}', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'update'])->name('admin.properties.update.post'); // Fallback for forms without @method
    Route::get('/admin/properties/{id}', [App\Http\Controllers\Admin\AdminPropertiesController::class, 'show'])->name('admin.properties.show'); // Generic show route (must be last)
    
    // Property Images
    Route::post('/admin/properties/{propertyId}/images', [App\Http\Controllers\Admin\PropertyImagesController::class, 'store'])->name('admin.properties.images.store');
    Route::put('/admin/properties/images/{id}', [App\Http\Controllers\Admin\PropertyImagesController::class, 'update'])->name('admin.properties.images.update');
    Route::get('/admin/properties/images/{id}/delete', [App\Http\Controllers\Admin\PropertyImagesController::class, 'destroy'])->name('admin.properties.images.destroy');
    Route::get('/admin/properties/images/{id}/primary', [App\Http\Controllers\Admin\PropertyImagesController::class, 'setPrimary'])->name('admin.properties.images.primary');
    
    // Units Management
    Route::get('/admin/units', [App\Http\Controllers\Admin\AdminUnitsController::class, 'index'])->name('admin.units.index');
    Route::get('/admin/units/create', [App\Http\Controllers\Admin\AdminUnitsController::class, 'create'])->name('admin.units.create');
    Route::post('/admin/units', [App\Http\Controllers\Admin\AdminUnitsController::class, 'store'])->name('admin.units.store');
    Route::get('/admin/units/{id}/edit', [App\Http\Controllers\Admin\AdminUnitsController::class, 'edit'])->name('admin.units.edit');
    Route::get('/admin/units/{id}/delete', [App\Http\Controllers\Admin\AdminUnitsController::class, 'destroy'])->name('admin.units.destroy');
    Route::post('/admin/units/{id}', [App\Http\Controllers\Admin\AdminUnitsController::class, 'update'])->name('admin.units.update');
    
    // Unit Images
    Route::post('/admin/units/{unitId}/images', [App\Http\Controllers\Admin\UnitImagesController::class, 'store'])->name('admin.units.images.store');
    Route::put('/admin/units/images/{id}', [App\Http\Controllers\Admin\UnitImagesController::class, 'update'])->name('admin.units.images.update');
    Route::get('/admin/units/images/{id}/delete', [App\Http\Controllers\Admin\UnitImagesController::class, 'destroy'])->name('admin.units.images.destroy');
    Route::get('/admin/units/images/{id}/primary', [App\Http\Controllers\Admin\UnitImagesController::class, 'setPrimary'])->name('admin.units.images.primary');
    
    // Unit Pricing
    Route::post('/admin/units/{unitId}/pricing', [App\Http\Controllers\Admin\UnitPricingController::class, 'store'])->name('admin.units.pricing.store');
    Route::post('/admin/units/pricing/{id}', [App\Http\Controllers\Admin\UnitPricingController::class, 'update'])->name('admin.units.pricing.update');
    Route::get('/admin/units/pricing/{id}/delete', [App\Http\Controllers\Admin\UnitPricingController::class, 'destroy'])->name('admin.units.pricing.destroy');
    
    // Unit Availability
    Route::post('/admin/units/{unitId}/availability', [App\Http\Controllers\Admin\UnitAvailabilityController::class, 'store'])->name('admin.units.availability.store');
    Route::post('/admin/units/{unitId}/availability/bulk', [App\Http\Controllers\Admin\UnitAvailabilityController::class, 'bulkUpdate'])->name('admin.units.availability.bulk');
    Route::get('/admin/units/availability/{id}/delete', [App\Http\Controllers\Admin\UnitAvailabilityController::class, 'destroy'])->name('admin.units.availability.destroy');
    
    // Bookings Management
    Route::get('/admin/bookings', [App\Http\Controllers\Admin\AdminBookingsController::class, 'index'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{id}', [App\Http\Controllers\Admin\AdminBookingsController::class, 'show'])->name('admin.bookings.show');
    Route::post('/admin/bookings/{id}/status', [App\Http\Controllers\Admin\AdminBookingsController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
    Route::get('/admin/bookings/{id}/delete', [App\Http\Controllers\Admin\AdminBookingsController::class, 'destroy'])->name('admin.bookings.destroy');

    // Facilities
    Route::get('/getFacilities', [App\Http\Controllers\FacilitiesController::class, 'index'])->name('getFacilities');
    Route::post('/storeFacility', [App\Http\Controllers\FacilitiesController::class, 'store'])->name('storeFacility');
    Route::get('/editFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'edit'])->name('editFacility');
    Route::post('/updateFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'update'])->name('updateFacility');
    Route::get('/deleteFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'destroy'])->name('deleteFacility');

    Route::post('/addFacilityImage', [App\Http\Controllers\FacilitiesController::class, 'addFacilityImage'])->name('addFacilityImage');
    Route::get('/deleteFacilityImage/{id}', [App\Http\Controllers\FacilitiesController::class, 'deleteFacilityImage'])->name('deleteFacilityImage');

    // Trips
    Route::get('/getTrips', [App\Http\Controllers\TripsController::class, 'index'])->name('getTrips');
    Route::post('/storeTrip', [App\Http\Controllers\TripsController::class, 'store'])->name('storeTrip');
    Route::get('/editTrip/{id}', [App\Http\Controllers\TripsController::class, 'edit'])->name('editTrip');
    Route::post('/updateTrip/{id}', [App\Http\Controllers\TripsController::class, 'update'])->name('updateTrip');
    Route::get('/deleteTrip/{id}', [App\Http\Controllers\TripsController::class, 'destroy'])->name('deleteTrip');

    Route::post('/addTripImage', [App\Http\Controllers\TripsController::class, 'addTripImage'])->name('addTripImage');
    Route::get('/deleteTripImage/{id}', [App\Http\Controllers\TripsController::class, 'deleteTripImage'])->name('deleteTripImage');

    // Trip Destinations
    Route::get('/getTripDestinations', [App\Http\Controllers\TripDestinationController::class, 'index'])->name('getTripDestinations');
    Route::post('/storeTripDestination', [App\Http\Controllers\TripDestinationController::class, 'store'])->name('storeTripDestination');
    Route::get('/editTripDestination/{id}', [App\Http\Controllers\TripDestinationController::class, 'edit'])->name('editTripDestination');
    Route::post('/updateTripDestination/{id}', [App\Http\Controllers\TripDestinationController::class, 'update'])->name('updateTripDestination');
    Route::get('/deleteTripDestination/{id}', [App\Http\Controllers\TripDestinationController::class, 'destroy'])->name('deleteTripDestination');
    Route::post('/addTripDestinationImage', [App\Http\Controllers\TripDestinationController::class, 'addDestinationImage'])->name('addTripDestinationImage');
    Route::get('/deleteTripDestinationImage/{id}', [App\Http\Controllers\TripDestinationController::class, 'deleteDestinationImage'])->name('deleteTripDestinationImage');

    // Tours
    Route::get('/getTours', [App\Http\Controllers\ToursController::class, 'index'])->name('getTours');
    Route::post('/storeTour', [App\Http\Controllers\ToursController::class, 'store'])->name('storeTour');
    Route::get('/editTour/{id}', [App\Http\Controllers\ToursController::class, 'edit'])->name('editTour');
    Route::post('/updateTour/{id}', [App\Http\Controllers\ToursController::class, 'update'])->name('updateTour');
    Route::get('/deleteTour/{id}', [App\Http\Controllers\ToursController::class, 'destroy'])->name('deleteTour');
    Route::post('/addTourImage', [App\Http\Controllers\ToursController::class, 'addTourImage'])->name('addTourImage');
    Route::get('/deleteTourImage/{id}', [App\Http\Controllers\ToursController::class, 'deleteTourImage'])->name('deleteTourImage');

    // Promotions
    Route::get('/getCars', [App\Http\Controllers\CarsController::class, 'index'])->name('getCars');
    Route::post('/storeCar', [App\Http\Controllers\CarsController::class, 'store'])->name('storeCar');
    Route::get('/editCar/{id}', [App\Http\Controllers\CarsController::class, 'edit'])->name('editCar');
    Route::post('/updateCar/{id}', [App\Http\Controllers\CarsController::class, 'update'])->name('updateCar');
    
    Route::get('/deleteCar/{id}', [App\Http\Controllers\CarsController::class, 'destroy'])->name('deleteCar');
    Route::post('/addCarImage/{id}', [App\Http\Controllers\CarsController::class, 'addCarImage'])->name('addCarImage');
    Route::get('/deleteCarImage/{id}', [App\Http\Controllers\CarsController::class, 'deleteCarImage'])->name('deleteCarImage');
    Route::get('/car-bookings', [App\Http\Controllers\CarsController::class, 'carBookings'])->name('admin.carBookings.index');
    Route::put('/car-bookings/{id}/status', [App\Http\Controllers\CarsController::class, 'updateBookingStatus'])->name('admin.carBookings.updateStatus');

    // Left Bagsß
    Route::get('/getBags', [App\Http\Controllers\BagsController::class, 'index'])->name('getBags');
    Route::post('/storeBag', [App\Http\Controllers\BagsController::class, 'store'])->name('storeBag');
    Route::get('/editBag/{id}', [App\Http\Controllers\BagsController::class, 'edit'])->name('editBag');
    Route::post('/updateBag/{id}', [App\Http\Controllers\BagsController::class, 'update'])->name('updateBag');
    Route::get('/deleteBag/{id}', [App\Http\Controllers\BagsController::class, 'destroy'])->name('deleteBag');



    // Gallery
    Route::get('/slides', [App\Http\Controllers\SlidesController::class, 'index'])->name('slides');
    Route::post('/saveSlide', [App\Http\Controllers\SlidesController::class, 'store'])->name('saveSlide');
    Route::get('/editSlide/{id}', [App\Http\Controllers\SlidesController::class, 'edit'])->name('editSlide');
    Route::post('/updateSlide/{id}', [App\Http\Controllers\SlidesController::class, 'update'])->name('updateSlide');
    Route::get('/destroySlide/{id}', [App\Http\Controllers\SlidesController::class, 'destroy'])->name('destroySlide');

    // Images
    Route::get('/images', [App\Http\Controllers\ImagesController::class, 'index'])->name('images');
    Route::post('/saveImage', [App\Http\Controllers\ImagesController::class, 'store'])->name('saveImage');
    Route::get('/editImage/{id}', [App\Http\Controllers\ImagesController::class, 'edit'])->name('editImage');
    Route::post('/updateImage/{id}', [App\Http\Controllers\ImagesController::class, 'update'])->name('updateImage');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\ImagesController::class, 'destroy'])->name('destroyImage');
    // Gallery
    Route::get('/getPartners', [App\Http\Controllers\PartnersController::class, 'index'])->name('getPartners');
    Route::post('/savePartner', [App\Http\Controllers\PartnersController::class, 'store'])->name('savePartner');
    Route::get('/editPartner/{id}', [App\Http\Controllers\PartnersController::class, 'edit'])->name('editPartner');
    Route::post('/updatePartner/{id}', [App\Http\Controllers\PartnersController::class, 'update'])->name('updatePartner');
    Route::get('/destroyPartner/{id}', [App\Http\Controllers\PartnersController::class, 'destroy'])->name('destroyPartner');

    // Gallery
    Route::get('/getImages', [App\Http\Controllers\SlidesController::class, 'getImages'])->name('getImages');
    Route::post('/saveGallery', [App\Http\Controllers\SlidesController::class, 'saveImage'])->name('saveGallery');
    Route::get('/editGallery/{id}', [App\Http\Controllers\SlidesController::class, 'editGallery'])->name('editGallery');
    Route::post('/updateGallery/{id}', [App\Http\Controllers\SlidesController::class, 'updateGallery'])->name('updateGallery');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\SlidesController::class, 'destroyImage'])->name('destroyImage');
    

});

// Frontend routes - admins will be redirected to dashboard via middleware
Route::middleware(['redirect.admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/about-us', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
    Route::get('/our-services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
    Route::get('/our-services/{slug}', [App\Http\Controllers\HomeController::class, 'service'])->name('service');
    Route::get('/destinations', [App\Http\Controllers\HomeController::class, 'destinations'])->name('destinations');
    Route::get('/destination/{slug}', [App\Http\Controllers\HomeController::class, 'destination'])->name('destination');
    Route::get('/accommodations', [App\Http\Controllers\HomeController::class, 'accommodations'])->name('accommodations');
    Route::get('/accommodations/hotelsSearch', [App\Http\Controllers\HomeController::class, 'hotelsSearch'])->name('hotelsSearch');
    Route::get('/accommodations/hotels', [App\Http\Controllers\HomeController::class, 'hotels'])->name('hotels');
    Route::get('/accommodations/{slug}', [App\Http\Controllers\HomeController::class, 'showAccommodation'])->name('hotel');
    Route::post('/bookings', [App\Http\Controllers\HomeController::class, 'storeBooking'])->name('bookings.store')->middleware('auth');
    Route::get('our-apartments', [App\Http\Controllers\HomeController::class, 'apartments'])->name('apartments');
    Route::get('/services/ticketing', [App\Http\Controllers\HomeController::class, 'ticketing'])->name('ticketing');
    Route::get('/services/ticketing/request', [App\Http\Controllers\HomeController::class, 'ticketingRequest'])->name('ticketing.request');
    Route::get('/services/left-bags', [App\Http\Controllers\HomeController::class, 'leftBags'])->name('leftBags');
    Route::get('/services/left-bags/request', [App\Http\Controllers\HomeController::class, 'leftBagsRequest'])->name('leftBags.request');
    Route::get('transport', [App\Http\Controllers\HomeController::class, 'showCars'])->name('showCars');
    Route::get('transport/{slug}', [App\Http\Controllers\HomeController::class, 'carDetails'])->name('carDetails');
    Route::post('car-booking', [App\Http\Controllers\HomeController::class, 'storeCarBooking'])->name('storeCarBooking');
    Route::get('/hotels/{slug}/rooms', [App\Http\Controllers\HomeController::class, 'hotelRooms'])->name('hotelRooms');
    Route::get('/hotels/{hotel}/rooms/{room}', [App\Http\Controllers\HomeController::class, 'roomDetails'])->name('roomDetails');
});



Route::middleware(['auth', 'redirect.admin'])->group(function () {
    // Properties listing & creation - only for regular users (admins redirected)
    Route::get('/my-properties', [App\Http\Controllers\UserPropertyController::class, 'index'])->name('myProperties');
    Route::get('/my-properties/hotels/create', [App\Http\Controllers\UserPropertyController::class, 'myPropertyCreate'])->name('myPropertyCreate');
    Route::post('/my-properties/hotels', [App\Http\Controllers\UserPropertyController::class, 'storeHotel'])->name('storeHotel');
    Route::delete('/my-properties/hotels/{hotel}', [App\Http\Controllers\UserPropertyController::class, 'destroyHotel'])->name('my.properties.hotels.destroy');

    // Hotel owner page, edit
    Route::get('/my-properties/hotels/{hotel}', [App\Http\Controllers\UserPropertyController::class, 'showHotel'])->name('my.properties.hotels.show');
    Route::get('/my-properties/hotels/{hotel}/edit', [App\Http\Controllers\UserPropertyController::class, 'editHotel'])->name('my.properties.hotels.edit');
    Route::put('/my-properties/hotels/{hotel}', [App\Http\Controllers\UserPropertyController::class, 'updateHotel'])->name('my.properties.hotels.update');

    // Rooms
    Route::get('/my-properties/hotels/{hotel}/rooms/create', [App\Http\Controllers\UserPropertyController::class, 'createRoom'])->name('my.properties.rooms.create');
    Route::post('/my-properties/hotels/{hotel}/rooms', [App\Http\Controllers\UserPropertyController::class, 'storeRoom'])->name('my.properties.rooms.store');
    Route::get('/my-properties/rooms/{room}/edit', [App\Http\Controllers\UserPropertyController::class, 'editRoom'])->name('my.properties.rooms.edit');
    Route::put('/my-properties/rooms/{room}', [App\Http\Controllers\UserPropertyController::class, 'updateRoom'])->name('my.properties.rooms.update');
    Route::delete('/my-properties/rooms/{room}', [App\Http\Controllers\UserPropertyController::class, 'destroyRoom'])->name('my.properties.rooms.destroy');
});


// Route::get('/my-properties', [App\Http\Controllers\HomeController::class, 'myProperties'])->name('myProperties');
Route::get('/our-rooms/all', [App\Http\Controllers\HomeController::class, 'room'])->name('room');
Route::get('/events', [App\Http\Controllers\HomeController::class, 'events'])->name('events');
Route::get('/tours', [App\Http\Controllers\HomeController::class, 'tours'])->name('tours');
Route::get('/trip-destination/{slug}', [App\Http\Controllers\HomeController::class, 'tripDestination'])->name('tripDestination');
Route::get('/tour/{slug}', [App\Http\Controllers\HomeController::class, 'tour'])->name('tour');
Route::get('/gallery', [App\Http\Controllers\HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/promotions', [App\Http\Controllers\HomeController::class, 'promotions'])->name('promotions');
Route::get('/promotions/{slug}', [App\Http\Controllers\HomeController::class, 'promotion'])->name('promotion');
Route::get('/facilities', [App\Http\Controllers\HomeController::class, 'facilities'])->name('facilities');
Route::get('/facilities/{slug}', [App\Http\Controllers\HomeController::class, 'facility'])->name('facility');
Route::get('/articles', [App\Http\Controllers\HomeController::class, 'blogs'])->name('blogs');
Route::get('/articles/{slug}', [App\Http\Controllers\HomeController::class, 'singleBlog'])->name('singleBlog');
Route::get('/terms-and-conditions', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');


Route::middleware(['redirect.admin'])->group(function () {
    Route::get('/connect', [App\Http\Controllers\HomeController::class, 'connect'])->name('connect');
    Route::post('/subscribe', [App\Http\Controllers\HomeController::class, 'subscribe'])->name('subscribe');
    Route::post('/sendMessage', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('sendMessage');
    Route::post('/sendComment', [App\Http\Controllers\HomeController::class, 'sendComment'])->name('sendComment');
    Route::post('/book-now', [App\Http\Controllers\HomeController::class, 'bookNow'])->name('bookNow');
    Route::post('/testimony', [App\Http\Controllers\HomeController::class, 'testimony'])->name('testimony');
    Route::post('/trip-inquiry', [App\Http\Controllers\HomeController::class, 'tripInquiry'])->name('tripInquiry');
});

// Public Review Routes
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{id}', [App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');
Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware(['auth', 'verified']);

// Logout route - accessible to all authenticated users
Route::get('/logouts', [App\Http\Controllers\HomeController::class, 'logouts'])->name('logouts');

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

