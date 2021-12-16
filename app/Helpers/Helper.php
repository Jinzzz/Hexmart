<?php

namespace App\Helpers;

use App\Models\admin\Mst_Coupon;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Trn_ItemImage;
use App\Models\admin\Trn_ItemVariantAttribute;
use App\Models\admin\Trn_Order;
use Illuminate\Support\Str;
use Crypt;
use  Carbon\Carbon;
use stdClass;
use Validator;

class Helper
{

    public static function validateCustomer($valid)
    {
        $validate = Validator::make(
            $valid,
            [
                'customer_name' => 'required',
                'customer_email'    => 'email',
                'customer_mobile'    => 'required|unique:mst__customers|numeric',
                'password'  => 'required|min:5|same:password_confirmation',


            ],
            [
                'customer_name.required'                => 'Customer name required',
                'customer_mobile.unique'                  => 'Mobile number already exists ',
                'customer_email.email'                  => 'Invalid email ',
                'password.required'                  => 'Password required ',

            ]
        );
        return $validate;
    }



    public static function categoryIcon()
    {
        return '/assets/default/category.png';
    }

    public static function productIcon()
    {
        return '/assets/default/category.png';
    }

    public static function brandIcon()
    {
        return '/assets/default/category.png';
    }

    public static function totalProductCount()
    {
        $totalProductCount = Mst_ProductVariant::count();
        return $totalProductCount;
    }

    public static function todaySales()
    {
        $totalSales = Trn_Order::whereIn('order_status_id', [7])
            ->sum('order_total_amount');
        return $totalSales;
    }

    public static function totalSales()
    {
        $totalSales = Trn_Order::whereIn('order_status_id', [7])
            ->sum('order_total_amount');
        return $totalSales;
    }

    public static function todayCustomerVisit()
    {
        return 0;
    }

    public static function weeklySales()
    {
        return 0;
    }

    public static function currentIssues()
    {
        return 0;
    }

    public static function newIssues()
    {
        return 0;
    }

    public static function totalCategories()
    {
        return 0;
    }

    public static function deliveryBoysCount()
    {
        return 0;
    }

    public static function dailySales()
    {
        return 0;
    }

    public static function monthlyVisit()
    {
        return 0;
    }

    public static function totalIssues()
    {
        return 0;
    }

    public static function totalOrder()
    {
        return 0;
    }

    public static function findDeliveryCharge($customerd, $cusAddrId)
    {
        return 0;
    }

    public static function reduceCouponDiscount($customer_id, $coupon_code, $totalAmount)
    {
        $current_time = Carbon::now()->toDateTimeString();
        $coupon = Mst_Coupon::where('coupon_code', $coupon_code)->where('coupon_status', 1)->first();
        if (($coupon->valid_from <= $current_time) && ($coupon->valid_to >= $current_time)) {
            // echo "here " . $totalAmount . " - " . $coupon->min_purchase_amt;
            // die;
            if ($totalAmount >= $coupon->min_purchase_amt) {

                if ((Trn_Order::where('customer_id', $customer_id)->where('coupon_id', $coupon->coupon_id)->count()) <= 0) {
                    // ->whereIn('status_id', [6, 9, 4, 7, 8, 1]) order status not added to previous query
                    if ($coupon->discount_type == 1) {
                        //fixedAmt
                        $amtToBeReduced = $coupon->discount;
                    } else {
                        //percentage
                        $amtToBeReduced = ($coupon->discount * 100) / $totalAmount;
                    }
                    return number_format((float)$amtToBeReduced, 2, '.', '');
                } else {
                    if ($coupon->coupon_type == 2) {
                        if ($coupon->discount_type == 1) {
                            //fixedAmt
                            $amtToBeReduced = $coupon->discount;
                        } else {
                            //percentage
                            $amtToBeReduced = ($coupon->discount * 100) / $totalAmount;
                        }
                        return number_format((float)$amtToBeReduced, 2, '.', '');
                    } else {
                        return 0;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }


    public static function subCategoryLevOne($item_category_id)
    {
        $subCategoryLevOne = Mst_ItemSubCategory::where('is_active', 1)
            ->where('item_category_id', $item_category_id)
            ->orderBy('sub_category_name', 'ASC')->get();

        foreach ($subCategoryLevOne as $c) {
            $c->subCategoryLevTwo = Helper::subCategoryLevTwo($c->item_sub_category_id);
        }
        return $subCategoryLevOne;
    }

    private static function subCategoryLevTwo($item_sub_category_id)
    {
        $subCategoryLevTwo = Mst_ItemLevelTwoSubCategory::where('is_active', 1)
            ->where('item_sub_category_id', $item_sub_category_id)
            ->orderBy('iltsc_name', 'ASC')->get();

        return $subCategoryLevTwo;
    }



    public static function productBaseImage($product_id)
    {
        $productBaseImage = Trn_ItemImage::where('is_default', 1)
            ->where('product_id', $product_id)
            ->where('product_variant_id', null)->first();

        if (isset($productBaseImage->item_image_name)) {
            return '/assets/uploads/products/' . $productBaseImage->item_image_name;
        } else {
            $productBaseImage2 = Trn_ItemImage::where('product_id', $product_id)->first();
            if (isset($productBaseImage2->item_image_name)) {
                return '/assets/uploads/products/' . $productBaseImage2->item_image_name;
            } else {
                return '/assets/default/category.png';
            }
        }
    }

    public static function productVarBaseImage($product_id, $product_variant_id)
    {
        $productBaseImage = Trn_ItemImage::where('is_default', 1)
            ->where('product_variant_id', $product_variant_id)
            ->where('product_id', $product_id)->first();

        if (isset($productBaseImage->item_image_name)) {
            return '/assets/uploads/products/' . $productBaseImage->item_image_name;
        } else {
            $productBaseImage2 = Trn_ItemImage::where('product_id', $product_id)
                ->where('product_variant_id', $product_variant_id)
                ->first();
            if (isset($productBaseImage2->item_image_name)) {
                return '/assets/uploads/products/' . $productBaseImage2->item_image_name;
            } else {
                return '/assets/default/category.png';
            }
        }
    }

    public static function variantArrtibutes($product_variant_id)
    {
        $variantArrtibutes = Trn_ItemVariantAttribute::where('product_variant_id', $product_variant_id)
            ->orderBy('variant_attribute_id', 'DESC')->get();

        foreach ($variantArrtibutes as $c) {
            $c->attribute_group_name = $c->attributeGroup->attribute_group;
            $c->attribute_value_name = $c->attributeValue->attribute_value;
        }
        return $variantArrtibutes;
    }

    public static function variantImages($product_variant_id)
    {
        $itemImages = Trn_ItemImage::where('product_variant_id', $product_variant_id)
            ->where('is_active', 1)
            ->orderBy('is_default', 'DESC')
            ->orderBy('item_image_id', 'DESC')
            ->get();

        foreach ($itemImages as $c) {
            $c->item_image_name = '/assets/uploads/products/' . $c->item_image_name;
        }

        return $itemImages;
    }

    public static function isOfferAvailable($product_variant_id)
    {
        $offerData = Mst_OfferZone::where('product_variant_id', $product_variant_id)
            ->whereDate('date_start', '<=', Carbon::now()->format('Y-m-d'))
            ->whereDate('date_end', '>=', Carbon::now()->format('Y-m-d'))
            // ->whereTime('time_start', '<=', Carbon::now()->format('H:i'))
            // ->whereTime('time_end', '>=', Carbon::now()->format('H:i'))
            ->whereTime('time_start', '<=', Carbon::now()->format('H:i'))
            ->whereTime('time_end', '>', Carbon::now()->format('H:i'))
            ->where('is_active', 1)
            ->first();

        if ($offerData)
            return $offerData;
        else
            return false;
    }

    public static function similarProducts($product_variant_id, $similar_products_limit)
    {
        $varData = Mst_ProductVariant::join('mst__products', 'mst__products.product_id', '=', 'mst__product_variants.product_id')
            ->where('mst__product_variants.product_variant_id', $product_variant_id)->first();

        $similarProducts = Mst_ProductVariant::join('mst__products', 'mst__products.product_id', '=', 'mst__product_variants.product_id')
            ->where('mst__products.iltsc_id', $varData->iltsc_id)
            ->where('mst__product_variants.product_variant_id', '!=', $product_variant_id);

        if (isset($similar_products_limit)) {
            $similarProducts = $similarProducts->limit($similar_products_limit);
        }

        $similarProducts = $similarProducts->get();

        foreach ($similarProducts as $c) {
            $c->productBaseImage  = Helper::productBaseImage($c->product_id);
            $c->productVariantBaseImage  = Helper::productVarBaseImage($c->product_id, $c->product_variant_id);
            $c->proVarAttributes  = Helper::variantArrtibutes($c->product_variant_id);
            $c->proVarImages  = Helper::variantImages($c->product_variant_id);

            // offer-details
            if (Helper::isOfferAvailable($c->product_variant_id)) {
                $c->isOfferAvailable  = 1;
                $c->offerData  = Helper::isOfferAvailable($c->product_variant_id);
            } else {
                $c->isOfferAvailable  = 0;
                $c->offerData  = new stdClass();;
            }
        }

        return $similarProducts;
    }


    public static function ajaxLoader()
    {
        echo '<div style="display: none; background-color: transparent; z-index: 30001; opacity: 1;" id="loaderCard" class="card"> 
         <div class="dimmer active">
        <div class="spinner1">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
            </div>
            </div>
        </div>';
    }

    public static function ajaxModalLoader()
    {
        echo '';
    }

    public static function stockAvailable($product_id)
    {
        $stockSum = Mst_ProductVariant::where('product_id', $product_id)->sum('stock_count');
        return $stockSum;
    }
}
