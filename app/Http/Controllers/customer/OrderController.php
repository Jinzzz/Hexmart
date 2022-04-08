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
use App\Models\CustomerPhone;
use App\Models\admin\Trn_OrderItem;
use Auth;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : order details list
    Date        : 6/4/2022
    
    */

    public function My_Orders(Request $request)
    {
       $id=Auth::guard('customer')->user()->customer_id;
       $order=Trn_OrderItem::where('customer_id',$id)->orderBy('order_item_id','desc')->get();
       return view('customer.order.list',compact('order'));

    }

    /*
    Description : order details
    Date        : 6/4/2022
    
    */

    public function Order_Details($order_id)
    {
       $id=Auth::guard('customer')->user()->customer_id;
       $order=Trn_OrderItem::with('productVariantData')->where('customer_id',$id)->where('order_item_id',$order_id)->first();
       return view('customer.order.order_details',compact('order'));

    }

    /*
    Description : order confirm details
    Date        : 6/4/2022
    
    */

    public function order_confirm()
    {
       $id=Auth::guard('customer')->user()->customer_id;
       $name=Auth::guard('customer')->user()->customer_name;
       $order=Trn_OrderItem::select('order_number')->where('customer_id',$id)->orderBy('order_item_id','desc')->first();
       return view('customer.order.order_confirmdetails',compact('order','name'));

    }

}     	