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


class PricefilterController extends Controller
{
    /*
    Description : Product categorywise data listing
    Date        : 25/3/2022
    
    */
    public function filterproductlist(Request $request)
    {
        $name=Request::get('name');
        $min=Request::get('min');
        $max=Request::get('max');
        $pageination = 4;
        $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')->where('is_active', 1)->limit(5)->get();
        $category = Mst_ItemCategory::where('category_name', $name)->first();
        $product = Mst_Product::with('itemCategoryData')->where('item_category_id', $category->item_category_id)->get();
        foreach ($product as $val)
        {
            $data[] = [$val->product_id];
        }
        if (Request::get('sort') == 'price_newest')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$min, $max])->orderBy('created_at', 'desc')->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('created_at', 'desc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('created_at', 'desc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_asc')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->whereBetween('variant_price_offer', [$min, $max])->orderBy('variant_price_offer', 'asc')->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'asc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'asc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_dsc')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'desc')->whereBetween('variant_price_offer', [$min, $max])->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'desc')->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_price_offer', 'desc')->max('variant_price_offer');
        }
        elseif (Request::get('sort') == 'price_popularity')
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->where('is_active', 1)->whereBetween('variant_price_offer', [$min, $max])->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->where('is_active', 1)->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->where('is_active', 1)->max('variant_price_offer');
        }
        else
        {
            $product_varient = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->orderBy('variant_name', 'asc')->whereBetween('variant_price_offer', [$min, $max])->take(2)->paginate($pageination);
            $min = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->min('variant_price_offer');
            $max = Mst_ProductVariant::with('Productvarients')->whereIn('product_id', $data)->max('variant_price_offer');

        }
        // return response()->json(['data' =>$product_varient]);

        return view('customer.product.productlist', compact('navCategoryDetails', 'product', 'product_varient','min','max','name'));

    }
}

