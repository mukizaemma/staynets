<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/logouts', [App\Http\Controllers\AdminController::class, 'logouts'])->name('logouts');
    Route::get('/Users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/Users/{id}', [App\Http\Controllers\AdminController::class, 'makeAdmin'])->name('makeAdmin');
    Route::get('/deleteUser/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');

 
    Route::get('/Comments', [App\Http\Controllers\AdminController::class, 'blogsComment'])->name('blogsComment');
    Route::post('/Comment/approve/{comment}', [App\Http\Controllers\AdminController::class, 'commentApprove'])->name('commentApprove');
    Route::get('/CommentDelete/{id}', [App\Http\Controllers\AdminController::class, 'destroyBlogComment'])->name('destroyBlogComment');

    Route::get('/Subscribers', [App\Http\Controllers\AdminController::class, 'subscribers'])->name('subscribers');
    Route::get('/Subscribers/{id}', [App\Http\Controllers\AdminController::class, 'destroySub'])->name('destroySub');

    Route::get('/getMessages', [App\Http\Controllers\AdminController::class, 'getMessages'])->name('getMessages');
    Route::get('/deleteMessages/{id}', [App\Http\Controllers\AdminController::class, 'deleteMessages'])->name('deleteMessages');

    
    Route::get('/setting',[App\Http\Controllers\SettingsController::class,'setting'])->name('setting');
    Route::post('/saveSetting',[App\Http\Controllers\SettingsController::class,'saveSetting'])->name('saveSetting');
    
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

        // Hotels
    Route::get('/getHotels', [App\Http\Controllers\HotelsController::class, 'index'])->name('getHotels');
    Route::post('/saveHotel', [App\Http\Controllers\HotelsController::class, 'store'])->name('saveHotel');
    Route::get('/editHotel/{id}', [App\Http\Controllers\HotelsController::class, 'edit'])->name('editHotel');
    Route::post('/updateHotel/{id}', [App\Http\Controllers\HotelsController::class, 'update'])->name('updateHotel');
    Route::get('/destroyHotel/{id}', [App\Http\Controllers\HotelsController::class, 'destroy'])->name('destroyHotel');

    // Rooms
    Route::get('/getRooms', [App\Http\Controllers\RoomsController::class, 'index'])->name('getRooms');
    Route::post('/storeRoom', [App\Http\Controllers\RoomsController::class, 'store'])->name('storeRoom');
    Route::get('/editRoom/{id}', [App\Http\Controllers\RoomsController::class, 'edit'])->name('editRoom');
    Route::post('/updateRoom/{id}', [App\Http\Controllers\RoomsController::class, 'update'])->name('updateRoom');
    Route::get('/deleteRoom/{id}', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('deleteRoom');

    Route::post('/addRoomImage', [App\Http\Controllers\RoomsController::class, 'addRoomImage'])->name('addRoomImage');
    Route::get('/deleteRoomImage/{id}', [App\Http\Controllers\RoomsController::class, 'deleteRoomImage'])->name('deleteRoomImage');

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/our-services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/our-services/{slug}', [App\Http\Controllers\HomeController::class, 'service'])->name('service');
Route::get('/destinations', [App\Http\Controllers\HomeController::class, 'destinations'])->name('destinations');
Route::get('/destination/{slug}', [App\Http\Controllers\HomeController::class, 'destination'])->name('destination');
Route::get('/accommodations', [App\Http\Controllers\HomeController::class, 'accommodations'])->name('accommodations');
Route::get('/accommodations/hotels', [App\Http\Controllers\HomeController::class, 'hotels'])->name('hotels');
Route::get('/accommodations/{slug}', [App\Http\Controllers\HomeController::class, 'showAccommodation'])->name('hotel');
Route::get('/accommodations/apartments', [App\Http\Controllers\HomeController::class, 'apartments'])->name('apartments');

Route::get('/hotels/{slug}/rooms', [App\Http\Controllers\HomeController::class, 'hotelRooms'])->name('hotelRooms');
Route::get('/hotels/{hotel}/rooms/{room}', [App\Http\Controllers\HomeController::class, 'roomDetails'])->name('roomDetails');



Route::middleware(['auth'])->group(function () {
    // Properties listing & creation
    Route::get('/my-properties', [App\Http\Controllers\UserPropertyController::class, 'index'])->name('myProperties');
    Route::get('/my-properties/hotels/create', [App\Http\Controllers\UserPropertyController::class, 'myPropertyCreate'])->name('myPropertyCreate');
    Route::post('/my-properties/hotels', [App\Http\Controllers\UserPropertyController::class, 'storeHotel'])->name('storeHotel');

    // Hotel owner page, edit
    Route::get('/my-properties/hotels/{hotel}', [App\Http\Controllers\UserPropertyController::class, 'showHotel'])->name('my.properties.hotels.show');
    Route::get('/my-properties/hotels/{hotel}/edit', [App\Http\Controllers\UserPropertyController::class, 'editHotel'])->name('my.properties.hotels.edit');
    Route::put('/my-properties/hotels/{hotel}', [App\Http\Controllers\UserPropertyController::class, 'updateHotel'])->name('my.properties.hotels.update');

    // Rooms
    Route::get('/my-properties/hotels/{hotel}/rooms/create', [App\Http\Controllers\UserPropertyController::class, 'createRoom'])->name('my.properties.rooms.create');
    Route::post('/my-properties/hotels/{hotel}/rooms', [App\Http\Controllers\UserPropertyController::class, 'storeRoom'])->name('my.properties.rooms.store');
    Route::get('/my-properties/rooms/{room}/edit', [App\Http\Controllers\UserPropertyController::class, 'editRoom'])->name('my.properties.rooms.edit');
    Route::put('/my-properties/rooms/{room}', [App\Http\Controllers\UserPropertyController::class, 'updateRoom'])->name('my.properties.rooms.update');
});


// Route::get('/my-properties', [App\Http\Controllers\HomeController::class, 'myProperties'])->name('myProperties');
Route::get('/our-rooms/all', [App\Http\Controllers\HomeController::class, 'room'])->name('room');
Route::get('/events', [App\Http\Controllers\HomeController::class, 'events'])->name('events');
Route::get('/tours', [App\Http\Controllers\HomeController::class, 'tours'])->name('tours');
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

Route::get('/connect', [App\Http\Controllers\HomeController::class, 'connect'])->name('connect');

Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::post('/subscribe', [App\Http\Controllers\HomeController::class, 'subscribe'])->name('subscribe');

Route::post('/sendMessage', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('sendMessage');
Route::post('/sendComment', [App\Http\Controllers\HomeController::class, 'sendComment'])->name('sendComment');
Route::post('/book-now', [App\Http\Controllers\HomeController::class, 'bookNow'])->name('bookNow');
Route::post('/testimony', [App\Http\Controllers\HomeController::class, 'testimony'])->name('testimony');

