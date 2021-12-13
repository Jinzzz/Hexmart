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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//category list
Route::post('customer/save', 'Api\CustomerController@saveCustomer');
Route::post('customer/login', 'Api\CustomerController@loginCustomer');

Route::post('customer/add-address', 'Api\CustomerController@addAddress');
Route::post('customer/edit-address', 'Api\CustomerController@editAddress');
Route::get('customer/remove-address', 'Api\CustomerController@removeAddress');
Route::get('customer/view-address', 'Api\CustomerController@ViewAddress');
Route::get('customer/address-list', 'Api\CustomerController@listAddress');

Route::get('customer/view-profile', 'Api\CustomerController@ViewProfile');
Route::post('customer/update-profile', 'Api\CustomerContr-oller@updateProfile');

Route::get('all-product-category/list', 'Api\MasterController@listAllCategory');
Route::get('product-category/list', 'Api\MasterController@listCategory');
Route::get('product-subcategory-level-one/list', 'Api\MasterController@listSubCategoryLevOne');
Route::get('product-subcategory-level-two/list', 'Api\MasterController@listSubCategoryLevTwo');

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
