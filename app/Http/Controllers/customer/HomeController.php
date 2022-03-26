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
use Request;

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
   Description : Product categorywise data listing 
   Date        : 25/3/2022

*/
    public function productlist($name)
    {
    $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id','category_name_slug','category_name','category_icon','category_description'
    )->where('is_active', 1)->limit(5)->get();
    $category=Mst_ItemCategory::where('category_name',$name)->first();
    $product=Mst_Product::with('itemCategoryData')->where('item_category_id',$category->item_category_id)->get();
    foreach ($product as $val) {
        $data[]=[ $val->product_id];
    }
    if(Request::get('sort')=='price_newest')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('created_at','desc')->get();
    }
    elseif(Request::get('sort')=='price_asc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('variant_price_offer','asc')->get();
    }
    elseif(Request::get('sort')=='price_dsc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('variant_price_offer','desc')->get();
    }
    elseif(Request::get('sort')=='price_popularity')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->where('is_active',1)->get();
    }
    else
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->get();

    }

     return view('customer.product.productlist',compact('navCategoryDetails','product','product_varient'));
    }

/*
   Description : Product sub-categorywise data listing 
   Date        : 25/3/2022

*/
    public function productcatlist($name,$catname)
    {
    $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id','category_name_slug','category_name','category_icon','category_description'
    )->where('is_active', 1)->limit(5)->get();
    $category=Mst_ItemCategory::where('category_name',$catname)->first();
    $sub_category=Mst_ItemSubCategory::where('item_category_id',$category->item_category_id)->first();
    $product=Mst_Product::with('itemCategoryData')->where('item_category_id',$category->item_category_id)->where('item_sub_category_id',$sub_category->item_sub_category_id)->get();
    if($product->isEmpty())
    {
       return view('customer.product.notfount',compact('navCategoryDetails'));
    }
    else
    {
    
     foreach ($product as $val) {
        $data[]=[ $val->product_name];
    }
    if(Request::get('sort')=='price_newest')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('created_at','desc')->get();

    }
    elseif(Request::get('sort')=='price_asc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','asc')->get();

    }
    elseif(Request::get('sort')=='price_dsc')
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','desc')->get();

    }
    elseif(Request::get('sort')=='price_popularity')
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->where('is_active',1)->get();

    }
    else
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->get();

    }

     return view('customer.product.productcat1',compact('navCategoryDetails','product','product_varient'));

    }
     
    }  

/*
   Description : Product mainsub-categorywise data listing 
   Date        : 25/3/2022

*/
    public function mainsubcatgeory($name,$catname,$mainsubcat)
    {
    $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id','category_name_slug','category_name','category_icon','category_description'
    )->where('is_active', 1)->limit(5)->get();
    $category=Mst_ItemCategory::where('category_name',$catname)->first();
    $sub_category=Mst_ItemSubCategory::where('item_category_id',$category->item_category_id)->first();
    $mainsub_category=Mst_ItemLevelTwoSubCategory::where('item_sub_category_id',$sub_category->item_sub_category_id)->first();
    $product=Mst_Product::with('itemCategoryData')->where('item_category_id',$category->item_category_id)->where('item_sub_category_id',$sub_category->item_sub_category_id)->where('iltsc_id',$mainsub_category->iltsc_id)->get();
    
     if($product->isEmpty())
    {
       return view('customer.product.notfount',compact('navCategoryDetails'));
    }
    else
    {
    
     foreach ($product as $val) {
        $data[]=[ $val->product_name];
    }

    if(Request::get('sort')=='price_newest')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('created_at','desc')->get();

    }
    elseif(Request::get('sort')=='price_asc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','asc')->get();

    }
    elseif(Request::get('sort')=='price_dsc')
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','desc')->get();

    }
    elseif(Request::get('sort')=='price_popularity')
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->where('is_active',1)->get();

    }
    else
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->get();

    }

     return view('customer.product.productcat2',compact('navCategoryDetails','product','product_varient'));

    }
    }  

}
