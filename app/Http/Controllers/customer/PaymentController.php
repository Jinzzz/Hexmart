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
use App\Models\admin\Trn_WishList;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Sys_PaymentType;
use App\Models\admin\Trn_Order;
use App\Models\admin\Trn_OrderItem;
use App\Models\CustomerPhone;
use Auth;
use Illuminate\Session\Middleware\StartSession;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : Order Payment details
    Date        : 4/4/2022
    
    */
    public function order_payment($id)
    {
        $loggedin=Auth::guard('customer')->user()->customer_id;
        $customer=Mst_Customer::where('customer_id',$loggedin)->first();
        $product=Mst_ProductVariant::where('product_variant_id',$id)->first();
        $count=Mst_ProductVariant::where('product_variant_id',$id)->count();
        $total_price=$product->variant_price_offer;
        $payment_type=Sys_PaymentType::select('payment_type','payment_type_id')->get();
        return view('customer.payment.list',compact('customer','count','total_price','payment_type','product'));
    }

     /*
    Description : Payment store datas details
    Date        : 4/4/2022
    
    */
    public function Payment_Store(Request $request)
    {
        $customer=Mst_Customer::where('customer_id',$request->customer_id)->first();
        $product = Trn_Cart::with('productVariantData')->where('customer_id', $customer->customer_id)->where('product_variant_id', $request->p_id)->first(); 
        $order = new Trn_Order();
                $order->customer_id=$customer->customer_id;
                $order->payment_type_id = $request->Payment;
                $order->order_total_amount = $product->productVariantData->variant_price_offer;
                $order->save();
        $orderid=Trn_Order::where('order_id',$order->order_id)->first();
        $trm_order = new Trn_OrderItem();
                $trm_order->customer_id=$customer->customer_id;
                $trm_order->order_id = $orderid->order_id;
                $trm_order->quantity = $product->quantity;
                $trm_order->product_id=$product->productVariantData->product_id;
                $trm_order->product_variant_id = $product->productVariantData->product_variant_id;
                $trm_order->total_amount = $product->productVariantData->variant_price_offer;
                $trm_order->save();
        //continue to payment after delete the cart table entry
        $cart_delete = Trn_Cart::where('customer_id', $customer->customer_id)->where('product_variant_id', $request->p_id)->delete();         
        return redirect()->route('customer.home');

    }
   

}

