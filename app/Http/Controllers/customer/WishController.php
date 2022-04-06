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
use Auth;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request;

class WishController extends Controller
{
    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : Wish listing
    Date        : 6/4/2022
    
    */
    public function wishlist()
    {
        $id=Auth::guard('customer')->user()->customer_id;
        $wish_list=Trn_WishList::with('productVariantData')->where('customer_id',$id)->get();
        return view('customer.wishlist',compact('wish_list'));
    }
    /*
    Description : Remove Wish listing
    Date        : 6/4/2022
    
    */
    public function Remove_wishlist($id)
    {
        $list=Trn_WishList::where('wish_list_id', $id)->delete();
        return redirect()->back();
    }
}    