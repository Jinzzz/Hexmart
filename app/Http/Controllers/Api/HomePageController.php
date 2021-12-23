<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_Product;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use stdClass;

class HomePageController extends Controller
{
    public function homePage(Request $request) // cancel status is not correct
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {

                $bannerDetails  = Mst_CustomerBanner::select(
                    'customer_banner_id',
                    'customer_banner',
                    'is_default',
                    'is_active'
                )
                    ->where('is_active', 1)
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('customer_banner_id', 'DESC')
                    ->get();

                foreach ($bannerDetails as $c) {
                    if (isset($c->customer_banner))
                        $c->customer_banner = '/assets/uploads/customer_banners/' . $c->customer_banner;
                }

                $data['bannerDetails'] = $bannerDetails;

                $categoryDetails  = Mst_ItemCategory::select(
                    'item_category_id',
                    'category_name',
                    'category_icon',
                    'category_description'
                )
                    ->where('is_active', 1)
                    ->orderBy('category_name', 'ASC')->get();

                foreach ($categoryDetails as $c) {
                    if (isset($c->category_icon))
                        $c->category_icon = '/assets/uploads/category_icon/' . $c->category_icon;
                    else
                        $c->category_icon = Helper::categoryIcon();
                }

                $data['categoryDetails'] = $categoryDetails;


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

                foreach ($offerDetails as $c) {
                    $c->variant_name = $c->productVariantData->variant_name;
                    $c->product_name = $c->productVariantData->productData->product_name;
                    // $c->productData = $c->productVariantData->productData;
                }

                $data['offerDetails'] = $offerDetails;


                $recentAddedProducts  = Mst_Product::join('mst__product_variants', 'mst__product_variants.product_id', '=', 'mst__products.product_id')
                    ->select(
                        'mst__products.product_id',
                        'mst__products.product_name',
                        'mst__products.product_code',
                        'mst__product_variants.product_variant_id',
                        'mst__product_variants.variant_name',
                        'mst__product_variants.variant_price_regular',
                        'mst__product_variants.variant_price_offer',
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
                    $recentAddedProducts = $recentAddedProducts->limit(10);
                }

                $recentAddedProducts = $recentAddedProducts->get();

                foreach ($recentAddedProducts as $c) {

                    if (Helper::isOfferAvailable($c->product_variant_id)) {
                        $c->isOfferAvailable  = 1;
                        $c->offerData  = Helper::isOfferAvailable($c->product_variant_id);
                    } else {
                        $c->isOfferAvailable  = 0;
                        $c->offerData  = new stdClass();;
                    }


                    $c->productBaseImage  = Helper::productBaseImage($c->product_id);
                    $c->productVariantBaseImage  = Helper::productVarBaseImage($c->product_id, $c->product_variant_id);
                    $c->proVarAttributes  = Helper::variantArrtibutes($c->product_variant_id);
                    $c->proVarImages  = Helper::variantImages($c->product_variant_id);
                }

                $data['recentAddedProducts'] = $recentAddedProducts;
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer not found ";
            }
            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        }
    }
}
