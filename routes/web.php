<?php
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//customer webpage details
Route::group(['namespace' => 'customer'], function ()
{
    Route::get('/', 'HomeController@Home')->name('customer.home');
    Route::any('/home/product/{name}', 'ProductController@productlist')
        ->name('customer.productlist');
    Route::any('/home/subcatgeory/{name}/{catname}', 'ProductController@productcatlist')
        ->name('customer.productcatlist');
    Route::any('/home/mainsubcatgeory/{name}/{catname}/{mainsubcat}', 'ProductController@mainsubcatgeory')
        ->name('customer.mainsubcatgeory');
    Route::get('/productdetail/{name}/{catname}', 'ProductController@productdetail')
        ->name('customer.productdetail');
    Route::get('/productsubdetail/{name}/{catname}/{variant_name}', 'ProductController@productsubdetail')
        ->name('customer.productsubdetail');
    Route::get('/productmainsubdetail/{name}/{catname}/{variant_name}/{mainsub}', 'ProductController@productmainsubdetail')
        ->name('customer.productmainsubdetail');
    Route::post('/add_to_cart', 'CartController@addcart')
        ->name('customer.addtocart');
    Route::get('/show-Cart', 'CartController@show_Cart')
        ->name('customer.show_Cart');
   //customer dashboard
    Route::middleware(['customer'])->group(function ()
    {
        Route::get('/customer-dashboard', 'HomeController@dashboard')
            ->name('customerdashboard');
    });
    //customer login register details
    Route::group(['prefix' => 'customer'], function ()
    {
        Route::get('/register', 'RegisterController@register')
            ->name('register');
        Route::post('/Customer-Register', 'RegisterController@cust_register')
            ->name('cust_register');

        Route::get('/customer-login', 'LoginController@showLoginForm')
            ->name('customerlogin');
        Route::post('/customer-store', 'LoginController@usrlogin')
            ->name('cust_store');
    });

});

Route::group(['namespace' => 'admin'], function ()
{

    Route::get('admin-login', 'HomeController@index')
        ->name('admin.login');
    Route::get('/admin-home', 'AdminController@adminHome')
        ->name('admin.home');

    //units
    // list and manage
    Route::get('/admin/units/list', 'MasterController@listUnit')
        ->name('admin.units');
    // add unit view
    Route::get('/admin/unit/create', 'MasterController@createUnit')
        ->name('admin.create_unit');
    // store unit
    Route::post('/admin/unit/store', 'MasterController@storeUnit')
        ->name('admin.store_unit');
    // remove unit
    Route::post('/admin/unit/remove/{unit_id}', 'MasterController@removeUnit')
        ->name('admin.destroy_unit');
    // update unit
    Route::post('/admin/unit/update/{unit_id}', 'MasterController@updateUnit')
        ->name('admin.update_unit');
    // edit unit view
    Route::get('/admin/unit/edit/{unit_id}', 'MasterController@editUnit')
        ->name('admin.edit_unit');
    //change status
    Route::get('admin/ajax/change-status/unit', 'MasterController@editStatusUnit');

    //item category
    // list and manage
    Route::get('/admin/item-category/list', 'MasterController@listItemCategory')
        ->name('admin.item_category');
    // add category view
    Route::get('/admin/item-category/create', 'MasterController@createItemCategory')
        ->name('admin.create_item_category');
    // store category
    Route::post('/admin/item-category/store', 'MasterController@storeItemCategory')
        ->name('admin.store_item_category');
    // remove category
    Route::post('/admin/item-category/remove/{item_category_id}', 'MasterController@removeItemCategory')
        ->name('admin.destroy_item_category');
    // update category
    Route::post('/admin/item-category/update/{item_category_id}', 'MasterController@updateItemCategory')
        ->name('admin.update_item_category');
    // edit category view
    Route::get('/admin/item-category/edit/{category_name_slug}', 'MasterController@editItemCategory')
        ->name('admin.edit_item_category');
    //change status
    Route::get('admin/ajax/change-status/item-category', 'MasterController@editStatusItemCategory');

    //item sub category
    // list and manage
    Route::get('/admin/item-sub-category/list', 'MasterController@listItemSubCategory')
        ->name('admin.item_sub_category');
    // add sub category view
    Route::get('/admin/item-sub-category/create', 'MasterController@createItemSubCategory')
        ->name('admin.create_item_sub_category');
    // store sub category
    Route::post('/admin/item-sub-category/store', 'MasterController@storeItemSubCategory')
        ->name('admin.store_item_sub_category');
    // remove sub  category
    Route::post('/admin/item-sub-category/remove/{item_sub_category_id}', 'MasterController@removeItemSubCategory')
        ->name('admin.destroy_item_sub_category');
    // update  sub category
    Route::post('/admin/item-sub-category/update/{item_sub_category_id}', 'MasterController@updateItemSubCategory')
        ->name('admin.update_item_sub_category');
    // edit sub category view
    Route::get('/admin/item-sub-category/edit/{item_sub_category_id}', 'MasterController@editItemSubCategory')
        ->name('admin.edit_item_sub_category');
    //change status
    Route::get('admin/ajax/change-status/item-sub-category', 'MasterController@editStatusItemSubCategory');

    //item sub category level two
    // list and manage
    Route::get('/admin/item-sub-category-level-two/list', 'MasterController@listIltsc')
        ->name('admin.iltsc');
    // add sub category view
    Route::get('/admin/item-sub-category-level-two/create', 'MasterController@createIltsc')
        ->name('admin.create_iltsc');
    // store sub category
    Route::post('/admin/item-sub-category-level-two/store', 'MasterController@storeIltsc')
        ->name('admin.store_iltsc');
    // remove sub  category
    Route::post('/admin/item-sub-category-level-two/remove/{iltsc_id}', 'MasterController@removeIltsc')
        ->name('admin.destroy_iltsc');
    // update  sub category
    Route::post('/admin/item-sub-category-level-two/update/{iltsc_id}', 'MasterController@updateIltsc')
        ->name('admin.update_iltsc');
    // edit sub category view
    Route::get('/admin/item-sub-category-level-two/edit/{iltsc_id}', 'MasterController@editIltsc')
        ->name('admin.edit_iltsc');
    //change status
    Route::get('admin/ajax/change-status/item-sub-category-level-two', 'MasterController@editStatusIltsc');

    //brands
    // list and manage
    Route::get('/admin/brands/list', 'MasterController@listBrand')
        ->name('admin.brands');
    // add brand view
    Route::get('/admin/brand/create', 'MasterController@createBrand')
        ->name('admin.create_brand');
    // store brand
    Route::post('/admin/brand/store', 'MasterController@storeBrand')
        ->name('admin.store_brand');
    // remove brand
    Route::post('/admin/brand/remove/{brand_id}', 'MasterController@removeBrand')
        ->name('admin.destroy_brand');
    // update brand
    Route::post('/admin/brand/update/{brand_id}', 'MasterController@updateBrand')
        ->name('admin.update_brand');
    // edit brand view
    Route::get('/admin/brand/edit/{brand_id}', 'MasterController@editBrand')
        ->name('admin.edit_brand');
    //change status
    Route::get('admin/ajax/change-status/brand', 'MasterController@editStatusBrand');

    //issues
    Route::get('admin/issues/list', 'MasterController@listIssues')
        ->name('admin.issues');
    // add issue view
    Route::get('/admin/issue/create', 'MasterController@createissue')
        ->name('admin.create_issue');
    // store issue
    Route::post('/admin/issue/store', 'MasterController@storeissue')
        ->name('admin.store_issue');
    // remove issue
    Route::post('/admin/issue/remove/{issue_id}', 'MasterController@removeissue')
        ->name('admin.destroy_issue');
    // update issue
    Route::post('/admin/issue/update/{issue_id}', 'MasterController@updateissue')
        ->name('admin.update_issue');
    // edit issue view
    Route::get('/admin/issue/edit/{issue_id}', 'MasterController@editissue')
        ->name('admin.edit_issue');
    //change status
    Route::get('admin/ajax/change-status/issue', 'MasterController@editStatusissue');

    //tax master
    Route::get('admin/tax/list', 'MasterController@listTaxes')
        ->name('admin.list_taxes');
    Route::post('admin/tax/create', 'MasterController@createTax')
        ->name('admin.create_tax');
    Route::post('admin/tax/remove/{tax_id}', 'MasterController@removeTax')
        ->name('admin.destroy_tax');
    Route::post('admin/tax/update/{tax_id}', 'MasterController@updateTax')
        ->name('admin.update_tax');
    Route::get('admin/tax/edit/{tax_id}', 'MasterController@editTax')
        ->name('admin.edit_tax');
    Route::get('admin/tax/create', 'MasterController@addTaxes')
        ->name('admin.add_tax');
    Route::get('admin/ajax/change-status/tax', 'MasterController@editStatusTax');

    //attribute-group
    // list and manage
    Route::get('/admin/attribute-group/list', 'MasterController@listAttributeGroup')
        ->name('admin.attribute_group');
    // add attribute_group view
    Route::get('/admin/attribute-group/create', 'MasterController@createAttributeGroup')
        ->name('admin.create_attribute_group');
    // store attribute_group
    Route::post('/admin/attribute-group/store', 'MasterController@storeAttributeGroup')
        ->name('admin.store_attribute_group');
    // remove attribute_group
    Route::post('/admin/attribute-group/remove/{attribute_group_id}', 'MasterController@removeAttributeGroup')
        ->name('admin.destroy_attribute_group');
    // update attribute_group
    Route::post('/admin/attribute-group/update/{attribute_group_id}', 'MasterController@updateAttributeGroup')
        ->name('admin.update_attribute_group');
    // edit attribute_group view
    Route::get('/admin/attribute-group/edit/{attribute_group_id}', 'MasterController@editAttributeGroup')
        ->name('admin.edit_attribute_group');
    //change status
    Route::get('admin/ajax/change-status/attribute-group', 'MasterController@editStatusAttributeGroup');

    //attribute-value
    // list and manage
    Route::get('/admin/attribute-value/list', 'MasterController@listAttributeValue')
        ->name('admin.attribute_value');
    // add attribute_value view
    Route::get('/admin/attribute-value/create', 'MasterController@createAttributeValue')
        ->name('admin.create_attribute_value');
    // store attribute_value
    Route::post('/admin/attribute-value/store', 'MasterController@storeAttributeValue')
        ->name('admin.store_attribute_value');
    // remove attribute_value
    Route::post('/admin/attribute-value/remove/{attribute_value_id}', 'MasterController@removeAttributeValue')
        ->name('admin.destroy_attribute_value');
    // update attribute_value
    Route::post('/admin/attribute-value/update/{attribute_value_id}', 'MasterController@updateAttributeValue')
        ->name('admin.update_attribute_value');
    // edit attribute_value view
    Route::get('/admin/attribute-value/edit/{attribute_value_id}', 'MasterController@editAttributeValue')
        ->name('admin.edit_attribute_value');
    //change status
    Route::get('admin/ajax/change-status/attribute-value', 'MasterController@editStatusAttributeValue');

    //products
    // list and manage
    Route::get('/admin/products/list', 'ProductController@listProduct')
        ->name('admin.products');
    // add product view
    Route::get('/admin/product/create', 'ProductController@createProduct')
        ->name('admin.create_product');
    // store product
    Route::post('/admin/product/store', 'ProductController@storeProduct')
        ->name('admin.store_product');
    // remove product
    Route::post('/admin/product/remove/{product_id}', 'ProductController@removeProduct')
        ->name('admin.destroy_product');
    Route::post('/admin/product-image/remove/{item_image_id}', 'ProductController@removeProductImage')
        ->name('admin.destroy_product_image');
    Route::post('/admin/product-variant/remove/{product_variant_id}', 'ProductController@removeProductVariant')
        ->name('admin.destroy_product_variant');
    Route::post('/admin/product-variant-attribute/remove/{variant_attribute_id}', 'ProductController@removeProVarAttr')
        ->name('admin.destroy_product_var_attr');

    // update product
    Route::post('/admin/product/update/{product_id}', 'ProductController@updateProduct')
        ->name('admin.update_product');
    // edit product view
    Route::get('/admin/product/edit/{product_id}', 'ProductController@editProduct')
        ->name('admin.edit_product');
    //change status
    Route::get('admin/ajax/change-status/product', 'ProductController@editStatusProduct');
    Route::get('admin/ajax/get-sub-category', 'ProductController@GetItemSubCategory');
    Route::get('admin/ajax/get-attribute-value', 'ProductController@GetAttribiteValue');
    Route::get('admin/ajax/get-sub-category-level-two', 'ProductController@GetItemSubCategoryL2');
    Route::post('/admin/product-variant-attribute/store', 'ProductController@storeProVarAttr')
        ->name('admin.add_attr_to_variant');
    Route::get('/ajax/product/set_default_image', 'ProductController@setDefaultImage');
    Route::get('/admin/product-variant/list/{product_id}', 'ProductController@listProductVariant')
        ->name('admin.product_variants');
    Route::get('/admin/product-variant/edit/{product_variant_id}', 'ProductController@editProductVariant')
        ->name('admin.edit_product_variant');
    Route::post('/admin/product-variant/update/{product_variant_id}', 'ProductController@updateProductVariant')
        ->name('admin.update_product_variant');
    Route::get('admin/product/view/{id}', 'ProductController@viewProduct')
        ->name('admin.view_product');

    //inventory
    Route::get('admin/inventory/list', 'ProductController@listInventory')
        ->name('admin.inventory');
    Route::post('admin/stock-update/ajax', 'ProductController@UpdateStock')
        ->name('admin.stock_update');
    Route::post('admin/stock-reset/ajax', 'ProductController@resetStock')
        ->name('admin.stock_reset');

    //customer
    Route::get('admin/customers/list', 'CustomerController@listCustomers')
        ->name('admin.customers');
    // add customer view
    Route::get('/admin/customer/create', 'CustomerController@createCustomer')
        ->name('admin.create_customer');
    // store customer
    Route::post('/admin/customer/store', 'CustomerController@storeCustomer')
        ->name('admin.store_customer');
    // remove customer
    Route::post('/admin/customer/remove/{customer_id}', 'CustomerController@removeCustomer')
        ->name('admin.destroy_customer');
    // update customer
    Route::post('/admin/customer/update/{customer_id}', 'CustomerController@updateCustomer')
        ->name('admin.update_customer');
    // edit customer view
    Route::get('/admin/customer/edit/{customer_id}', 'CustomerController@editCustomer')
        ->name('admin.edit_customer');
    //change status
    Route::get('admin/ajax/change-status/customer', 'CustomerController@editStatusCustomer');

    //customer_group
    // list and manage
    Route::get('/admin/customer-group/list', 'CustomerController@listCustomerGroup')
        ->name('admin.customer_groups');
    // add customer_group view
    Route::get('/admin/customer-group/create', 'CustomerController@createCustomerGroup')
        ->name('admin.create_customer_group');
    // store customer_group
    Route::post('/admin/customer-group/store', 'CustomerController@storeCustomerGroup')
        ->name('admin.store_customer_group');
    // remove customer_group
    Route::post('/admin/customer-group/remove/{customer_group_id}', 'CustomerController@removeCustomerGroup')
        ->name('admin.destroy_customer_group');
    // update customer_group
    Route::post('/admin/customer-group/update/{customer_group_id}', 'CustomerController@updateCustomerGroup')
        ->name('admin.update_customer_group');
    // edit customer_group view
    Route::get('/admin/customer-group/edit/{customer_group_id}', 'CustomerController@editCustomerGroup')
        ->name('admin.edit_customer_group');
    //change status
    Route::get('admin/ajax/change-status/customer-group', 'CustomerController@editStatusCustomerGroup');

    //customer_group customers
    Route::get('/admin/customer-group-customers/list', 'CustomerController@listCustomerGroupCustomers')
        ->name('admin.customer_group_customers');

    Route::post('/admin/customer-group-customers/remove', 'CustomerController@removeCGC')
        ->name('admin.destroy_cgc');
    Route::get('/admin/customer-group-customers/assign', 'CustomerController@assignCGC')
        ->name('admin.assign_customer_to_cg');
    Route::post('/admin/customer-group-customers/store', 'CustomerController@storeCGC')
        ->name('admin.store_cgc_assign');

    // coupon
    Route::get('admin/coupon/list', 'MasterController@listCoupon')
        ->name('admin.list_coupon');
    Route::get('admin/coupon/create', 'MasterController@createCoupon')
        ->name('admin.create_coupon');
    Route::post('admin/coupon/store', 'MasterController@storecoupon')
        ->name('admin.store_coupon');
    Route::post('admin/coupon/remove/{coupon_id}', 'MasterController@removecoupon')
        ->name('admin.destroy_coupon');
    Route::post('admin/coupon/update/{coupon_id}', 'MasterController@updatecoupon')
        ->name('admin.update_coupon');
    Route::get('admin/coupon/edit/{coupon_id}', 'MasterController@editcoupon')
        ->name('admin.edit_coupon');

    //orders
    Route::get('admin/orders/list', 'AdminController@listOrders')
        ->name('admin.orders');
    Route::get('admin/ajax/find-status/order', 'AdminController@findOrderStatus');
    Route::get('admin/ajax/update-status/order', 'AdminController@updateOrderStatus');
    //not using down side route
    Route::post('admin/order-status/update/{order_id}', 'AdminController@ordersStatus')
        ->name('admin.update_order_status');
    Route::get('admin/ajax/view-order', 'AdminController@viewOrder');

    //delivery_boys
    // list and manage
    Route::get('/admin/delivery-boys/list', 'MasterController@listDeliveryBoy')
        ->name('admin.delivery_boys');
    // add delivery_boy view
    Route::get('/admin/delivery-boy/create', 'MasterController@createDeliveryBoy')
        ->name('admin.create_delivery_boy');
    // store delivery_boy
    Route::post('/admin/delivery-boy/store', 'MasterController@storeDeliveryBoy')
        ->name('admin.store_delivery_boy');
    // remove delivery_boy
    Route::post('/admin/delivery-boy/remove/{delivery_boy_id}', 'MasterController@removeDeliveryBoy')
        ->name('admin.destroy_delivery_boy');
    // update delivery_boy
    Route::post('/admin/delivery-boy/update/{delivery_boy_id}', 'MasterController@updateDeliveryBoy')
        ->name('admin.update_delivery_boy');
    // edit delivery_boy view
    Route::get('/admin/delivery-boy/edit/{delivery_boy_id}', 'MasterController@editDeliveryBoy')
        ->name('admin.edit_delivery_boy');
    //change status
    Route::get('admin/ajax/change-status/delivery-boy', 'MasterController@editStatusDeliveryBoy');

    Route::get('/admin/disputes/list', 'AdminController@listDisputes')
        ->name('admin.disputes');
    Route::get('admin/ajax/find-status/dispute', 'AdminController@findDisputeStatus');
    Route::get('admin/ajax/update-status/dispute', 'AdminController@updateDisputeStatus');
    Route::get('admin/ajax/view-dispute', 'AdminController@viewDisputeStatus');

    //customer_banners
    // list and manage
    Route::get('/admin/customer-banners/list', 'MasterController@listCustomerBanner')
        ->name('admin.customer_banners');
    // add customer_banner view
    Route::get('/admin/customer-banner/create', 'MasterController@createCustomerBanner')
        ->name('admin.create_customer_banner');
    // store customer_banner
    Route::post('/admin/customer-banner/store', 'MasterController@storeCustomerBanner')
        ->name('admin.store_customer_banner');
    // remove customer_banner
    Route::post('/admin/customer-banner/remove/{customer_banner_id}', 'MasterController@removeCustomerBanner')
        ->name('admin.destroy_customer_banner');
    // update customer_banner
    Route::post('/admin/customer-banner/update/{customer_banner_id}', 'MasterController@updateCustomerBanner')
        ->name('admin.update_customer_banner');
    // edit customer_banner view
    Route::get('/admin/customer-banner/edit/{customer_banner_id}', 'MasterController@editCustomerBanner')
        ->name('admin.edit_customer_banner');
    //change status
    Route::get('admin/ajax/change-status/customer-banner', 'MasterController@editStatusCustomerBanner');

    Route::get('admin/profile', 'AdminController@Profile')
        ->name('admin.profile');
    Route::get('admin/edit-profile/{id}', 'AdminController@editProfile')
        ->name('admin.edit_profile');
    Route::post('admin/update-profile/{id}', 'AdminController@updateProfile')
        ->name('admin.update_profile');

    Route::get('admin/settings', 'AdminController@Settings')
        ->name('admin.settings');
    Route::post('admin/settings', 'AdminController@UpdateSettings')
        ->name('admin.update_sas');
    Route::get('admin/working-days', 'AdminController@workingDays')
        ->name('admin.working_days');
    Route::post('admin/working-days', 'AdminController@workingDaysUpdate')
        ->name('admin.update_working_day');

    Route::get('admin/customer-rewards/list', 'CustomerController@listCustomeRewards')
        ->name('admin.customer_rewards');
    Route::get('admin/configure-points', 'AdminController@configurePoints')
        ->name('admin.configure_points');
    Route::post('admin/configure-points/{configure_point_id}', 'AdminController@updateConfigurePoints')
        ->name('admin.store_configure_points');

    //offers
    // list and manage
    Route::get('/admin/offers/list', 'AdminController@listoffer')
        ->name('admin.offers');
    // add offer view
    Route::get('/admin/offer/create', 'AdminController@createoffer')
        ->name('admin.create_offer');
    // store offer
    Route::post('/admin/offer/store', 'AdminController@storeoffer')
        ->name('admin.store_offer');
    // remove offer
    Route::post('/admin/offer/remove/{offer_id}', 'AdminController@removeoffer')
        ->name('admin.destroy_offer');
    // update offer
    Route::post('/admin/offer/update/{offer_id}', 'AdminController@updateoffer')
        ->name('admin.update_offer');
    // edit offer view
    Route::get('/admin/offer/edit/{offer_id}', 'AdminController@editoffer')
        ->name('admin.edit_offer');
    //change status
    Route::get('admin/ajax/change-status/offer', 'AdminController@editStatusoffer');
    Route::get('admin/ajax/get-product-by-category', 'AdminController@GetItemByCategory');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

//logout from other devices
Route::get('logoutOthers', function ()
{
    auth()
        ->logoutOtherDevices('password');
    return redirect('/');
});

// Encryption keys generated successfully.
// Personal access client created successfully.
// Client ID: 1
// Client secret: Raoa8X9Y7eLLctXNy7fp5vlSNw6NDF4gJARA35AT
// Password grant client created successfully.
// Client ID: 2
// Client secret: o8WpPEJpHdVA2ZQ8vawyEF8T37iApuNIZcY5gLfK

