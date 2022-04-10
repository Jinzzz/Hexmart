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
use App\Models\admin\Trn_CustomerAddress;

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
      $request->validate([
            'name' => 'required|string|max:255',
            'customer_mobile'=>'required|min:10|numeric|unique:mst__customers',
            'customer_email' =>'required|string|email|max:255|unique:mst__customers',
            'pin'=>'required|numeric',
            'state'=>'required',
            'city'=>'required',
            'place'=>'required',
            'road'=>'required',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);

        $user = Mst_Customer::create([
            'customer_name' => $request->name,
            'customer_email' => $request->customer_email,
            'customer_mobile' => $request->customer_mobile,
            'pin' => $request->pin,
            'state' => $request->state,
            'city' => $request->city,
            'place' => $request->place,
            'road' => $request->road,
            'password' => Hash::make($request->password),
        ]);

        $user_address = Trn_CustomerAddress::create([
            'customer_id' => $user->customer_id,
            'name' => $user->customer_name,
            'phone' => $user->customer_mobile,
            // 'alternative_phone' => $user->pin,
            'pincode' => $user->pin,
            'state' => $user->state,
            'city' => $user->city,
            'house' => $user->place,
            'street' => $user->road,
            'is_default'=>1,
        ]);


        event(new Registered($user));

        Auth::guard('customer')->login($user);

        return redirect(RouteServiceProvider::CUSTOMER_HOME);
    }

     protected function guard()
    {
        return Auth::guard('customer');
    }
}
