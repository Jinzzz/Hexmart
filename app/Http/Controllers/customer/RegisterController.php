<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_Customer;
use DB;
use Auth;
use Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;

use Illuminate\Session\Middleware\StartSession;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    Description : Customer Register Page
    Date        : 31/3/2022
    
    */

    public function register()
    {
     return view('customer.register.list');  
    }

    /*
    Description : Customer Register data stored for mst_cust table
    Date        : 31/3/2022
    
    */

    public function cust_register(Request $request)
    {
      // dd($request->name);
      $request->validate([
            'name' => 'required|string|max:255',
            'customer_email' =>'required|string|email|max:255|unique:mst__customers',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);

        $user = Mst_Customer::create([
            'customer_name' => $request->name,
            'customer_email' => $request->customer_email,
            'password' => Hash::make($request->password),
        ]);

        // event(new Registered($user));

        // Auth::guard('customer')->login($user);

        return redirect(RouteServiceProvider::CUSTOMER_HOME);
    }
}
