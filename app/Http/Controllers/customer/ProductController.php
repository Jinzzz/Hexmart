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

class ProductController extends Controller
{
/*
   Description : Product categorywise data listing 
   Date        : 25/3/2022

*/
    public function productlist($name)
    {
    $pageination=4;
    $navCategoryDetails  = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id','category_name_slug','category_name','category_icon','category_description'
    )->where('is_active', 1)->limit(5)->get();
    $category=Mst_ItemCategory::where('category_name',$name)->first();
    $product=Mst_Product::with('itemCategoryData')->where('item_category_id',$category->item_category_id)->get();
    foreach ($product as $val) {
        $data[]=[ $val->product_id];
    }
    if(Request::get('sort')=='price_newest')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('created_at','desc')->paginate($pageination);
    }
    elseif(Request::get('sort')=='price_asc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('variant_price_offer','asc')->paginate($pageination);
    }
    elseif(Request::get('sort')=='price_dsc')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->orderBy('variant_price_offer','desc')->paginate($pageination);
    }
    elseif(Request::get('sort')=='price_popularity')
    {
     $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->where('is_active',1)->paginate($pageination);
    }
    else
    {
    $product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('product_id',$data)->take(2)->paginate($pageination);

    }

     return view('customer.product.productlist',compact('navCategoryDetails','product','product_varient'));
    }

/*
   Description : Product sub-categorywise data listing 
   Date        : 25/3/2022

*/
    public function productcatlist($name,$catname)
    {
    $pageinationval=4;
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
     $subcat_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('created_at','desc')->paginate($pageinationval);

    }
    elseif(Request::get('sort')=='price_asc')
    {
     $subcat_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','asc')->paginate($pageinationval);

    }
    elseif(Request::get('sort')=='price_dsc')
    {
    $subcat_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','desc')->paginate($pageinationval);

    }
    elseif(Request::get('sort')=='price_popularity')
    {
    $subcat_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->where('is_active',1)->paginate($pageinationval);

    }
    else
    {
    $subcat_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->take(2)->paginate($pageinationval);

    }

     return view('customer.product.productcat1',compact('navCategoryDetails','product','subcat_product_varient'));

    }
     
    }  

/*
   Description : Product mainsub-categorywise data listing 
   Date        : 25/3/2022

*/
    public function mainsubcatgeory($name,$catname,$mainsubcat)
    {
    $main_pageinationval=4;    
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
     $mainsub_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('created_at','desc')->paginate($main_pageinationval);

    }
    elseif(Request::get('sort')=='price_asc')
    {
     $mainsub_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','asc')->paginate($main_pageinationval);

    }
    elseif(Request::get('sort')=='price_dsc')
    {
    $mainsub_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->orderBy('variant_price_offer','desc')->paginate($main_pageinationval);

    }
    elseif(Request::get('sort')=='price_popularity')
    {
    $mainsub_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->where('is_active',1)->paginate($main_pageinationval);

    }
    else
    {
    $mainsub_product_varient=Mst_ProductVariant::with('Productvarients')->whereIn('variant_name',$data)->take(2)->paginate($main_pageinationval);

    }

     return view('customer.product.productcat2',compact('navCategoryDetails','product','mainsub_product_varient'));

    }
    }  

}
