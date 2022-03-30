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
use Auth;
use Illuminate\Session\Middleware\StartSession;

use Illuminate\Http\Request;

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


    public function customerlogin()
    {
       return view('customer.login');
    }

    public function dashboard()
    {
       
        dd(Auth::guard('customer')->user());
        return view('customer.login.dashboard');
    }

}
