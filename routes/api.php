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

Route::get('informations', 'Api\InfoController@info');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//category list
Route::post('customer/save', 'Api\CustomerController@saveCustomer');
Route::post('customer/login', 'Api\CustomerController@loginCustomer');
Route::post('customer/change-password', 'Api\CustomerController@updatePassword');
Route::get('customer/otp-verify', 'Api\CustomerController@verifyOtp');
//customer resendotp check
Route::get('/resendOtp', 'Api\CustomerController@resend_Otp');
Route::get('customer/otp-resend', 'Api\CustomerController@resendOtp');

Route::post('customer/add-address', 'Api\CustomerController@addAddress');
Route::post('customer/edit-address', 'Api\CustomerController@editAddress');
Route::get('customer/remove-address', 'Api\CustomerController@removeAddress');
Route::get('customer/view-address', 'Api\CustomerController@ViewAddress');
Route::get('customer/address-list', 'Api\CustomerController@listAddress');
//forgot and reset password api
Route::get('customer/forgot-password', 'Api\CustomerController@forgotpassword');
Route::post('customer/reset-password', 'Api\CustomerController@reset_password');
//product pageination filter api
Route::get('customer/prodcut-list', 'Api\CustomerController@productfilter_list');
Route::get('customer/subcatprodcut-list', 'Api\CustomerController@subcatproductfilter_list');
Route::get('customer/mainsubprodcut-list', 'Api\CustomerController@mainsubproductfilter_list');

http: //yellowstore.hexeam.org/api/store/otp-verify?store_id=1&otp_status=accepted

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('customer/view-profile', 'Api\CustomerController@ViewProfile');
});

Route::post('customer/update-profile', 'Api\CustomerController@updateProfile');

Route::get('all-product-category/list', 'Api\MasterController@listAllCategory');
Route::get('product-category/list', 'Api\MasterController@listCategory');
Route::get('product-subcategory-level-one/list', 'Api\MasterController@listSubCategoryLevOne');
Route::get('product-subcategory-level-two/list', 'Api\MasterController@listSubCategoryLevTwo');
Route::get('brand/list', 'Api\MasterController@listBrand');

Route::get('banner/list', 'Api\MasterController@listBanner');
Route::get('offer-products/list', 'Api\MasterController@listOfferProducts');

// Recently added products
Route::get('recently-added-products/list', 'Api\ProductController@listRecentProducts');

Route::get('products/list', 'Api\ProductController@listProducts');
Route::get('product/view', 'Api\ProductController@viewProducts');

//cart
Route::get('product/add-to-cart', 'Api\ProductController@addToCart');
Route::get('cart/list', 'Api\ProductController@cartList');
Route::get('cart/remove-item', 'Api\ProductController@removeCartItem');

//wish list
Route::get('product/add-to-wish-list', 'Api\ProductController@addToWishList');
Route::get('wish-list', 'Api\ProductController@wishList');

//list coupon
Route::get('coupon/list', 'Api\CouponController@couponList');

//save order
Route::post('save-order', 'Api\OrderController@saveOrder');
Route::get('order/list', 'Api\OrderController@listOrders');
Route::get('order/view', 'Api\OrderController@viewOrder');
Route::get('order/cancel', 'Api\OrderController@cancelOrder'); // updated cancel status is not correct
Route::get('order/status', 'Api\OrderController@orderStatus');
Route::get('order-status/update', 'Api\OrderController@orderStatusUpdate');

//checkout page
Route::post('checkout-page', 'Api\OrderController@checkoutPage');
Route::get('reduce-reward-points', 'Api\OrderController@reduceRewardPoint');

// home page
Route::get('customer/home', 'Api\HomePageController@homePage');

Route::post('customer/add-review', 'Api\ProductController@addReview');

Route::get('/product/review-rating/list', 'Api\ProductController@getReviewAndRating');

