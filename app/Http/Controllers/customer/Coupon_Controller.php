<?php
namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_Coupon;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Trn_Cart;
use App\Models\admin\Trn_WishList;
use App\Models\admin\Mst_Customer;
use App\Models\CustomerPhone;
use App\Models\admin\Trn_OrderItem;
use App\Models\admin\Trn_Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Session\Middleware\StartSession;
use App\Models\admin\Sys_OrderStatus;
use Illuminate\Http\Request;
use PDF;
class Coupon_Controller extends Controller
{

/*
Description : Apply Coupon Details
Date        : 14/4/2022

*/	
   public function apply_couponcart(Request $request)
   {
   	$Code=$request->coupon_code;
   	$p_varientid=$request->id;
   	$loggedin=Auth::guard('customer')->user()->customer_id;
    $customer=Mst_Customer::select('customer_id')->where('customer_id',$loggedin)->first();
    $data=Trn_Cart::with('productVariantData')->where('customer_id',$customer->customer_id)->where('product_variant_id',$p_varientid)->first();
    $Coupon_Price=Mst_Coupon::where('coupon_code',$Code)->first();
    $product_price=$data->productVariantData->variant_price_offer;
   	if(Mst_Coupon::where('coupon_code',$Code)->exists())
   	{
   	  $coupon=Mst_Coupon::where('coupon_code',$Code)->first();
   	  $date=date('Y-m-d');
      if($coupon->valid_from <=$date  && $date <= $coupon->valid_to && $Coupon_Price->min_purchase_amt<=$product_price)
      {
      	$total_price="0";
      	$data=Trn_Cart::with('productVariantData')->where('customer_id',$customer->customer_id)->where('product_variant_id',$p_varientid)->get();
           foreach($data as $value)
           {
           	  $quantity=$value->quantity;
           	  $variant_price_offer=$value->productVariantData->variant_price_offer;
              $total_price=$quantity * $variant_price_offer;
           }

           if($coupon->discount_type== "1")
           {
              $discount_price=$coupon->discount;
           }
           elseif($coupon->discount_type== "2")
           {
              $discount_price=($total_price / 100) * $coupon->discount;
           }
           $grand_total=$total_price-$discount_price;
           return response()->json([
   			'discount_price'=>$discount_price,
   			'total_price'=>$grand_total
   		]);
      }
      else
      {
         return response()->json([
   			'status'=>'Coupon Code has been Expired.',
   			'error_status'=>'error'
   		]);
      }
   	}
   	else
   	{
   		return response()->json([
   			'status'=>'Coupon Code does not exists.',
   			'error_status'=>'error'
   		]);
   	}
   }
}

