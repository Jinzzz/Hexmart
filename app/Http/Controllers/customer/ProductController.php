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
use App\Models\admin\Mst_CustomerGroup;
use App\Models\admin\Mst_Brand;
use App\Models\admin\Mst_AttributeGroup;
use DB;
use Request;

class ProductController extends Controller
{
    /*
    Description : Product categorywise data listing
    Date        : 25/3/2022
    
    */
    public function productlist($name)
    {
        $minval=isset($_GET['min']) ? $_GET['min'] : '0';
        $maxval=isset($_GET['max']) ? $_GET['max'] : '1000000';
        $pageination = 4;
        $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
        $category = Mst_ItemCategory::where('category_name', $name)->first();
        $brand_datas=[];
        $brand_table=DB::table('mst__products')->where('item_category_id',$category->item_category_id)->get();

        foreach ($brand_table as $val) {
        $brand_ids=$val->brand_id;
        $brand_datas[] = (array)$brand_ids;  
        }
        $brands=isset($_GET['brand']) ? $_GET['brand'] : $brand_datas;




        // $attribute_datas=[];
        // $attribute_table=Mst_Product::with('attribute_group')->where('item_category_id',$category->item_category_id)->get();

        // foreach ($attribute_table as $val) {
        // $brand_ids=$val->product_id;
        // $attribute_datas[] = (array)$brand_ids;  
        // }
        // $attribute=isset($_GET['attribute']) ? $_GET['attribute'] : '';

        // dd($attribute_table);



        $product = Mst_Product::with('itemCategoryData')->whereIn('brand_id',$brands)->where('item_category_id', $category->item_category_id)->get();
        $brand = Mst_Brand::where('is_active', 1)->get();
        $attribute = Mst_AttributeGroup::where('is_active', 1)->get();
        if ($product->isEmpty())
        {
            return view('customer.product.notfount', compact('navCategoryDetails'));
        }
        else
        {
        foreach ($product as $val)
        {
            $data[] = [$val->product_id];
        }
        if (Request::get('sort') == 'price_newest')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$minval, $maxval])->orderBy('created_at', 'desc')->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('created_at', 'desc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('created_at', 'desc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_asc')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$minval, $maxval])->orderBy('variant_price_offer', 'asc')->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'asc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'asc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_dsc')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$minval, $maxval])->orderBy('variant_price_offer', 'desc')->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'desc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'desc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_popularity')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$minval, $maxval])->where('is_active', 1)->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->where('is_active', 1)->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->where('is_active', 1)->max('variant_price_offer');
        }
        else
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_name', 'asc')->whereBetween('variant_price_offer', [$minval, $maxval])->take(2)->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->max('variant_price_offer');

        }

        return view('customer.product.productlist', compact('navCategoryDetails', 'product', 'product_varient','min','max','name','brand','attribute'));
     }
    }

    /*
    Description : Product sub-categorywise data listing
    Date        : 25/3/2022
    
    */
    public function productcatlist($name, $catname)
    {
        $minvalue=isset($_GET['min']) ? $_GET['min'] : '0';
        $maxvalue=isset($_GET['max']) ? $_GET['max'] : '1000000';
        $pageinationval = 2;
        $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
        $category = Mst_ItemCategory::where('category_name', $catname)->first();
        $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
            ->first();
        $brand_datas=[];
        $brand_table=DB::table('mst__products')->where('item_category_id',$category->item_category_id)->get();
        foreach ($brand_table as $val) {
        $brand_ids=$val->brand_id;
        $brand_datas[] = (array)$brand_ids;  
        }
        $brandvalues=isset($_GET['brand']) ? $_GET['brand'] : $brand_datas;  
        $product = Mst_Product::with('itemCategoryData')->whereIn('brand_id',$brandvalues)->where('item_category_id', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->get();
        $brand = Mst_Brand::where('is_active', 1)->get();
        $attribute = Mst_AttributeGroup::where('is_active', 1)->get();
        if ($product->isEmpty())
        {
            return view('customer.product.notfount', compact('navCategoryDetails'));
        }
        else
        {

            foreach ($product as $val)
            {
                $data[] = [$val->product_name];
            }
            if (Request::get('sort') == 'price_newest')
            {
                $subcat_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$minvalue, $maxvalue])->orderBy('created_at', 'desc') ->paginate($pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('created_at', 'desc') ->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('created_at', 'desc') ->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_asc')
            {
                $subcat_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$minvalue, $maxvalue])->orderBy('variant_price_offer', 'asc') ->paginate($pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'asc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'asc')->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_dsc')
            {
                $subcat_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$minvalue, $maxvalue])->orderBy('variant_price_offer', 'desc') ->paginate($pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'desc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'desc')->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_popularity')
            {
                $subcat_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$minvalue, $maxvalue])->where('is_active', 1) ->paginate($pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->where('is_active', 1)->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->where('is_active', 1)->max('variant_price_offer');

            }
            else
            {
                $subcat_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$minvalue, $maxvalue])->orderBy('variant_name', 'asc')->take(2)->paginate($pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->max('variant_price_offer');
            }

            return view('customer.product.productcat1', compact('navCategoryDetails', 'product', 'subcat_product_varient','min','max','name','catname','brand','attribute'));

        }

    }

    /*
    Description : Product mainsub-categorywise data listing
    Date        : 25/3/2022
    
    */
    public function mainsubcatgeory($name, $catname, $mainsubcat)
    {
        $min_price=isset($_GET['min']) ? $_GET['min'] : '0';
        $max_price=isset($_GET['max']) ? $_GET['max'] : '1000000';
        $main_pageinationval = 1;
        $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
        $category = Mst_ItemCategory::where('category_name', $catname)->first();
        $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
            ->first();
        $mainsub_category = Mst_ItemLevelTwoSubCategory::where('item_sub_category_id', $sub_category->item_sub_category_id)
            ->first();
        $brand_datas=[];
        $brand_table=DB::table('mst__products')->where('item_category_id',$category->item_category_id)->get();
        foreach ($brand_table as $val) {
        $brand_ids=$val->brand_id;
        $brand_datas[] = (array)$brand_ids;  
        }
        $brandvalues=isset($_GET['brand']) ? $_GET['brand'] : $brand_datas;     
        $product = Mst_Product::with('itemCategoryData')->whereIn('brand_id',$brandvalues)->where('item_category_id', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->where('iltsc_id', $mainsub_category->iltsc_id)->get();
        $brand = Mst_Brand::where('is_active', 1)->get();
        $attribute = Mst_AttributeGroup::where('is_active', 1)->get();

        if ($product->isEmpty())
        {
            return view('customer.product.notfount', compact('navCategoryDetails'));
        }
        else
        {

            foreach ($product as $val)
            {
                $data[] = [$val->product_name];
            }

            if (Request::get('sort') == 'price_newest')
            {
                $mainsub_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$min_price, $max_price])->orderBy('created_at', 'desc')->paginate($main_pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('created_at', 'desc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('created_at', 'desc')->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_asc')
            {
                $mainsub_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$min_price, $max_price])->orderBy('variant_price_offer', 'asc')->paginate($main_pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'asc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'asc')->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_dsc')
            {
                $mainsub_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$min_price, $max_price])->orderBy('variant_price_offer', 'desc')->paginate($main_pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'desc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_price_offer', 'desc')->max('variant_price_offer');

            }
            elseif (Request::get('sort') == 'price_popularity')
            {
                $mainsub_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$min_price, $max_price])->where('is_active', 1)->paginate($main_pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->where('is_active', 1)->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->where('is_active', 1)->max('variant_price_offer');

            }
            else
            {
                $mainsub_product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->whereBetween('variant_price_offer', [$min_price, $max_price])->orderBy('variant_name', 'asc')->take(2)->paginate($main_pageinationval);
                $min = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_name', 'asc')->min('variant_price_offer');
                $max = Mst_ProductVariant::with('Productvarients')->whereIn('variant_name', $data)->orderBy('variant_name', 'asc')->max('variant_price_offer');

            }

            return view('customer.product.productcat2', compact('navCategoryDetails', 'product', 'mainsub_product_varient','min','max','name','catname','mainsubcat','brand','attribute'));

        }
    }
    
    /*
    Description : Product detail page
    Date        : 28/3/2022
    
    */

    public function productdetail($name,$catname)
    {
       $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
       $product = Mst_ProductVariant::take(4)->orderBy('created_at','desc')->get();
       $category = Mst_ItemCategory::where('category_name', $name)->first();
       $product_Category = Mst_Product::with('itemCategoryData')->where('item_category_id', $category->item_category_id)->where('product_name', $catname)->first();
       $product_varient = Mst_ProductVariant::with('Productvarients')->where('variant_name',$catname)->where('is_active', 1)->first();
       return view('customer.product.productdetail',compact('navCategoryDetails','product','product_varient'));
    }

    /*
    Description : Product Sub category detail page
    Date        : 28/3/2022
    
    */

    public function productsubdetail($name,$catname,$variant_name)
    {
       $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
       $product = Mst_ProductVariant::take(4)->orderBy('created_at','desc')->get();
       $category = Mst_ItemCategory::where('category_name', $catname)->first();
       $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
            ->first();
       $product_Category = Mst_Product::with('itemCategoryData')->where('item_category_id', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->where('product_name', $variant_name)->first();
       $product_varient = Mst_ProductVariant::with('Productvarients')->where('variant_name',$variant_name)->where('is_active', 1)->first();
       return view('customer.product.productsubcatdetail',compact('navCategoryDetails','product','product_varient'));
    }


    /*
    Description : Product Main-Sub category detail page
    Date        : 28/3/2022
    
    */

    public function productmainsubdetail($name,$catname,$variant_name,$mainsub)
    {
       $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
       $product = Mst_ProductVariant::take(4)->orderBy('created_at','desc')->get();
       $category = Mst_ItemCategory::where('category_name', $catname)->first();
       $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
            ->first();
       $mainsub_category = Mst_ItemLevelTwoSubCategory::where('item_sub_category_id', $sub_category->item_sub_category_id)
            ->first();   
       $product_Category = Mst_Product::with('itemCategoryData')->where('item_category_id', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->where('iltsc_id', $mainsub_category->iltsc_id)->where('product_name', $variant_name)->first();
       $product_varient = Mst_ProductVariant::with('Productvarients')->where('variant_name',$variant_name)->where('is_active', 1)->first();
       return view('customer.product.productsubcatdetail',compact('navCategoryDetails','product','product_varient'));
    }

}

