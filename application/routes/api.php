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

Route::post('/login','Api\LoginController@login');
Route::post('/login-with-mobile','Api\LoginController@login_with_mobile');
Route::post('/mobile-verify-code','Api\LoginController@mobile_verify_code');
Route::post('/register', 'Api\LoginController@register');
Route::get('/product-menu', 'Api\IndexController@product_menu');
Route::get('/index-menu', 'Api\IndexController@index_menu');
Route::get('/footer-menu', 'Api\IndexController@footer_menu');
Route::get('/get-state', 'Api\AppController@get_state');
Route::get('/get-city', 'Api\AppController@get_city');
Route::get('first-page','Api\IndexController@first_page');
Route::get('footer','Api\IndexController@footer');
Route::get('products','Api\ProductController@products');
Route::get('get-category','Api\ProductController@get_category');
Route::get('get-brands','Api\ProductController@get_brands');
Route::get('get-sizing','Api\ProductController@get_sizing');
Route::get('get-colors','Api\ProductController@get_colors');
Route::get('product-info','Api\ProductController@product_info');
Route::get('product-comment/{product_id}','Api\ProductController@product_comment');
Route::get('/search','Api\AppController@search');
Route::get('/rule','Api\AppController@rule');
Route::get('/privacy-policy','Api\AppController@privacy_policy');
Route::get('/about','Api\AppController@about');
Route::match(['get','post'],'torob/products','Api\ProductController@torob');
Route::get('seller-landing','Api\SellerController@seller_landing');
Route::get('seller-comment','Api\SellerController@seller_comment');
Route::get('seller-list','Api\SellerController@seller_list');
Route::get('seller-products','Api\SellerController@seller_products');


Route::group(['middleware' => ['JwtToken']], function() {
    Route::get('/logout', 'Api\LoginController@logout');
    Route::post('/refresh', 'Api\LoginController@refresh');
    Route::post('/profile', 'Api\LoginController@profile');
    Route::match(['get','post'],'/cart','Api\CartController@cart');
    Route::get('/checkCoupon','Api\CartController@checkCoupon');
    Route::get('/shippingMethod','Api\CartController@shippingMethod');
    Route::post('/shippingCalculate','Api\CartController@shippingCalculate');
    Route::post('/newInvoice','Api\CartController@newInvoice');
    Route::get('/payment-gate-list','Api\CartController@paymentGateList');
    Route::post('/paymentRequest','Api\CartController@paymentRequest');
    Route::get('/setting','Api\AppController@setting');
    Route::get('/add-to-favorite','Api\AppController@add_to_favorite');
    Route::get('/add-follow','Api\AppController@add_follow');
    Route::post('/save-comment','Api\CommentController@newComment');
    Route::post('/save-question','Api\CommentController@save_question');

    //Bank Callback **************
    Route::group([
            'prefix' => 'profile'
        ]
        ,function ()
        {
            Route::match(['get','post'],'/','Api\ProfileController@index');
            Route::post('/update','Api\ProfileController@profileUpdate');
            Route::get('/orders','Api\ProfileController@myOrders');
            Route::get('/order-info','Api\ProfileController@orderInfo');
            Route::get('/favorite','Api\ProfileController@favorite');
            Route::get('/comment','Api\ProfileController@myComment');
            Route::post('/change-pass','Api\ProfileController@changePass');
            Route::get('/address','Api\UserController@myAddress');
            Route::post('/editAddress','Api\UserController@editAddress');
            Route::post('/deleteAddress','Api\UserController@deleteAddress');
        });
});

