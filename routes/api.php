<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/user_MLT', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user'], function () {
   
    Route::group(['middleware' => ['auth:appUser']], function () {
        Route::post('newpassword', 'AppUsersController@newPassword');
        Route::post('profile/update', 'AppUsersController@profileUpdate');
        Route::post('profile/password/update', 'AppUsersController@password');
        Route::post('profile/picture/update', 'AppUsersController@profilePictureUpdate');
        Route::post('update_app_lang', 'AppUsersController@update_app_lang');

        Route::post('booking', 'AppBookingController@store');
        Route::get('booking', 'AppBookingController@userBooking');
        Route::get('booking/{id}', 'AppBookingController@singleBooking');
 	    Route::post('cancelOrder', 'AppBookingController@cancelOrder');
        Route::post('approveOrder', 'AppBookingController@approveOrder');
        Route::post('updateBookingAttachments', 'AppBookingController@updateBookingAttachments');
        Route::post('review', 'AppBookingController@store_review');

        /*
        Route::post('updateFCMToken', 'AppUsersController@updateFCMToken');
       
        Route::post('upload_paymentNotifyImg', 'AppUsersController@upload_paymentNotifyImg');
        Route::get('paymentNotifyImg/{id}', 'AppUsersController@paymentNotifyImg');
        Route::get('delete_payment_notification/{id}', 'AppUsersController@delete_payment_notification');
        Route::get('notification', 'AppUsersController@notiList');
       */
        Route::get('profile', function (Request $request) {
            return $request->user();
        });
    });
    
   Route::post('register', 'AppUsersController@store');
   Route::post('verifyMe', 'AppUsersController@verifyMe');
   Route::post('login', 'AppUsersController@login');
   Route::post('forgot', 'AppUsersController@forgot');
   Route::post('forgot/validate', 'AppUsersController@forgotValidate');
   Route::post('SignupPageOTP', 'AppUsersController@SignupPageOTP');
    
   /**************** API  */
   Route::get('PayerList/{classification_id}', 'AppUsersController@PayerList');
   Route::get('AlborgService/{payer_contract_id}/{payer_code}', 'AppUsersController@AlborgService');
   Route::get('ServiceTests/{service_id}/{is_nested_services}', 'AppUsersController@ServiceTests');
   Route::get('calculat_visit_by_location/{lat}/{lng}/{area_id}', 'AppUsersController@calculat_visit_by_location');
   
   Route::get('about_us', 'AppUsersController@about_us');
    

});


   /******* MLT Users  ************/

Route::group(['prefix' => 'user_MLT'], function () {

    Route::group(['middleware' => ['auth:lab_tech_users']], function () {
        Route::post('newpassword', 'AppUsersController@newPassword_MLT');
        Route::post('profile/update', 'AppUsersController@profileUpdate_MLT');
        Route::post('profile/password/update', 'AppUsersController@password_MLT');
        Route::post('profile/picture/update', 'AppUsersController@profilePictureUpdate_MLT');
        Route::post('update_app_lang', 'AppUsersController@update_app_lang_MLT');

        Route::get('MLT_requests', 'AppBookingController@MLT_Requests');
        Route::get('MLT_request/{id}', 'AppBookingController@single_MLT_Requests');
 	    //Route::post('cancelOrder', 'AppBookingController@cancelOrder');
        Route::post('start_processing', 'AppBookingController@start_processing_MLT');
        Route::post('smaple_collected', 'AppBookingController@smaple_collected_MLT');

        
       // Route::post('updateBookingAttachments', 'AppBookingController@updateBookingAttachments');
        /*
        Route::post('updateFCMToken', 'AppUsersController@updateFCMToken');
        Route::post('review', 'Admin\ReviewController@store');
       
        Route::post('upload_paymentNotifyImg', 'AppUsersController@upload_paymentNotifyImg');
        Route::get('paymentNotifyImg/{id}', 'AppUsersController@paymentNotifyImg');
        Route::get('delete_payment_notification/{id}', 'AppUsersController@delete_payment_notification');
        Route::get('notification', 'AppUsersController@notiList');
       */
        Route::get('profile', function (Request $request) {
            return $request->user();
        });
    });
    
    Route::post('login', 'AppUsersController@login_MLT');

   //Route::post('register', 'AppUsersController@store');
   //Route::post('verifyMe', 'AppUsersController@verifyMe');
   Route::post('forgot', 'AppUsersController@forgot_MLT');
   Route::post('forgot/validate', 'AppUsersController@forgotValidate_MLT');
   //Route::post('SignupPageOTP', 'AppUsersController@SignupPageOTP');
    
   /**************** API  */   
   Route::get('about_us', 'AppUsersController@about_us');
});
