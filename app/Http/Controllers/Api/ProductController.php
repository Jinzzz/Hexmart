<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Trn_Cart;
use App\Models\admin\Trn_CustomerAddress;
use App\Models\admin\Trn_CustomerReward;
use App\Models\admin\Trn_ReviewsAndRating;
use App\Models\admin\Trn_WishList;
use Illuminate\Http\Request;
use stdClass;
use Validator;

class ProductController extends Controller
{



    public function getReviewAndRating(Request $request)
    {
        $data = array();

        try {
            if (isset($request->product_variant_id) && Mst_ProductVariant::find($request->product_variant_id)) {
                $allReviewAndRating  = Trn_ReviewsAndRating::where('product_variant_id', $request->product_variant_id)->get();


                foreach ($allReviewAndRating as $c) {
                    $customerData = $c->customerData;
                }


                $data['reviewAndRatingData'] = $allReviewAndRating;
                $data['ratingCount'] = Helper::findRatingCount($request->product_variant_id);
                $data['rating'] = Helper::findRating($request->product_variant_id);
                $data['reviewCount'] = Helper::findReviewCount($request->product_variant_id);
                $data['status'] = 1;
                $data['message'] = "success";
            } else {

                $data['status'] = 0;
                $data['message'] = "Customer not exists";
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




    public function addReview(Request $request)
    {
        $data = array();
        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'product_variant_id'   => 'required',
                        'rating'   => 'required',
                    ],
                    [
                        'product_variant_id.required'  => 'Variant required',
                        'rating.required'  => 'Rating required',
                    ]
                );

                if (!$validator->fails()) {

                    $review = new Trn_ReviewsAndRating;
                    $review->customer_id = $request->customer_id;
                    $variantData = Mst_ProductVariant::find($request->product_variant_id);
                    $review->product_id = @$variantData->product_id;
                    $review->product_variant_id = $request->product_variant_id;
                    $review->rating = $request->rating;
                    $review->review = $request->review;
                    if ($review->save()) {
                        $data['status'] = 1;
                        $data['message'] = "Review added";
                        return response($data);
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "failed";
                        return response($data);
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "failed";
                    $data['errors'] = $validator->errors();
                    return response($data);
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer not found ";
                return response($data);
            }
        } catch (\Exception $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        }
    }



    public function removeCartItem(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                if (isset($request->product_variant_id) && Mst_ProductVariant::find($request->product_variant_id)) {

                    if (Trn_Cart::where('customer_id', $request->customer_id)->where('product_variant_id', $request->product_variant_id)->delete()) {
                        $data['status'] = 1;
                        $data['message'] = "Item removed";
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "failed";
                    }
                } else {

                    $data['status'] = 0;
                    $data['message'] = "Product not exists";
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer not exists";
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


    public function wishList(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $wishListProducts  = Trn_WishList::where('customer_id', $request->customer_id)->get();


                foreach ($wishListProducts as $c) {

                    if (Helper::isOfferAvailable($c->product_variant_id)) {
                        $c->isOfferAvailable  = 1;
                        $c->offerData  = Helper::isOfferAvailable($c->product_variant_id);
                    } else {
                        $c->isOfferAvailable  = 0;
                        $c->offerData  = new stdClass();;
                    }

                    $baseProductData  = @$c->productVariantData->productData;
                    $baseProductData->item_category_data = @$baseProductData->itemCategoryData;
                    $baseProductData->item_sub_category_data = @$baseProductData->itemSubCategoryData;
                    $baseProductData->item_sub_cat_lev_two_data = @$baseProductData->itemSubCatLevTwoData;
                    $baseProductData->brand_data = @$baseProductData->brandData;

                    $taxData = @$baseProductData->taxData;
                    $taxData->tax_splits =  @$taxData->taxSplits;
                    $baseProductData->tax_data = @$taxData;

                    $c->baseProductData = $baseProductData;

                    $variantData  = @$c->productVariantData;
                    $c->product_variant_data = $variantData;


                    $c->productVariantBaseImage  = Helper::productVarBaseImage(@$c->productVariantData->product_id, $c->product_variant_id);
                    $c->proVarAttributes  = Helper::variantArrtibutes($c->product_variant_id);
                    $c->proVarImages  = Helper::variantImages($c->product_variant_id);
                }


                $data['wishListProducts'] = $wishListProducts;
                $data['status'] = 1;
                $data['message'] = "success";
            } else {

                $data['status'] = 0;
                $data['message'] = "Customer not exists";
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


    public function cartList(Request $request)
    {
        $data = array();

        try {


            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {

                $customerAddressData = Trn_CustomerAddress::where('customer_id', $request->customer_id)->where('is_default', 1)->first();
                $data['customerAddress'] = $customerAddressData;




                $cartProducts  = Trn_Cart::where('customer_id', $request->customer_id)->get();

                $priceDetails = new stdClass();
                $price = 0;
                $itemCount = 0;
                $discount = 0;
                $itemRegularPriceTotal = 0;
                foreach ($cartProducts as $c) {

                    $itemTotalPrice = 0;

                    if (Helper::isOfferAvailable($c->product_variant_id)) {
                        $c->isOfferAvailable  = 1;
                        $offerData = Helper::isOfferAvailable($c->product_variant_id);
                        $c->offerData = $offerData;

                        $itemTotalPrice = $offerData->offer_price * $c->quantity;
                        $price += $itemTotalPrice;

                        $itemDiscount =  @$c->productVariantData->variant_price_regular - $offerData->offer_pric;
                        $itemTotalDiscount = $itemDiscount * $c->quantity;
                        $discount += $itemTotalDiscount;
                    } else {
                        $c->isOfferAvailable  = 0;
                        $c->offerData  = new stdClass();

                        $itemTotalPrice = @$c->productVariantData->variant_price_offer * $c->quantity;
                        $price += $itemTotalPrice;

                        $itemDiscount = @$c->productVariantData->variant_price_regular - @$c->productVariantData->variant_price_offer;
                        $itemTotalDiscount = $itemDiscount * $c->quantity;
                        $discount += $itemTotalDiscount;
                    }


                    $baseProductData  = @$c->productVariantData->productData;
                    $baseProductData->item_category_data = @$baseProductData->itemCategoryData;
                    $baseProductData->item_sub_category_data = @$baseProductData->itemSubCategoryData;
                    $baseProductData->item_sub_cat_lev_two_data = @$baseProductData->itemSubCatLevTwoData;
                    $baseProductData->brand_data = @$baseProductData->brandData;

                    $taxData = @$baseProductData->taxData;
                    $taxData->tax_splits =  @$taxData->taxSplits;
                    $baseProductData->tax_data = @$taxData;

                    $c->baseProductData = $baseProductData;

                    $variantData  = @$c->productVariantData;
                    $c->product_variant_data = $variantData;


                    $c->productVariantBaseImage  = Helper::productVarBaseImage(@$c->productVariantData->product_id, $c->product_variant_id);
                    $c->proVarAttributes  = Helper::variantArrtibutes($c->product_variant_id);
                    $c->proVarImages  = Helper::variantImages($c->product_variant_id);
                    $itemCount++;
                }

                $itemRegularPriceTotal += ($c->productVariantData->variant_price_regular * $c->quantity);


                $priceDetails->price = $itemRegularPriceTotal; // total price for carted prducts
                $priceDetails->itemCount = $itemCount; // total carted prducts
                $priceDetails->discount = $discount; // total discount for carted prducts
                $deliveryCharge = Helper::findDeliveryCharge($request->customer_id, $customerAddressData->customer_address_id); // delivery charge
                $priceDetails->deliveryCharge = $deliveryCharge;
                $totalAmount = ($price - 0) + $deliveryCharge;
                $priceDetails->totalAmount = $totalAmount; // total amount after all deductions plus delivery charge


                $data['cartProducts'] = $cartProducts;

                $data['priceDetails'] = $priceDetails;

                $data['status'] = 1;
                $data['message'] = "success";
            } else {

                $data['status'] = 0;
                $data['message'] = "Customer not exists";
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


    public function addToCart(Request $request, Trn_Cart $cart)
    {
        $data = array();
        try {

            $validate = Validator::make(
                $request->all(),
                [
                    'quantity' => 'required',
                    'product_variant_id' => 'required',
                    'customer_id' => 'required',


                ],
                [
                    'quantity.required'                => 'Quantity required',
                    'product_variant_id.required'                => 'Product required',
                    'customer_id.required'                => 'Customer required',


                ]
            );
            if (!$validate->fails()) {

                if (Trn_Cart::where('product_variant_id', $request->product_variant_id)->where('customer_id', $request->customer_id)->exists()) {

                    $cart = Trn_Cart::where('product_variant_id', $request->product_variant_id)->where('customer_id', $request->customer_id)->first();
                    $cart->quantity = $request->quantity;
                    $cart->update();
                } else {

                    $cart->quantity = $request->quantity;
                    $cart->product_variant_id = $request->product_variant_id;
                    $cart->customer_id = $request->customer_id;
                    $cart->save();
                }


                $data['status'] = 1;
                $data['message'] = "Product added to cart";
            } else {
                $data['errors'] = $validate->errors();
                $data['status'] = 0;
                $data['message'] = "Failed";
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

    public function addToWishList(Request $request, Trn_WishList $wishList)
    {
        $data = array();
        try {

            $validate = Validator::make(
                $request->all(),
                [
                    'product_variant_id' => 'required',
                    'customer_id' => 'required',

                ],
                [
                    'product_variant_id.required'                => 'Product required',
                    'customer_id.required'                => 'Customer required',

                ]
            );
            if (!$validate->fails()) {

                if (Trn_WishList::where('product_variant_id', $request->product_variant_id)->where('customer_id', $request->customer_id)->exists()) {

                    Trn_WishList::where('product_variant_id', $request->product_variant_id)->where('customer_id', $request->customer_id)->delete();
                    $data['status'] = 0;
                    $data['message'] = "Product removed from wish list";
                } else {

                    $wishList->product_variant_id = $request->product_variant_id;
                    $wishList->customer_id = $request->customer_id;
                    $wishList->save();

                    $data['status'] = 1;
                    $data['message'] = "Product added to wish list.";
                }
            } else {
                $data['errors'] = $validate->errors();
                $data['status'] = 0;
                $data['message'] = "Failed";
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


    public function listRecentProducts(Request $request)
    {
        $data = array();

        try {

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

            if ($request->limit) {
                $recentAddedProducts = $recentAddedProducts->limit($request->limit);
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
                $c->ratingCount  = Helper::findRatingCount($c->product_variant_id);
                $c->rating  = Helper::findRating($c->product_variant_id);
                $c->reviewCount  = Helper::findReviewCount($c->product_variant_id);
            }

            $data['recentAddedProducts'] = $recentAddedProducts;
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


    public function listProducts(Request $request)
    {
        $data = array();

        try {

            if (isset($request->pagination_count)) {
                $pageCount = $request->pagination_count;
            } else {
                $pageCount = 10;
            }

            $products  = Mst_Product::join('mst__product_variants', 'mst__product_variants.product_id', '=', 'mst__products.product_id')
                ->select(
                    'mst__products.product_id',
                    'mst__products.product_name',
                    'mst__products.product_code',

                    'mst__products.item_category_id',
                    'mst__products.item_sub_category_id',
                    'mst__products.iltsc_id',

                    'mst__product_variants.product_variant_id',
                    'mst__product_variants.variant_name',
                    'mst__product_variants.variant_price_regular',
                    'mst__product_variants.variant_price_offer',
                    'mst__product_variants.stock_count',
                )
                ->where('mst__product_variants.stock_count', '>', 0)
                ->where('mst__products.is_active', 1)
                ->where('mst__product_variants.is_active', 1);

            if (isset($request->brand_id)) {
                $products =  $products->where('mst__products.brand_id', $request->brand_id);
            }

            if (isset($request->product_name)) {
                $products =  $products->where('mst__products.product_name',  'LIKE', "%{$request->product_name}%");
            }

            if (isset($request->price_from)) {
                $products =  $products->where('mst__product_variants.variant_price_offer', '>=', $request->price_from);
            }
            if (isset($request->price_to)) {
                $products =  $products->where('mst__product_variants.variant_price_offer', '<=', $request->price_to);
            }

            // category filter
            if (isset($request->item_category_id)) {
                $products =  $products->where('mst__products.item_category_id', '=', $request->item_category_id);
            }
            if (isset($request->item_sub_cat_lev_one_id)) {
                $products =  $products->where('mst__products.item_sub_category_id', '=', $request->item_sub_cat_lev_one_id);
            }
            if (isset($request->item_sub_cat_lev_two_id)) {
                $products =  $products->where('mst__products.iltsc_id', '=', $request->item_sub_cat_lev_two_id);
            }


            if ($request->product_order == 'ASC') {
                $products =  $products->orderBy('mst__product_variants.variant_price_offer', 'ASC');
            } elseif ($request->product_order == 'DESC') {
                $products =  $products->orderBy('mst__product_variants.variant_price_offer', 'DESC');
            } elseif ($request->product_order == 'NEW') {
                $products =  $products->orderBy('mst__product_variants.product_variant_id', 'DESC');
            } elseif ($request->product_order == 'POPULAR') { // dummy popular products
                $products =  $products->orderBy('mst__product_variants.product_variant_id', 'DESC');
            } else {
                $products =  $products->orderBy('mst__product_variants.product_variant_id', 'DESC');
            }



            if ($request->page) {
                $products = $products->paginate($pageCount, ['data'], 'page', $request->page);
            } else {
                $products = $products->paginate($pageCount);
            }

            foreach ($products as $c) {
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
                $c->ratingCount  = Helper::findRatingCount($c->product_variant_id);
                $c->rating  = Helper::findRating($c->product_variant_id);
                $c->reviewCount  = Helper::findReviewCount($c->product_variant_id);
            }

            $data['productsList'] = $products;
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


    public function viewProducts(Request $request)
    {
        $data = array();

        try {

            if (isset($request->product_variant_id) && Mst_ProductVariant::find($request->product_variant_id)) {

                $product  = Mst_ProductVariant::find($request->product_variant_id);
                $product->productBaseImage  = Helper::productBaseImage($product->product_id);
                $product->productVariantBaseImage  = Helper::productVarBaseImage($product->product_id, $product->product_variant_id);
                $product->proVarAttributes  = Helper::variantArrtibutes($product->product_variant_id);
                $product->proVarImages  = Helper::variantImages($product->product_variant_id);
                $product->ratingCount  = Helper::findRatingCount($product->product_variant_id);
                $product->rating  = Helper::findRating($product->product_variant_id);
                $product->reviewCount  = Helper::findReviewCount($product->product_variant_id);
                $product->reviewData  = Helper::findReviewData($product->product_variant_id);
                $product->isWishListProduct  = Helper::isWishListProduct($product->product_variant_id, $request->customer_id);
                $baseProductData  = @$product->productData;
                $baseProductData->item_category_data = @$baseProductData->itemCategoryData;
                $baseProductData->item_sub_category_data = @$baseProductData->itemSubCategoryData;
                $baseProductData->item_sub_cat_lev_two_data = @$baseProductData->itemSubCatLevTwoData;
                $baseProductData->brand_data = @$baseProductData->brandData;

                $taxData = @$baseProductData->taxData;
                $taxData->tax_splits =  @$taxData->taxSplits;
                $baseProductData->tax_data = @$taxData;

                $product->product_data = $baseProductData;

                if (isset($request->similar_products_limit)) {
                    $similar_products_limit = $request->similar_products_limit;
                } else {
                    $similar_products_limit = null;
                }

                // offer-details
                if (Helper::isOfferAvailable($request->product_variant_id)) {
                    $product->isOfferAvailable  = 1;
                    $product->offerData  = Helper::isOfferAvailable($request->product_variant_id);
                } else {
                    $product->isOfferAvailable  = 0;
                    $product->offerData  = new stdClass();
                }

                $data['productDetails'] = $product;
                $data['otherVariants'] =  Helper::otherVariants($product->product_variant_id, 50);
                $data['similarProducts'] =  Helper::similarProducts($product->product_variant_id, $similar_products_limit);
                $data['status'] = 1;
                $data['message'] = "success";
            } else {
                $data['status'] = 1;
                $data['message'] = "Product not found";
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
