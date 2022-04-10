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
use App\Models\admin\Trn_OrderItem;
use App\Models\admin\Trn_CustomerAddress;

use Auth;
use Illuminate\Session\Middleware\StartSession;
use Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function Home(Request $request)
    {
        $sliderBanner = Mst_CustomerBanner::where('is_active', 1)
            ->orderBy('is_default', 'DESC')
            ->orderBy('customer_banner_id', 'DESC')->get();

        $categoryDetails  = Mst_ItemCategory::select(
            'item_category_id',
            'category_name_slug',
            'category_name',
            'category_icon',
            'category_description'
        )
            ->where('is_active', 1)
            ->orderBy('category_name', 'ASC')->limit(5)->get();

        $offerDetails  = Mst_OfferZone::select(
            'product_variant_id',
            'date_start',
            'time_start',
            'date_end',
            'time_end',
            'offer_price'
        )
            ->where('is_active', 1)
            ->orderBy('offer_id', 'DESC')
            ->get();

        $recentAddedProducts  = Mst_Product::join('mst__product_variants', 'mst__product_variants.product_id', '=', 'mst__products.product_id')
            ->select(
                'mst__products.product_id',
                'mst__products.product_name',
                'mst__products.product_name_slug',
                'mst__products.product_code',
                'mst__product_variants.product_variant_id',
                'mst__product_variants.variant_name',
                'mst__product_variants.variant_name_slug',
                'mst__product_variants.variant_price_regular',
                'mst__product_variants.variant_price_offer',
                'mst__product_variants.stock_count',
            )
            ->where('mst__product_variants.stock_count', '>', 0)
            ->where('mst__products.is_active', 1)
            ->where('mst__product_variants.is_active', 1)
            ->orderBy('mst__product_variants.product_variant_id', 'DESC');

        if ($request->recent_products_limit) {
            $recentAddedProducts = $recentAddedProducts->limit($request->recent_products_limit);
        } else {
            $recentAddedProducts = $recentAddedProducts->limit(8);
        }

        $recentAddedProducts = $recentAddedProducts->get();

        // header items

        $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select(
            'item_category_id',
            'category_name_slug',
            'category_name',
            'category_icon',
            'category_description'
        )
            ->where('is_active', 1)
            //->orderBy('category_name', 'ASC')
            ->limit(5)->get();


        return view('customer.home', compact(
            'sliderBanner',
            'categoryDetails',
            'navCategoryDetails',
            'offerDetails',
            'recentAddedProducts',
            'recentAddedProducts'
        ));
    }

    /*
    Description : Customer Dashboard
    Date        : 30/3/2022
    
    */
    public function dashboard(Request $request)
    {
       
        $name=Auth::guard('customer')->user()->customer_name;
        $sliderBanner = Mst_CustomerBanner::where('is_active', 1)
            ->orderBy('is_default', 'DESC')
            ->orderBy('customer_banner_id', 'DESC')->get();

        $categoryDetails  = Mst_ItemCategory::select(
            'item_category_id',
            'category_name_slug',
            'category_name',
            'category_icon',
            'category_description'
        )
            ->where('is_active', 1)
            ->orderBy('category_name', 'ASC')->limit(5)->get();

        $offerDetails  = Mst_OfferZone::select(
            'product_variant_id',
            'date_start',
            'time_start',
            'date_end',
            'time_end',
            'offer_price'
        )
            ->where('is_active', 1)
            ->orderBy('offer_id', 'DESC')
            ->get();

        $recentAddedProducts  = Mst_Product::join('mst__product_variants', 'mst__product_variants.product_id', '=', 'mst__products.product_id')
            ->select(
                'mst__products.product_id',
                'mst__products.product_name',
                'mst__products.product_name_slug',
                'mst__products.product_code',
                'mst__product_variants.product_variant_id',
                'mst__product_variants.variant_name',
                'mst__product_variants.variant_name_slug',
                'mst__product_variants.variant_price_regular',
                'mst__product_variants.variant_price_offer',
                'mst__product_variants.stock_count',
            )
            ->where('mst__product_variants.stock_count', '>', 0)
            ->where('mst__products.is_active', 1)
            ->where('mst__product_variants.is_active', 1)
            ->orderBy('mst__product_variants.product_variant_id', 'DESC');

        if ($request->recent_products_limit) {
            $recentAddedProducts = $recentAddedProducts->limit($request->recent_products_limit);
        } else {
            $recentAddedProducts = $recentAddedProducts->limit(8);
        }

        $recentAddedProducts = $recentAddedProducts->get();

        // header items

        $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select(
            'item_category_id',
            'category_name_slug',
            'category_name',
            'category_icon',
            'category_description'
        )
            ->where('is_active', 1)
            //->orderBy('category_name', 'ASC')
            ->limit(5)->get();


        return view('customer.login.dashboard', compact(
            'sliderBanner',
            'categoryDetails',
            'navCategoryDetails',
            'offerDetails',
            'recentAddedProducts',
            'recentAddedProducts',
            'name',
        ));
    }
    /*
    Description : Guard Details
    Date        : 29/3/2022
    
    */
    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : My-Account Details
    Date        : 5/4/2022
    
    */
     public function My_Account()
    {
        $id=Auth::guard('customer')->user()->customer_id;
        $user_details=Mst_Customer::where('customer_id',$id)->first();
        $order=Trn_OrderItem::select('created_at')->where('customer_id',$id)->orderBy('created_at','desc')->first();
        return view('customer.myaccount.list',compact('user_details','order'));
    }

    /*
    Description : My-Account-Edit Details
    Date        : 5/4/2022
    
    */
     public function My_Accountedit()
    {
        $id=Auth::guard('customer')->user()->customer_id;
        $user_details=Mst_Customer::where('customer_id',$id)->first();
        return view('customer.myaccount.edit',compact('user_details'));
    }


    /*
    Description : My-Account-Address Details
    Date        : 5/4/2022
    
    */
     public function My_Account_address()
    {
        $id=Auth::guard('customer')->user()->customer_id;
        $customer=Mst_Customer::where('customer_id',$id)->first();
        $address=Trn_CustomerAddress::where('customer_id',$customer->customer_id)->where('is_default',1)->first();
        $secondaryaddress=Trn_CustomerAddress::where('customer_id',$customer->customer_id)->where('is_default',0)->get(); 
        return view('customer.myaccount.address',compact('customer','address','secondaryaddress'));
    }

    /*
    Description : Secondary-Address Details
    Date        : 5/4/2022
    
    */
     public function Add_Addressdetails()
    {
        
        return view('customer.myaccount.add-address');
    }


    /*
    Description : Secondary-Address-Update Details
    Date        : 5/4/2022
    
    */
     public function Update_Address($id)
    {
        
        dd($id);
    }


    /*
    Description : Secondary-Address-update Details
    Date        : 5/4/2022
    
    */
     public function Edit_Address()
    {
        
        return view('customer.myaccount.edit-address');
    }

    /*
    Description : Secondary-Address-create Details
    Date        : 5/4/2022
    
    */
     public function Store_Address(Request $request)
    {
        // dd($request);
        $id=Auth::guard('customer')->user()->customer_id;
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_mobile'=>'required|min:10|numeric|unique:mst__customers',
            'pin'=>'required|numeric',
            'state'=>'required',
            'city'=>'required',
            'place'=>'required',
            'road'=>'required',
        ]);

         $user = Trn_CustomerAddress::create([
            'customer_id'=>$id,
            'name' => $request->name,
            'phone' => $request->customer_mobile,
            'pincode' => $request->pin,
            'state' => $request->state,
            'city' => $request->city,
            'house' => $request->place,
            'street' => $request->road,
            'is_default' => 0,
        ]);

         return redirect()->route('My_Account_address');

    }


    /*
    Description : Add-Address Details
    Date        : 5/4/2022
    
    */
     public function Add_Address()
    {
        return view('customer.myaccount.add_address');
    }


    /*
    Description : Account-update Details
    Date        : 5/4/2022
    
    */
     public function Account_Update(Request $request)
    {
        $customer = Mst_Customer::find($request->id);
        if($request->password=="")
        {
            $password=$customer->password;        
        }
        else
        {
          $password=Hash::make($request->password);
        }
        $customer->customer_name = $request->name;
        $customer->customer_mobile = $request->mobile;
        $customer->customer_email = $request->email;
        $customer->password = $password;

        $customer->update();
        return redirect()->route('My-Account');
    }

}
