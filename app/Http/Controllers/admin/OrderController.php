<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;
use Hash;
use DB;
use Carbon\Carbon;
use Crypt;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_AttributeGroup;
use App\Models\admin\Mst_AttributeValue;
use App\Models\admin\Mst_Brand;
use App\Models\admin\Mst_Coupon;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_DeliveryBoy;
use App\Models\admin\Mst_Issue;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_Tax;
use App\Models\admin\Mst_Unit;
use App\Models\admin\Sys_IssueType;
use App\Models\admin\Trn_TaxSplit;
use App\Models\admin\Mst_brandsubcat;
use App\Models\admin\Mst_Attributecategory;
use App\Models\admin\Trn_Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewOrder($id=NULL)
    {
        $order=Trn_Order::with(['orderItems','orderItems.productData','orderItems.productVariantData','customerData','orderStatusData','paymentStatusData'])->findOrFail($id);
        //dd($items);
        $pageTitle="View Order";
        return view('admin.elements.order.viewOrder',compact('order','pageTitle'));

    }

}
