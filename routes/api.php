<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginEmployee;

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'Api\LoginController@login')->name('login');
    Route::post('signup', 'Api\LoginController@create');
    
    Route::get('ware-house-type', 'Api\CommanApiController@wareHouseType');
    Route::get('property-type', 'Api\CommanApiController@propertyType');
    Route::get('country', 'Api\CommanApiController@country');
    Route::get('space-type', 'Api\CommanApiController@spaceType');
    Route::get('property-type-option', 'Api\CommanApiController@propertyTypeOption');
    Route::get('property-type-set-option/{propertyType}', 'Api\CommanApiController@propertyTypeSetOption');
    Route::get('floor-type', 'Api\CommanApiController@floorType');
    Route::get('bed-type', 'Api\CommanApiController@bedType');
    Route::get('currency', 'Api\CommanApiController@currency');
    Route::get('currencywithid/{any}', 'Api\CommanApiController@currencywithid');
    Route::get('amenities-type', 'Api\CommanApiController@amenitiesType');
    Route::get('social-links', 'Api\CommanApiController@socialLinks');
    Route::get('language', 'Api\CommanApiController@language');
    Route::get('languagewithid/{any}', 'Api\CommanApiController@languagewithid');
    Route::get('top-destination', 'Api\CommanApiController@Top_Destination');
    Route::get('testimonials', 'Api\CommanApiController@Testimonials');
    Route::post('search', 'Api\CommanApiController@searchResult');
    // recommend property
    Route::get('recommended-property', 'Api\CommanApiController@recommendedProperties');

    Route::get('listing', 'Api\CommanApiController@listing');

    Route::get('propertydetail/{any}', 'Api\CommanApiController@propertyDetail');
    Route::middleware('auth:api')->group( function () {
        Route::get('profileupdate', 'Api\LoginController@profileupdate');
        Route::post('profile-media', 'Api\LoginController@profilemedia');
        
        // security route
        Route::post('security', 'Api\LoginController@security');
        Route::post('create','Api\PropertyController@create');
        Route::post('basics','Api\PropertyController@basics');
        Route::post('description','Api\PropertyController@description');
        Route::post('location','Api\PropertyController@location');
        Route::post('amenities','Api\PropertyController@amenities');
        Route::post('photos','Api\PropertyController@photos');
        Route::post('pricing','Api\PropertyController@pricing');
        Route::post('booking','Api\PropertyController@booking');
        Route::get('calendardatalist/{id}','Api\PropertyController@calendar');

        Route::get('my-list','Api\CommanApiController@myList');
        Route::get('trips','Api\CommanApiController@trips');
        Route::get('my-wallet','Api\CommanApiController@myWallet');
        Route::get('latest-booking','Api\CommanApiController@latestBooking');
        Route::get('latest-transactions','Api\CommanApiController@latestTransactions');
        Route::post('properties','Api\CommanApiController@userProperties');
        
        Route::post('my-bookings', 'Api\CommanApiController@myBookings');
        Route::post('trips/active', 'Api\CommanApiController@myTrips');
        Route::post('user/favourite','Api\CommanApiController@userBookmark');
        Route::post('users/payout-list','Api\CommanApiController@userPayoutList');
        Route::get('users/transaction-history', 'Api\CommanApiController@transactionHistory');
        Route::get('users/job-approval', 'Api\CommanApiController@jobApproval');
        Route::get('users/package-list', 'Api\CommanApiController@packageList');
        Route::match(array('GET', 'POST'),'users/profile', 'Api\CommanApiController@profile');
        Route::match(array('GET', 'POST'),'users/profile/media', 'Api\CommanApiController@media');
        Route::post('users/security', 'Api\CommanApiController@security');
        Route::get('users/reviews', 'Api\CommanApiController@reviews');
        Route::match(array('GET', 'POST'),'users/reviews_by_you', 'Api\CommanApiController@reviewsByYou');

        // Route::post('listing/{id}','Api\PropertyController@listing');
        
    });    
});    


Route::group(['prefix' => 'v1/supervisor'], function () {
    Route::post('login', 'Api\SupervisorLoginController@login');
});

Route::group(['prefix' => 'v1/siteengineer'], function () {
    Route::post('/login', [LoginEmployee::class, 'Login']);
});




