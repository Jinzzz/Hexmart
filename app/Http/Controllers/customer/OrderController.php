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
use App\Models\admin\Trn_Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Session\Middleware\StartSession;
use App\Models\admin\Sys_OrderStatus;
use Illuminate\Http\Request;
use PDF;
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
       if(!empty($request->input('status')))
       {
       $datefrom = $request->from_date;
       $dateto = $request->to_date;
       $status=$request->status;
       $a1 = Carbon::parse($datefrom)->startOfDay();
       $a2 = Carbon::parse($dateto)->endOfDay();
       $id=Auth::guard('customer')->user()->customer_id;
       $order=Trn_OrderItem::with('orderData')->whereBetween('created_at',[$a1, $a2])->where('order_status_id',$status)->where('customer_id',$id)->orderBy('order_item_id','desc')->get();
       $status=Sys_OrderStatus::get();
       return view('customer.order.list',compact('order','status'));
       } 
       else 
       {
       $id=Auth::guard('customer')->user()->customer_id;
       $order=Trn_OrderItem::with('orderData')->where('customer_id',$id)->orderBy('order_item_id','desc')->get();
       $status=Sys_OrderStatus::get();
       return view('customer.order.list',compact('order','status'));
       }
    }

    /*
    Description : order details
    Date        : 6/4/2022

    */

    public function Order_Details($order_id)
    {
       $id=Auth::guard('customer')->user()->customer_id;
       $order=Trn_OrderItem::with('productVariantData','orderData')->where('customer_id',$id)->where('order_item_id',$order_id)->first();
       // dd($order);
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


    /*
    Description : order Cancel-Confirm details
    Date        : 6/4/2022

    */

    public function order_cancel($id)
    {
       $orderdel=Trn_OrderItem::select('order_id')->where('order_item_id',$id)->first();
       Trn_OrderItem::where('order_id',$orderdel->order_id)->delete();
       $del=Trn_Order::where('order_id',$orderdel->order_id)->delete();
       return redirect()->route('My-Orders');

    }


    /*
    Description : Invoice-order details
    Date        : 7/4/2022

    */

    public function Invoice($id)
    {
       $cust_id=Auth::guard('customer')->user()->customer_id;
       $invoice=Trn_OrderItem::with('productVariantData','customerData','orderData')->where('order_item_id',$id)->where('customer_id',$cust_id)->first();
       $pdf = PDF::loadView('customer.invoice.pdf',compact('invoice'));
       return $pdf->download('Invoice.pdf');

    }

}
