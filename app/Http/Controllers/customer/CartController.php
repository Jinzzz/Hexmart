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
use App\Models\admin\Trn_Cart;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /*
    Description : Add to cart details
    Date        : 29/3/2022
    
    */

    public function addcart(Request $request)
    {
        $id = $request->product_id;
        $product_check = Mst_ProductVariant::where('product_variant_id', $id)->first();
        // if (Auth::check())
        // {
            if (Trn_Cart::where('product_variant_id', $id)->exists())
            {
                return response()->json(['status' => ucfirst($product_check->variant_name) . " " . "Already Added To Cart"]);

            }
            else
            {
                $cart = new Trn_Cart();
                // $cart->customer_id=Auth::user()->id;
                $cart->product_variant_id = $id;
                $cart->quantity = 1;
                $cart->save();
                return response()->json(['status' => ucfirst($product_check->variant_name) . " " . "Added To Cart"]);
            }
        // }
        // else
        // {
        //     return response()->json(['status' => "Login to Continue"]);
        // }
    }

    /*
    Description : Add to cart listing for logged in users
    Date        : 29/3/2022
    
    */

    public function show_Cart()
    {
        // dd(Auth::guard('customers')->user()->name);
        if(Auth::guard('customer')->check())
        {
        $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
        $cart = Trn_Cart::with('productVariantData')->where('customer_id', Auth::user()->id)->get();
        // dd($cart);
        return view('customer.cart.list', compact('navCategoryDetails', 'cart'));
        }
        else
        {
        return redirect()->route('customerlogin');

        }
       
    }



}

