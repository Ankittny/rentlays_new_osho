<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// payment request 
Route::get('pms-payment-request/{pmsid?}/{id?}', 'App\Http\Controllers\Admin\PmsJobController@pms_payment_request')->name('pms-payment-request');
Route::get('pms-payment-approve/{pmsid}/{id?}', 'App\Http\Controllers\Admin\PmsJobController@approve_pms_payment')->name('pms-payment-approve');
Route::post('amount-pay', 'App\Http\Controllers\Admin\PmsJobController@amount_pay')->name('amount-pay');
// end payment request
Route::get('admin/view-agreement/{id}', 'App\Http\Controllers\PropertyController@view_agreement')->name('admin-view-agreement');
Route::post('admin/update-agreement-status/{id}', 'App\Http\Controllers\PropertyController@updateAgreementStatus')->name('update-agreement-status');

Route::get('enable-debugger', 'HomeController@activateDebugger');

Route::match(array('GET', 'POST'),'create-users-wallet', 'HomeController@walletUser');



//cron job
Route::get('cron', 'CronController@index');
Route::get('import', 'CronController@importDump');
Route::get('cron/ical-synchronization','CronController@iCalendarSynchronization');

//user can view it anytime with or without logged in
Route::group(['middleware' => ['locale']], function () {
	Route::get('/', 'HomeController@index');
	Route::post('search/result', 'SearchController@searchResult');
	Route::match(array('GET', 'POST'),'search', 'SearchController@index');
	Route::match(array('GET', 'POST'),'properties/{slug}', 'PropertyController@single')->name('property.single');
	Route::match(array('GET', 'POST'),'property/get-price', 'PropertyController@getPrice');
	Route::get('set-slug/', 'PropertyController@set_slug');
	Route::get('signup', 'LoginController@signup');
	Route::get('unauthentication-favourite/{id}', 'PropertyController@unauthenticationFavourite');
	Route::post('/checkUser/check', 'LoginController@check')->name('checkUser.check');
});


Route::post('set_session', 'HomeController@setSession');

//only can view if admin is logged in
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['guest:admin']], function(){
	Route::get('/', function(){
        return Redirect::to('admin/dashboard');
	});

    Route::get('cache-clear', 'AdminController@cacheClear');
    Route::get('addons',[AddonController::class,'index'])->name('addon.index');
	Route::match(['GET', 'POST'], 'settings/sms', 'SettingsController@smsSettings');

    Route::match(array('GET', 'POST'), 'profile', 'AdminController@profile');
    Route::get('logout', 'AdminController@logout');
	Route::get('dashboard', 'DashboardController@index');
	Route::get('customers', 'CustomerController@index')->middleware(['permission:customers']);
	Route::get('customers/customer_search', 'CustomerController@searchCustomer')->middleware(['permission:customers']);
    Route::post('add-ajax-customer', 'CustomerController@ajaxCustomerAdd')->middleware(['permission:add_customer']);
	Route::match(array('GET', 'POST'), 'add-customer', 'CustomerController@add')->middleware(['permission:add_customer']);
    Route::get('delete-customer/{id}', 'CustomerController@delete')->middleware(['permission:delete_customer']);
	Route::get('package-list', 'AdminController@package_list');
	

	Route::group(['middleware' => 'permission:edit_customer'], function () {
		Route::match(array('GET', 'POST'), 'edit-customer/{id}', 'CustomerController@update');
		Route::get('customer/properties/{id}', 'CustomerController@customerProperties');
		Route::get('customer/bookings/{id}', 'CustomerController@customerBookings');
		Route::post('customer/bookings/property_search', 'BookingsController@searchProperty');
		Route::get('customer/payouts/{id}', 'CustomerController@customerPayouts');
		Route::get('customer/payment-methods/{id}', 'CustomerController@paymentMethods');
		Route::get('customer/wallet/{id}', 'CustomerController@customerWallet');

		Route::post('currency-symbol', 'PropertiesController@currencySymbol');
		Route::get('customer/properties/{id}/property_list_csv', 'PropertiesController@propertyCsv');
		Route::get('customer/properties/{id}/property_list_pdf', 'PropertiesController@propertyPdf');

		Route::get('customer/bookings/{id}/booking_list_csv', 'BookingsController@bookingCsv');
		Route::get('customer/bookings/{id}/booking_list_pdf', 'BookingsController@bookingPdf');

		Route::get('customer/payouts/{id}/payouts_list_pdf', 'PayoutsController@payoutsPdf');
		Route::get('customer/payouts/{id}/payouts_list_csv', 'PayoutsController@payoutsCsv');

		Route::get('customer/customer_list_csv', 'CustomerController@customerCsv');
		Route::get('customer/customer_list_pdf', 'CustomerController@customerPdf');
	});

	Route::group(['middleware' => 'permission:manage_messages'], function () {
		Route::get('messages', 'AdminController@customerMessage');
		Route::match(array('GET', 'POST'), 'delete-message/{id}', 'AdminController@deleteMessage');
		Route::match(array('GET','POST'), 'send-message-email/{id}', 'AdminController@sendEmail');
		Route::match(['get', 'post'],'upload_image','AdminController@uploadImage')->name('upload');
		Route::get('messaging/host/{id}', 'AdminController@hostMessage');
        Route::post('reply/{id}', 'AdminController@reply');
    });

	Route::group(['middleware' => 'permission:pms_master'], function () { 
		Route::get('brand-master', 'PmsMasterController@brandIndex');
		Route::match(array('GET', 'POST'), 'add-brand-master', 'PmsMasterController@brandAdd');
		Route::match(array('GET', 'POST'), 'edit-brand-master/{id}', 'PmsMasterController@brandUpdate');
		Route::get('delete-brand-master/{id}', 'PmsMasterController@brandDelete');
	
	
	
	
		Route::get('category-master', 'PmsMasterController@categoryIndex');
		Route::match(array('GET', 'POST'), 'add-category-master', 'PmsMasterController@categoryAdd');
		Route::match(array('GET', 'POST'), 'edit-category-master/{id}', 'PmsMasterController@categoryUpdate');
		Route::get('delete-category-master/{id}', 'PmsMasterController@categoryDelete');
	


		Route::get('sub-category-master', 'PmsMasterController@subCategoryIndex');
		Route::match(array('GET', 'POST'), 'add-sub-category-master', 'PmsMasterController@subCategoryAdd');
		Route::match(array('GET', 'POST'), 'edit-sub-category-master/{id}', 'PmsMasterController@subCategoryUpdate');
		Route::get('delete-sub-category-master/{id}', 'PmsMasterController@subCategoryDelete');
	


		Route::get('department-master', 'PmsMasterController@departmentIndex');
		Route::match(array('GET', 'POST'), 'add-department-master', 'PmsMasterController@departmentAdd');
		Route::match(array('GET', 'POST'), 'edit-department-master/{id}', 'PmsMasterController@departmentUpdate');
		Route::get('delete-department-master/{id}', 'PmsMasterController@departmentDelete');
	

		Route::get('service-master', 'PmsMasterController@serviceIndex');
		Route::match(array('GET', 'POST'), 'add-service-master', 'PmsMasterController@serviceAdd');
		Route::match(array('GET', 'POST'), 'edit-service-master/{id}', 'PmsMasterController@serviceUpdate');
		Route::get('delete-service-master/{id}', 'PmsMasterController@serviceDelete');
	


		Route::get('recurring-service-master', 'PmsMasterController@recurringServiceIndex');
		Route::match(array('GET', 'POST'), 'add-recurring-service-master', 'PmsMasterController@recurringServiceAdd');
		Route::match(array('GET', 'POST'), 'edit-recurring-service-master/{id}', 'PmsMasterController@recurringServiceUpdate');
		Route::get('delete-recurring-service-master/{id}', 'PmsMasterController@recurringServiceDelete');
	


		Route::get('recurring-packages-master', 'PmsMasterController@recurringPackagesIndex');
        Route::match(array('GET', 'POST'), 'add-recurring-package-master', 'PmsMasterController@recurringPackageAdd');
		Route::match(array('GET', 'POST'), 'edit-recurring-package-master/{id}', 'PmsMasterController@recurringPackageUpdate');
		Route::get('delete-recurring-package-master/{id}', 'PmsMasterController@recurringPackageDelete');
	

		Route::get('vendor-master', 'PmsMasterController@vendorMasterIndex');
        Route::match(array('GET', 'POST'), 'add-vendor-master', 'PmsMasterController@VendorMasterAdd');
		Route::match(array('GET', 'POST'), 'edit-vendor-master/{id}', 'PmsMasterController@vendorMasterUpdate');
		Route::get('delete-vendor-master/{id}', 'PmsMasterController@vendorMasterDelete');
	
	});

	Route::group(['middleware' => 'permission:service_request'], function () {
		Route::get('service_request', 'ServiceRequestController@service_request_index');
		Route::match(array('GET', 'POST'), 'add-service-request', 'ServiceRequestController@service_request_add');
		Route::match(array('GET', 'POST'), 'edit-service-request/{id}', 'ServiceRequestController@service_request_update');
		Route::get('delete-service-request/{id}', 'ServiceRequestController@service_request_delete');
		Route::get('service-request-view/{id}', 'ServiceRequestController@service_request_view');
		Route::get('getsitemanager/{id}', 'ServiceRequestController@getSiteManager');
		Route::get('getsitemanagerservice/{id}', 'ServiceRequestController@getsitemanagerservice');
		Route::get('site_manager_department/{id}', 'ServiceRequestController@sitemanagerdepartment');
	});

	Route::group(['middleware' => 'permission:pms_inventory'], function () {
		Route::get('pms_inventory', 'PmsInventoryController@pms_inventory_index');
		Route::match(array('GET', 'POST'), 'add-pms-inventory', 'PmsInventoryController@pms_inventory_add');
		Route::match(array('GET', 'POST'), 'edit-pms-inventory/{id}', 'PmsInventoryController@pms_inventory_update');
		Route::get('delete-pms-inventory/{id}', 'PmsInventoryController@pms_inventory_delete');
		Route::get('subcategory-data', 'PmsInventoryController@getSubCategory');
	});

	Route::group(['middleware' => 'permission:pms_job'], function () {
		Route::get('pms_job', 'PmsJobController@pms_job_index');
		Route::get('pms-inventory-getPrice', 'PmsJobController@pms_inventory_getPrice');
		Route::get("pms-inventory-job-item/{pms_job_id}/{service_id}/{addon_id}/{package_id}", "PmsJobController@getpmsjobitem");
		Route::match(array('GET', 'POST'), 'add-pms-job', 'PmsJobController@pms_job_add');
		Route::match(array('GET', 'POST'), 'edit-pms-job/{id}', 'PmsJobController@pms_job_update');
		Route::get('delete-pms-job/{id}', 'PmsJobController@pms_job_delete');
		Route::post('update-service-selection', 'PmsJobController@update_service_selection')->name('updateServiceSelection');
		Route::post('update-inventory-selection', 'PmsJobController@update_inventory_selection')->name('updateInventory');
		Route::get('pms-inventory-job-item-delete/{id}', 'PmsJobController@delete_inventory_data')->name('pms-inventory-job-item-delete');
		Route::get('pms-job-view', 'PmsJobController@pmsjobview');

	});
	Route::group(['middleware' => 'permission:pms_appoint_managers'], function () {
		Route::get('appoint-managers', 'AppointManagerController@pms_appoint_view');
		Route::match(array('GET', 'POST'), 'add-appoint-managers', 'AppointManagerController@pms_appoint_add');
		Route::match(array('GET', 'POST'), 'edit-appoint-managers/{id}', 'AppointManagerController@pms_appoint_update');
		Route::get('delete-appoint-managers/{id}', 'AppointManagerController@pms_appoint_delete');
	});
	Route::get('pms-new-request', 'PmsJobController@pms_new_request');
	Route::get('view-pms-request/{id}', 'PmsJobController@view_pms_request');
	Route::post('view-pms-request/{id}', 'PmsJobController@store_pms_request');
	Route::post('update-pms-history/{id}', 'PmsJobController@update_pms_history');

	Route::get('pms-request-history/{id}', 'PmsJobController@pms_request_history');
	Route::get('pms-history/{id}', 'PmsJobController@pms_history');
	Route::post('area-site-engineer', 'PmsJobController@area_site_engineer');
	Route::get('properties', 'PropertiesController@index')->middleware(['permission:properties']);
	Route::match(array('GET', 'POST'), 'add-properties', 'PropertiesController@add')->middleware(['permission:add_properties']);
	Route::get('properties/property_list_csv', 'PropertiesController@propertyCsv');
	Route::get('properties/property_list_pdf', 'PropertiesController@propertyPdf');

	Route::group(['middleware' => 'permission:edit_properties'], function () {
		Route::match(array('GET', 'POST'),'listing/{id}/photo_message', 'PropertiesController@photoMessage');
		Route::match(array('GET', 'POST'),'listing/{id}/photo_delete', 'PropertiesController@photoDelete');
		Route::match(array('GET', 'POST'),'listing/{id}/update_status', 'PropertiesController@update_status');
		Route::match(array('POST'),'listing/photo/make_default_photo', 'PropertiesController@makeDefaultPhoto');
		Route::match(array('POST'),'listing/photo/make_photo_serial', 'PropertiesController@makePhotoSerial');
		Route::match(array('GET', 'POST'),'listing/{id}/{step}', 'PropertiesController@listing')->where(['id' => '[0-9]+','page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking']);
	});

	Route::post('ajax-calender/{id}', [CalendarController::class,'calenderJson']);
    Route::post('ajax-calender-price/{id}',[CalendarController::class,'calenderPriceSet']);
    //iCalender routes for admin
    Route::post('ajax-icalender-import/{id}', 'CalendarController@icalendarImport');
    Route::get('icalendar/synchronization/{id}', 'CalendarController@icalendarSynchronization');
    //iCalender routes end
	Route::match(array('GET', 'POST'), 'edit_property/{id}', 'PropertiesController@update')->middleware(['permission:edit_properties']);
	Route::get('delete-property/{id}', 'PropertiesController@delete')->middleware(['permission:delete_property']);
	Route::get('bookings', 'BookingsController@index')->middleware(['permission:manage_bookings']);
	Route::get('bookings/property_search', 'BookingsController@searchProperty')->middleware(['permission:manage_bookings']);
	Route::get('bookings/customer_search', 'BookingsController@searchCustomer')->middleware(['permission:manage_bookings']);
	//booking details
	Route::get('bookings/detail/{id}', 'BookingsController@details')->middleware(['permission:manage_bookings']);
	Route::get('bookings/edit/{req}/{id}', 'BookingsController@updateBookingStatus')->middleware(['permission:manage_bookings']);
	Route::post('bookings/pay', 'BookingsController@pay')->middleware(['permission:manage_bookings']);
	Route::get('booking/need_pay_account/{id}/{type}', 'BookingsController@needPayAccount');
	Route::get('booking/booking_list_csv', 'BookingsController@bookingCsv');
	Route::get('booking/booking_list_pdf', 'BookingsController@bookingPdf');
	Route::get('payouts', 'PayoutsController@index')->middleware(['permission:view_payouts']);
	Route::match(array('GET', 'POST'), 'payouts/edit/{id}', 'PayoutsController@edit');
	Route::get('payouts/details/{id}', 'PayoutsController@details');
	Route::get('payouts/payouts_list_pdf', 'PayoutsController@payoutsPdf');
	Route::get('payouts/payouts_list_csv', 'PayoutsController@payoutsCsv');
	Route::group(['middleware' => 'permission:manage_reviews'], function () {
		Route::get('reviews', 'ReviewsController@index');
		Route::match(array('GET', 'POST'), 'edit_review/{id}', 'ReviewsController@edit');
		Route::get('reviews/review_search', 'ReviewsController@searchReview');
		Route::get('reviews/review_list_csv', 'ReviewsController@reviewCsv');
		Route::get('reviews/review_list_pdf', 'ReviewsController@reviewPdf');

	});

	// Route::get('reports', 'ReportsController@index')->middleware(['permission:manage_reports']);

	// For Reporting
	Route::group(['middleware' => 'permission:view_reports'], function () {
		Route::get('sales-report', 'ReportsController@salesReports');
		Route::get('sales-analysis', 'ReportsController@salesAnalysis');
		Route::get('reports/property-search', 'ReportsController@searchProperty');
		Route::get('overview-stats', 'ReportsController@overviewStats');
	});

	Route::group(['middleware' => 'permission:manage_amenities'], function () {
		Route::get('amenities', 'AmenitiesController@index');
		Route::match(array('GET', 'POST'), 'add-amenities', 'AmenitiesController@add');
		Route::match(array('GET', 'POST'), 'edit-amenities/{id}', 'AmenitiesController@update');
		Route::get('delete-amenities/{id}', 'AmenitiesController@delete');
	});

	Route::group(['middleware' => 'permission:manage_pages'], function () {
		Route::get('pages', 'PagesController@index');
		Route::match(array('GET', 'POST'), 'add-page', 'PagesController@add');
		Route::match(array('GET', 'POST'), 'edit-page/{id}', 'PagesController@update');
		Route::get('delete-page/{id}', 'PagesController@delete');

	});


	Route::group(['middleware' => 'permission:manage_admin'], function () {
		Route::get('admin-users', 'AdminController@index');
		Route::match(array('GET', 'POST'), 'add-admin', 'AdminController@add');
		Route::match(array('GET', 'POST'), 'edit-admin/{id}', 'AdminController@update');
		Route::match(array('GET', 'POST'), 'delete-admin/{id}', 'AdminController@delete');
	});

	Route::group(['middleware' => 'permission:add_employee'], function () {
		Route::get('employee', 'EmployeeController@index')->name('employee');
		Route::match(array('GET', 'POST'), 'add-employee', 'EmployeeController@add');
		Route::match(array('GET', 'POST'), 'edit-employee/{id}', 'EmployeeController@update');
		Route::get('delete-employee/{id}', 'EmployeeController@delete');
	});

	Route::group(['middleware' => 'permission:general_setting'], function () {
		Route::match(array('GET', 'POST'), 'settings', 'SettingsController@general')->middleware(['permission:general_setting']);
		Route::match(array('GET', 'POST'), 'settings/preferences', 'SettingsController@preferences')->middleware(['permission:preference']);
		Route::get('getreCaptchaCredential', 'SettingsController@getreCaptchaCredential');
		Route::post('settings/delete_logo', 'SettingsController@deleteLogo');
		Route::post('settings/delete_favicon', 'SettingsController@deleteFavIcon');
		Route::match(array('GET', 'POST'), 'settings/fees', 'SettingsController@fees')->middleware(['permission:manage_fees']);
		Route::group(['middleware' => 'permission:manage_banners'], function () {
			Route::get('settings/banners', 'BannersController@index');
			Route::match(array('GET', 'POST'), 'settings/add-banners', 'BannersController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-banners/{id}', 'BannersController@update');
			Route::get('settings/delete-banners/{id}', 'BannersController@delete');
		});

		Route::group(['middleware' => 'permission:starting_cities_settings'], function () {
			Route::get('settings/starting-cities', 'StartingCitiesController@index');
			Route::match(array('GET', 'POST'), 'settings/add-starting-cities', 'StartingCitiesController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-starting-cities/{id}', 'StartingCitiesController@update');
			Route::get('settings/delete-starting-cities/{id}', 'StartingCitiesController@delete');
		});

		Route::group(['middleware' => 'permission:manage_property_type'], function () {
			Route::get('settings/property-type', 'PropertyTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-property-type', 'PropertyTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-property-type/{id}', 'PropertyTypeController@update');
			Route::get('settings/delete-property-type/{id}', 'PropertyTypeController@delete');
		});

		Route::group(['middleware' => 'permission:space_type_setting'], function () {
			Route::get('settings/space-type', 'SpaceTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-space-type', 'SpaceTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-space-type/{id}', 'SpaceTypeController@update');
			Route::get('settings/delete-space-type/{id}', 'SpaceTypeController@delete');
		});
		Route::group(['middleware' => 'permission:warehouse_type_setting'], function () {
			Route::get('settings/ware-house-type', 'WareHouseTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-ware-house-type', 'WareHouseTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-ware-house-type/{id}', 'WareHouseTypeController@update');
			Route::get('settings/delete-where-house-type/{id}', 'WareHouseTypeController@delete');
		});

		Route::group(['middleware' => 'permission:accommodates_setting'], function () {
			Route::get('settings/accommodates', 'AccommodatesController@index');
			Route::match(array('GET', 'POST'), 'settings/add-accommodates', 'AccommodatesController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-accommodates/{id}', 'AccommodatesController@update');
			Route::get('settings/delete-accommodates/{id}', 'AccommodatesController@delete');
		});
		Route::group(['middleware' => 'permission:property_type_option'], function () {
			Route::get('settings/property-type-option', 'PropertyTypeOptionController@index');
			Route::match(array('GET', 'POST'), 'settings/add-property-type-option', 'PropertyTypeOptionController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-property-type-option/{id}', 'PropertyTypeOptionController@update');
			Route::get('settings/delete-property-type-option/{id}', 'PropertyTypeOptionController@delete');
		});

		Route::group(['middleware' => 'permission:property_type_option_set'], function () {
			Route::get('settings/property-type-set-option', 'PropertyOptionController@index');
			Route::match(array('GET', 'POST'), 'settings/add-property-type-set-option', 'PropertyOptionController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-property-type-set-option/{id}', 'PropertyOptionController@update');
			Route::get('settings/delete-property-type-set-option/{id}', 'PropertyOptionController@delete');
		});

		Route::group(['middleware' => 'permission:floor_type_setting'], function () {
			Route::get('settings/floor-type', 'floorTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-floor-type', 'floorTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-floor-type/{id}', 'floorTypeController@update');
			Route::get('settings/delete-floor-type/{id}', 'floorTypeController@delete');
		});

		Route::group(['middleware' => 'permission:manage_bed_type'], function () {
			Route::get('settings/bed-type', 'BedTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-bed-type', 'BedTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-bed-type/{id}', 'BedTypeController@update');
			Route::get('settings/delete-bed-type/{id}', 'BedTypeController@delete');
		});

		Route::group(['middleware' => 'permission:manage_currency'], function () {
			Route::get('settings/currency', 'CurrencyController@index');
			Route::match(array('GET', 'POST'), 'settings/add-currency', 'CurrencyController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-currency/{id}', 'CurrencyController@update');
			Route::get('settings/delete-currency/{id}', 'CurrencyController@delete');
		});

		Route::group(['middleware' => 'permission:manage_country'], function () {
			Route::get('settings/country', 'CountryController@index');
			Route::match(array('GET', 'POST'), 'settings/add-country', 'CountryController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-country/{id}', 'CountryController@update');
			Route::get('settings/delete-country/{id}', 'CountryController@delete');
		});

		Route::group(['middleware' => 'permission:manage_amenities_type'], function () {
			Route::get('settings/amenities-type', 'AmenitiesTypeController@index');
			Route::match(array('GET', 'POST'), 'settings/add-amenities-type', 'AmenitiesTypeController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-amenities-type/{id}', 'AmenitiesTypeController@update');
			Route::get('settings/delete-amenities-type/{id}', 'AmenitiesTypeController@delete');
		});

		Route::match(array('GET', 'POST'), 'settings/email', 'SettingsController@email')->middleware(['permission:email_settings']);



		Route::group(['middleware' => 'permission:manage_language'], function () {
			Route::get('settings/language', 'LanguageController@index');
			Route::match(array('GET', 'POST'), 'settings/add-language', 'LanguageController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-language/{id}', 'LanguageController@update');
			Route::get('settings/delete-language/{id}', 'LanguageController@delete');
		});

		Route::match(array('GET', 'POST'), 'settings/fees', 'SettingsController@fees')->middleware(['permission:manage_fees']);

		Route::group(['middleware' => 'permission:manage_metas'], function () {
			Route::get('settings/metas', 'MetasController@index');
			Route::match(array('GET', 'POST'), 'settings/edit_meta/{id}', 'MetasController@update');
		});

		Route::group(['middleware' => 'permission:manage_designation'], function () {
			Route::get('designation', 'DesignationController@index')->name('designation');
			Route::match(array('GET', 'POST'), 'add-designation', 'DesignationController@add');
			Route::match(array('GET', 'POST'), 'edit-designation/{id}', 'DesignationController@update');
			Route::get('delete-designation/{id}', 'DesignationController@delete');
		});
	
		Route::match(array('GET', 'POST'), 'settings/api-informations', 'SettingsController@apiInformations')->middleware(['permission:api_informations']);
		Route::match(array('GET', 'POST'), 'settings/google-recaptcha-api-information', 'SettingsController@googleRecaptchaInformation')->middleware(['permission:google_recaptcha']);
		Route::match(array('GET', 'POST'), 'settings/payment-methods', 'SettingsController@paymentMethods')->middleware(['permission:payment_settings']);
		Route::match(array('GET', 'POST'), 'settings/bank/add', 'BankController@addBank')->middleware(['permission:payment_settings']);
		Route::match(array('GET', 'POST'), 'settings/bank/edit/{bank}', 'BankController@editBank')->middleware(['permission:payment_settings']);
		Route::get('settings/bank/{bank}', 'BankController@show')->middleware(['permission:payment_settings']);
		Route::get('settings/bank/delete/{bank}', 'BankController@deleteBank')->middleware(['permission:payment_settings']);
		Route::match(array('GET', 'POST'), 'settings/social-links', 'SettingsController@socialLinks')->middleware(['permission:social_links']);

        Route::match(array('GET', 'POST'), 'settings/social-logins', 'SettingsController@socialLogin')->middleware(['permission:social_logins']);;

		Route::group(['middleware' => 'permission:manage_roles'], function () {
			Route::get('settings/roles', 'RolesController@index');
			Route::match(array('GET', 'POST'), 'settings/add-role', 'RolesController@add');
			Route::match(array('GET', 'POST'), 'settings/edit-role/{id}', 'RolesController@update');
			Route::get('settings/delete-role/{id}', 'RolesController@delete');
		});

		Route::group(['middleware' => 'permission:database_backup'], function () {
			Route::get('settings/backup', 'BackupController@index');
			Route::get('backup/save', 'BackupController@add');
			Route::get('backup/download/{id}', 'BackupController@download');
		});

		Route::group(['middleware' => 'permission:manage_email_template'], function () {
			Route::get('email-template/{id}', 'EmailTemplateController@index');
			Route::post('email-template/{id}','EmailTemplateController@update');
		});

		Route::group(['middleware' => 'permission:manage_testimonial'], function () {
			Route::get('testimonials', 'TestimonialController@index');
			Route::match(array('GET', 'POST'), 'add-testimonials', 'TestimonialController@add');
			Route::match(array('GET', 'POST'), 'edit-testimonials/{id}', 'TestimonialController@update');
			Route::get('delete-testimonials/{id}', 'TestimonialController@delete');
		});
	});
});

//only can view if admin is not logged in if they are logged in then they will be redirect to dashboard
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'AdminController@login');
	Route::post('authenticate', 'AdminController@authenticate');
	Route::match(array('GET', 'POST'), 'forgot-password', 'AdminController@forgotPassword');
	Route::get('reset-password/{secret?}', 'AdminController@resetPassword');
	Route::post('reset-password', 'AdminController@resetPassword');
});

//only can view if user is not logged in if they are logged in then they will be redirect to dashboard
Route::group(['middleware' => ['no_auth:users', 'locale']], function () {
    Route::get('login', 'LoginController@index');
    Route::get('auth/login', function()
    {
		return Redirect::to('login');
    });
	Route::get('verifyemail','LoginController@verifyemail')->name('verifyemail');
    Route::get('googleLogin', 'LoginController@googleLogin')->middleware('social_login:google_login');
    Route::get('facebookLogin', 'LoginController@facebookLogin')->middleware('social_login:facebook_login');
    Route::get('register', 'HomeController@register');
    Route::match(array('GET', 'POST'), 'forgot_password', 'LoginController@forgotPassword');
    Route::post('create', 'UserController@create');
    Route::post('authenticate', 'LoginController@authenticate');
    Route::get('users/reset_password/{secret?}', 'LoginController@resetPassword');
	
    Route::post('users/reset_password', 'LoginController@resetPassword');
});

Route::get('users/payment_verification/{secret?}', 'LoginController@payment_verification');



Route::get('googleAuthenticate', 'LoginController@googleAuthenticate');
Route::get('facebookAuthenticate', 'LoginController@facebookAuthenticate');


//only can view if user is logged in
Route::get('users/confirm_email/{code?}', 'UserController@confirmEmail');
Route::group(['middleware' => ['guest:users', 'locale']], function () {
    Route::get('dashboard', 'UserController@dashboard');
    Route::match(array('GET', 'POST'),'users/profile', 'UserController@profile');
    Route::match(array('GET', 'POST'),'users/profile/media', 'UserController@media');

    // User verification
    Route::get('users/edit-verification', 'UserController@verification');
    
    Route::get('users/new_email_confirm', 'UserController@newConfirmEmail');

    Route::get('facebookLoginVerification', 'UserController@facebookLoginVerification');
    Route::get('facebookConnect/{id}', 'UserController@facebookConnect');
    Route::get('facebookDisconnect', 'UserController@facebookDisconnectVerification');

    Route::get('googleLoginVerification', 'UserController@googleLoginVerification');
    Route::get('googleConnect/{id}', 'UserController@googleConnect');
    Route::get('googleDisconnect', 'UserController@googleDisconnect');
    // Route::get('googleAuthenticate', 'LoginController@googleAuthenticate');

    Route::get('users/show/{id}', 'UserController@show');
	Route::match(array('GET', 'POST'),'users/reviews', 'UserController@reviews');
	Route::match(array('GET', 'POST'),'users/reviews_by_you', 'UserController@reviewsByYou');
    Route::match(['get', 'post'], 'reviews/edit/{id}', 'UserController@editReviews');
    Route::match(['get', 'post'], 'reviews/details', 'UserController@reviewDetails');

    Route::match(array('GET', 'POST'),'properties', 'PropertyController@userProperties');
	Route::get('download-agreement/{id}', 'PropertyController@downloadPropertyAgreement');
	Route::post('upload-agreement/{id}', 'PropertyController@uploadPropertyAgreement');
    Route::match(array('GET', 'POST'),'property/create', 'PropertyController@create');
    Route::match(array('GET', 'POST'),'listing/{id}/photo_message', 'PropertyController@photoMessage')->middleware(['checkUserRoutesPermissions']);
    Route::match(array('GET', 'POST'),'listing/{id}/photo_delete', 'PropertyController@photoDelete')->middleware(['checkUserRoutesPermissions']);

	Route::match(array('POST'),'listing/photo/make_default_photo', 'PropertyController@makeDefaultPhoto');

	Route::match(array('POST'),'listing/photo/make_photo_serial', 'PropertyController@makePhotoSerial');

    Route::match(array('GET', 'POST'),'listing/update_status', 'PropertyController@updateStatus');
    Route::match(array('GET', 'POST'),'listing/{id}/{step}', 'PropertyController@listing')->where(['id' => '[0-9]+','page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking']);
    Route::match(array('GET', 'POST'),'subcribe/{any}', 'SubscriptionController@subcribe');
    Route::match(array('GET', 'POST'),'subscribe-details/{id}/{property_id}/{subscription_type}/{pms_recurring_packages_id}/{package_id?}', 'SubscriptionController@subscribeDetails')->name('subscribe-details');
	Route::get('subscription-payments/{property_id}/{subscription_type}/{pms_recurring_packages_id}/{package_id?}', 'SubscriptionController@subscription_payments');
    Route::get('thankyou', 'SubscriptionController@ThankYou');
    // Favourites routes
    Route::get('user/favourite', 'PropertyController@userBookmark');
    Route::post('add-edit-book-mark', 'PropertyController@addEditBookMark');

    Route::post('ajax-calender/{id}', 'CalendarController@calenderJson');
    Route::post('ajax-calender-price/{id}', 'CalendarController@calenderPriceSet');
    //iCalendar routes start
    Route::post('ajax-icalender-import/{id}', 'CalendarController@icalendarImport');
    Route::get('icalendar/synchronization/{id}', 'CalendarController@icalendarSynchronization');
    //iCalendar routes end
    Route::post('currency-symbol', 'PropertyController@currencySymbol');
    Route::match(['get', 'post'], 'payments/book/{id?}', 'PaymentController@index');
    Route::post('payments/create_booking', 'PaymentController@createBooking');
    Route::get('payments/success', 'PaymentController@success');
    Route::get('payments/cancel', 'PaymentController@cancel');
    Route::get('payments/stripe', 'PaymentController@stripePayment');
    Route::post('payments/stripe-request', 'PaymentController@stripeRequest');
    Route::match(['get', 'post'], 'payments/bank-payment', 'PaymentController@bankPayment');
    Route::get('booking/{id}', 'BookingController@index')->where('id', '[0-9]+');
    Route::get('booking_payment/{id}', 'BookingController@requestPayment')->where('id', '[0-9]+');
    Route::get('booking/requested', 'BookingController@requested');
    Route::get('booking/itinerary_friends', 'BookingController@requested');
    Route::post('booking/accept/{id}', 'BookingController@accept');
    Route::post('booking/decline/{id}', 'BookingController@decline');
    Route::get('booking/expire/{id}', 'BookingController@expire');
    Route::match(['get', 'post'], 'my-bookings', 'BookingController@myBookings');
    Route::post('booking/host_cancel', 'BookingController@hostCancel');
    Route::match(['get', 'post'], 'trips/active', 'TripsController@myTrips');
    Route::get('booking/receipt', 'TripsController@receipt');
    Route::post('trips/guest_cancel', 'TripsController@guestCancel');

    // Messaging
    Route::match(['get', 'post'], 'inbox', 'InboxController@index');
    Route::post('messaging/booking/', 'InboxController@message');
    Route::post('messaging/reply/', 'InboxController@messageReply');

    Route::match(['get', 'post'], 'users/account-preferences', 'UserController@accountPreferences');
    Route::get('users/account_delete/{id}', 'UserController@accountDelete');
    Route::get('users/account_default/{id}', 'UserController@accountDefault');
    Route::get('users/transaction-history', 'UserController@transactionHistory');
	Route::get('users/job-approval', 'UserController@jobApproval');	
	Route::post('users/update-job-approval', 'UserController@updateJobApproval');
	Route::get('users/package-list', 'UserController@packageList');
	Route::post('users/paynow', 'UserController@paynow');
    Route::post('users/account_transaction_history', 'UserController@getCompletedTransaction');
	Route::get('users/invoice/{id}', 'UserController@invoice');


	// for customer payout settings
	Route::match(['GET', 'POST'], 'users/payout', 'PayoutController@index');
	Route::match(['GET', 'POST'], 'users/payout/setting', 'PayoutController@setting');
	Route::match(['GET', 'POST'], 'users/payout/edit-payout/', 'PayoutController@edit');
	Route::match(['GET', 'POST'], 'users/payout/delete-payout/{id}', 'PayoutController@delete');

	// for payout request
	Route::match(['GET', 'POST'], 'users/payout-list', 'PayoutController@payoutList');
	Route::match(['GET', 'POST'], 'users/payout/success', 'PayoutController@success');

    Route::match(['get', 'post'], 'users/security', 'UserController@security');
    Route::get('logout', function()
	{
		Auth::logout();
        Session::flush();
		return Redirect::to('login');
	});
});

Route::post('update-job-approval', 'UserController@updateJobApproval');
Route::post('paynow', 'UserController@paynow');
Route::get('thank-you', 'UserController@thank_you');

//for exporting iCalendar
Route::get('icalender/export/{id}', 'CalendarController@icalendarExport');
Route::get('{name}', 'HomeController@staticPages')->middleware('locale');
Route::post('duplicate-phone-number-check', 'UserController@duplicatePhoneNumberCheck');
Route::post('duplicate-phone-number-check-for-existing-customer', 'UserController@duplicatePhoneNumberCheckForExistingCustomer');
Route::match(['get', 'post'],'upload_image','Admin\PagesController@uploadImage')->name('upload');
