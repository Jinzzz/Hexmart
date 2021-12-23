<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\admin\Mst_Brand;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_OfferZone;
use Illuminate\Http\Request;

class MasterController extends Controller
{



    public function listBrand(Request $request)
    {
        $data = array();

        try {

            $brandDetails  = Mst_Brand::select(
                'brand_id',
                'brand_name',
                'brand_icon',
                'is_active'
            )
                ->where('is_active', 1)
                ->orderBy('brand_name', 'ASC')
                ->get();

            foreach ($brandDetails as $c) {
                if (isset($c->brand_icon)) {
                    $c->brand_icon = '/assets/uploads/brand_icon/' . $c->brand_icon;
                } else {
                    $c->brand_icon = Helper::brandIcon();
                }
            }

            $data['brandDetails'] = $brandDetails;
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }


    public function listOfferProducts(Request $request)
    {
        $data = array();

        try {

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
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }



    public function listBanner(Request $request)
    {
        $data = array();

        try {

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
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }


    public function listAllCategory(Request $request)
    {
        $data = array();

        try {

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
                $c->subCategoryLevOne  = Helper::subCategoryLevOne($c->item_category_id);
            }

            $data['categoryDetails'] = $categoryDetails;
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }


    public function listCategory(Request $request)
    {
        $data = array();

        try {

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
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }


    public function listSubCategoryLevOne(Request $request)
    {
        $data = array();
        try {

            $subCatLevOneDetails = Mst_ItemSubCategory::select(
                'item_sub_category_id',
                'item_category_id',
                'sub_category_name',
                'sub_category_icon',
                'sub_category_description',
            )

                ->where('is_active', 1)
                ->orderBy('sub_category_name', 'ASC');

            if ($request->item_category_id)
                $subCatLevOneDetails = $subCatLevOneDetails->where('item_category_id', $request->item_category_id);

            $subCatLevOneDetails = $subCatLevOneDetails->get();

            foreach ($subCatLevOneDetails as $c) {
                if (isset($c->sub_category_icon))
                    $c->sub_category_icon = '/assets/uploads/category_icon/' . $c->sub_category_icon;
                else
                    $c->sub_category_icon = Helper::categoryIcon();
            }

            $data['subCatOneDetails'] = $subCatLevOneDetails;
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];

            return response($response);
        }
    }


    public function listSubCategoryLevTwo(Request $request)
    {
        $data = array();
        try {

            $subCatLevTwoDetails = Mst_ItemLevelTwoSubCategory::select(
                'iltsc_id',
                'item_sub_category_id',
                'item_category_id',
                'iltsc_name',
                'iltsc_icon',
                'iltsc_description',
            )

                ->where('is_active', 1)
                ->orderBy('iltsc_name', 'ASC');

            if ($request->item_category_id)
                $subCatLevTwoDetails = $subCatLevTwoDetails->where('item_category_id', $request->item_category_id);

            if ($request->item_sub_category_id)
                $subCatLevTwoDetails = $subCatLevTwoDetails->where('item_sub_category_id', $request->item_sub_category_id);

            $subCatLevTwoDetails = $subCatLevTwoDetails->get();

            foreach ($subCatLevTwoDetails as $c) {
                if (isset($c->sub_category_icon))
                    $c->iltsc_icon = '/assets/uploads/category_icon/' . $c->sub_category_icon;
                else
                    $c->iltsc_icon = Helper::categoryIcon();
            }

            $data['subCatTwoDetails'] = $subCatLevTwoDetails;
            $data['status'] = 1;
            $data['message'] = "success";

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
