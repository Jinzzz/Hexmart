<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\admin\Mst_AttributeValue;
use App\Models\admin\Mst_ConfigurePoints;
use App\Models\admin\Mst_Coupon;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_Setting;
use App\Models\admin\Mst_TimeSlot;
use App\Models\admin\Sys_PaymentType;
use App\Models\admin\Trn_Cart;
use App\Models\admin\Trn_CustomerAddress;
use App\Models\admin\Trn_CustomerReward;
use App\Models\admin\Trn_Order;
use App\Models\admin\Trn_OrderItem;
use App\Models\admin\Trn_StockDetail;
use Response;
use Image;
use DB;
use Hash;
use Carbon\Carbon;
use Crypt;
use Mail;
use PDF;
use Auth;
use stdClass;
use Validator;

class OrderController extends Controller
{

    public function reduceRewardPoint(Request $request)
    {
        $data = array();
        try {
            if (isset($request->totalAmount)) {
                if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                    $customer_id = $request->customer_id;

                    $totalCustomerRewardsCount = Trn_CustomerReward::where('customer_id', $request->customer_id)->where('is_active', 1)->sum('reward_points_earned');
                    $totalusedPoints = Trn_Order::where('customer_id', $request->customer_id)->sum('reward_points_used'); // ->whereNotIn('status_id',[5]) cancelled order must be avoided
                    $customerRewardPoint = $totalCustomerRewardsCount - $totalusedPoints;

                    //echo $customerRewardPoint;die;

                    if ($customerRewardPoint > 0) {


                        $ConfigPoints = Mst_ConfigurePoints::first();
                        $pointToRupeeRatio =   $ConfigPoints->rupee / $ConfigPoints->rupee_points; // points to rupee ratio

                        $avilableRewardAmount = $pointToRupeeRatio * $customerRewardPoint;
                        $maxRedeemAmountPerOrder = $ConfigPoints->max_redeem_amount;
                        $totalReducableAmount = ($avilableRewardAmount * $ConfigPoints->redeem_percentage) / 100; // 10% of order amount

                        if ($totalReducableAmount > $maxRedeemAmountPerOrder) {

                            $orderAmount = $request->totalAmount;
                            $totalAmount = $orderAmount - $maxRedeemAmountPerOrder;
                            $customerUsedRewardPoint = $maxRedeemAmountPerOrder / $pointToRupeeRatio;

                            //   $data['orderAmount'] = number_format((float)$orderAmount, 2, '.', '');
                            //   $data['totalReducableAmount'] = number_format((float)$maxRedeemAmountPerOrder, 2, '.', '');
                            $data['totalAmount'] = number_format((float)$totalAmount, 2, '.', '');
                            $data['reducedAmountByWalletPoints'] = number_format((float)$maxRedeemAmountPerOrder, 2, '.', '');
                            $data['usedPoint'] = number_format((float)$customerUsedRewardPoint, 2, '.', '');
                            $data['balancePoint'] = $customerRewardPoint - $customerUsedRewardPoint;
                        } else {

                            $orderAmount = $request->totalAmount;
                            $totalAmount = $orderAmount - $totalReducableAmount;
                            $customerUsedRewardPoint = $totalReducableAmount / $pointToRupeeRatio;

                            //   $data['orderAmount'] = number_format((float)$orderAmount, 2, '.', '');
                            //   $data['totalReducableAmount'] = number_format((float)$totalReducableAmount, 2, '.', '');
                            $data['totalAmount'] = number_format((float)$totalAmount, 2, '.', '');
                            $data['reducedAmountByWalletPoints'] = number_format((float)$totalReducableAmount, 2, '.', '');
                            $data['usedPoint'] = number_format((float)$customerUsedRewardPoint, 2, '.', '');
                            $data['balancePoint'] = $customerRewardPoint - $customerUsedRewardPoint;
                        }





                        //     $orderAmount = $request->order_amount;
                        //     $totalReducableAmount = ($orderAmount * $ConfigPoints->redeem_percentage) / 100; // 10% of order amount
                        //     $amountCanBeReduced = $pointToRupeeRatio * $customerRewardPoint;
                        //     if($totalReducableAmount >= $amountCanBeReduced){
                        //         $reducedOrderAmount = $orderAmount - $amountCanBeReduced;
                        //         $data['orderAmount'] = number_format((float)$orderAmount, 2, '.', '');
                        //         $data['totalReducableAmount'] = number_format((float)$totalReducableAmount, 2, '.', '');
                        //         $data['reducedOrderAmount'] = number_format((float)$reducedOrderAmount, 2, '.', '');
                        //         $data['reducedAmountByWalletPoints'] = number_format((float)$amountCanBeReduced, 2, '.', '');
                        //         $data['usedPoint'] = number_format((float)$customerRewardPoint, 2, '.', '');
                        //         $data['balancePoint'] = 0;
                        //     }else{
                        //         $usedPoint = $totalReducableAmount / $pointToRupeeRatio;
                        //         $reducedOrderAmount = $orderAmount - $totalReducableAmount;
                        //         $balancePoint = $customerRewardPoint - $usedPoint;
                        //         $data['orderAmount'] = number_format((float)$orderAmount, 2, '.', '');
                        //         $data['totalReducableAmount'] = number_format((float)$totalReducableAmount, 2, '.', '');
                        //         $data['reducedOrderAmount'] = number_format((float)$reducedOrderAmount, 2, '.', '');
                        //         $data['reducedAmountByWalletPoints'] = number_format((float)$totalReducableAmount, 2, '.', '');
                        //         $data['usedPoint'] = number_format((float)$usedPoint, 2, '.', '');
                        //         $data['balancePoint'] = number_format((float)$balancePoint, 2, '.', '');
                        //     }

                        $data['status'] = 1;
                        $data['message'] = "success";
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "No reward points available";
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Customer not found";
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Order amount required";
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


    public function orderStatusUpdate(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {

                if (isset($request->order_id) && Trn_Order::find($request->order_id)) {;

                    if (Trn_Order::where('customer_id', $request->customer_id)->where('order_id', $request->order_id)
                        ->update(['order_status_id' => $request->order_status_id])
                    ) {
                        $data['status'] = 1;
                        $data['message'] = "Order status updated ";
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "failed";
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Order not found ";
                }
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


    public function checkoutPage(Request $request) // cancel status is not correct
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {

                $customerAddressData = Trn_CustomerAddress::where('customer_id', $request->customer_id);

                if ($request->customer_address_id) {
                    $customerAddressData = $customerAddressData->where('customer_address_id', $request->customer_address_id);
                } else {
                    $customerAddressData = $customerAddressData->where('is_default', 1);
                }
                $customerAddressData = $customerAddressData->first();

                $data['customerAddress'] = $customerAddressData;

                $today = Carbon::now()->toDateTimeString();
                $couponDetail = Mst_Coupon::where('coupon_status', 1);
                //  $couponDetail = $couponDetail->whereDate('valid_from', '<=', $today)->whereDate('valid_to', '>=', $today);
                $couponDetail = $couponDetail->orderBy('coupon_id', 'DESC')->get();
                $data['couponDetails'] = $couponDetail;

                $data['paymentTypes'] = Sys_PaymentType::all();

                $timeslots = Mst_TimeSlot::all();
                $data['timeSlot'] = $timeslots;
                $data['expectedDeliveryDate'] = '2022-01-01';
                $data['maxRedeemPercentage'] = Mst_ConfigurePoints::first()->redeem_percentage;


                //$checkoutProducts  = Trn_Cart::where('customer_id', $request->customer_id)->get();
                $checkoutProducts = $request->checkoutProducts;


                $priceDetails = new stdClass();
                $price = 0;
                $itemCount = 0;
                $discount = 0;
                $itemRegularPriceTotal = 0;
                foreach ($checkoutProducts as $c) {
                    $itemTotalPrice = 0;
                    $variantInfo = Mst_ProductVariant::find($c['product_variant_id']);

                    if (Helper::isOfferAvailable($variantInfo->product_variant_id)) {
                        $offerData = Helper::isOfferAvailable($variantInfo->product_variant_id);

                        $itemTotalPrice = $offerData->offer_price * $c['quantity'];
                        $price += $itemTotalPrice;


                        $itemDiscount =  @$variantInfo->variant_price_regular - $offerData->offer_price;
                        $itemTotalDiscount = $itemDiscount * $c['quantity'];
                        $discount += $itemTotalDiscount;
                    } else {

                        $itemTotalPrice = @$variantInfo->variant_price_offer * $c['quantity'];
                        $price += $itemTotalPrice;

                        $itemDiscount = @$variantInfo->variant_price_regular - @$variantInfo->variant_price_offer;
                        $itemTotalDiscount = $itemDiscount * $c['quantity'];
                        $discount += $itemTotalDiscount;
                    }

                    $itemCount++;
                    $itemRegularPriceTotal += ($variantInfo->variant_price_regular * $c['quantity']);
                }
                // echo "here";
                // die;


                $priceDetails->price = $itemRegularPriceTotal; // total price for carted prducts
                $priceDetails->itemCount = $itemCount; // total carted prducts
                $priceDetails->discount = $discount; // total discount for carted prducts

                $deliveryCharge = Helper::findDeliveryCharge($request->customer_id, $customerAddressData->customer_address_id); // delivery charge
                $priceDetails->deliveryCharge = $deliveryCharge;

                $totalAmount = ($price - 0) + $deliveryCharge;
                $couponDiscount = floatval(Helper::reduceCouponDiscount($request->customer_id, $request->coupon_code, $totalAmount));
                // dd($couponDiscount);
                $priceDetails->couponDiscount = $couponDiscount;

                $totalAmountAfterCouponDiscount = (($price - 0) - $couponDiscount) + $deliveryCharge;
                $priceDetails->totalAmount = $totalAmountAfterCouponDiscount; // total amount after all deductions plus delivery charge



                // $data['checkoutProducts'] = $checkoutProducts;

                $data['priceDetails'] = $priceDetails;

                $data['status'] = 1;
                $data['message'] = "Success";
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer not found ";
            }
            return response($data);
        } catch (\Exception $e) {

            $data['status'] = 0;
            $data['message'] = "failed ";
            $data['inputData'] = $request->all();

            return response($data);

            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {

            $data['status'] = 0;
            $data['message'] = "failed ";
            $data['inputData'] = $request->all();

            return response($data);

            $response = ['status' => 0, 'message' => $e->getMessage()];
            return response($response);
        }
    }




    public function orderStatus(Request $request) // cancel status is not correct
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                if (isset($request->order_id) && Trn_Order::find($request->order_id)) {

                    $orderData  = Trn_Order::where('customer_id', $request->customer_id)
                        ->where('order_id', $request->order_id)
                        ->first();
                    $data['orderStatus'] = $orderData->orderStatusData;

                    $data['status'] = 1;
                    $data['message'] = "Order cancelled";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Order not found ";
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



    public function cancelOrder(Request $request) // cancel status is not correct
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                if (isset($request->order_id) && Trn_Order::find($request->order_id)) {

                    $orderData  = Trn_Order::where('customer_id', $request->customer_id)
                        ->where('order_id', $request->order_id)
                        ->update(['order_status_id' => null]);

                    $data['status'] = 1;
                    $data['message'] = "success";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Order not found ";
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

    public function viewOrder(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                if (isset($request->order_id) && Trn_Order::find($request->order_id)) {
                    $orderData  = Trn_Order::where('customer_id', $request->customer_id)->where('order_id', $request->order_id)->first();

                    $orderStatusData = $orderData->orderStatusData;
                    $timeSlotData = $orderData->timeSlotData;
                    $paymentTypeData = $orderData->paymentTypeData;
                    $customerAddressData = $orderData->customerAddressData;
                    $paymentStatusData = $orderData->paymentStatusData;
                    $deliveryBoyData = $orderData->deliveryBoyData;
                    $deliveryBoyStatus = $orderData->deliveryBoyStatus;
                    $orderTypeData = $orderData->orderTypeData;
                    $couponData = $orderData->couponData;

                    $orderItems = $orderData->orderItems;

                    foreach ($orderItems as $e) {
                        $offerData = $e->offerData;

                        $product_data = $e->productData;
                        $itemCategoryData = $e->productData->itemCategoryData;
                        $itemSubCategoryData = $e->productData->itemSubCategoryData;
                        $itemSubCatLevTwoData = $e->productData->itemSubCatLevTwoData;
                        $brandData = $e->productData->brandData;
                        $taxData = $e->productData->taxData;


                        $e->product_data = $product_data;

                        $e->product_variant_data = $e->product_variant_data;
                        $e->productVariantBaseImage  = Helper::productVarBaseImage(@$e->productVariantData->product_id, $e->product_variant_id);
                        $e->proVarAttributes  = Helper::variantArrtibutes($e->product_variant_id);
                        $e->proVarImages  = Helper::variantImages($e->product_variant_id);
                    }

                    $orderData->customer_data = $orderData->customerData;
                    $orderData->order_items = $orderItems;

                    $data['orderData'] = $orderData;
                    $data['status'] = 1;
                    $data['message'] = "success";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Order not found ";
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

    public function listOrders(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $orderData  = Trn_Order::where('customer_id', $request->customer_id)->get();
                foreach ($orderData as $d) {

                    $orderStatusData = $d->orderStatusData;
                    $timeSlotData = $d->timeSlotData;
                    $paymentTypeData = $d->paymentTypeData;
                    $customerAddressData = $d->customerAddressData;
                    $paymentStatusData = $d->paymentStatusData;
                    $deliveryBoyData = $d->deliveryBoyData;
                    $deliveryBoyStatus = $d->deliveryBoyStatus;
                    $orderTypeData = $d->orderTypeData;
                    $couponData = $d->couponData;

                    $orderItems = $d->orderItems;

                    foreach ($orderItems as $e) {
                        $offerData = $e->offerData;

                        $product_data = $e->productData;
                        $itemCategoryData = $e->productData->itemCategoryData;
                        $itemSubCategoryData = $e->productData->itemSubCategoryData;
                        $itemSubCatLevTwoData = $e->productData->itemSubCatLevTwoData;
                        $brandData = $e->productData->brandData;
                        $taxData = $e->productData->taxData;


                        $e->product_data = $product_data;

                        $e->product_variant_data = $e->product_variant_data;
                        $e->productVariantBaseImage  = Helper::productVarBaseImage(@$e->productVariantData->product_id, $e->product_variant_id);
                        $e->proVarAttributes  = Helper::variantArrtibutes($e->product_variant_id);
                        $e->proVarImages  = Helper::variantImages($e->product_variant_id);
                    }

                    $d->customer_data = $d->customerData;
                    $d->order_items = $orderItems;
                }
                $data['orderData'] = $orderData;
                $data['status'] = 1;
                $data['message'] = "success";
                return response($data);
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

    public function saveOrder(Request $request)
    {
        //dd($request->all());

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'customer_id'   => 'required',
                    //  'order_total_amount'  => 'required',
                    //  'payment_type_id'   => 'required',
                    // 'order_status_id' => 'required',
                    'product_variants.*.product_variant_id'    => 'required',
                    'product_variants.*.quantity'    => 'required',
                    // 'product_variants.*.discount_amount'    => 'required',
                ],
                [
                    'customer_id.required'  => 'Customer required',
                    'product_variants.*.product_variant_id.required'    => 'Product variant required',
                    'product_variants.*.quantity.required'    => 'Product quantity required',
                ]
            );

            if (!$validator->fails()) {
                $noStockProducts = array();


                // foreach ($request->product_variants as $value) {
                //     $varProdu = Mst_store_product_varient::find($value['product_variant_id']);
                //     $proData = Mst_store_product::find($varProdu->product_id);

                //     if ($proData->service_type != 2) {


                //         if (isset($varProdu)) {
                //             if ($value['quantity'] > $varProdu->stock_count) {
                //                 if (@$proData->product_name != $varProdu->variant_name) {
                //                     $data['product_name'] = @$proData->product_name . " " . $varProdu->variant_name;
                //                 } else {
                //                     $data['product_name'] = @$proData->product_name;
                //                 }

                //                 $noStockProducts[] = $varProdu->product_variant_id;

                //                 $data['product_variant_id'] = $varProdu->product_variant_id;
                //                 $data['product_id'] = $varProdu->product_id;
                //                 $data['message'] = 'Stock unavilable';
                //                 $data['status'] = 2;
                //                 //  return response($data);
                //             }
                //         } else {
                //             $data['message'] = 'Product not found';
                //             $data['status'] = 2;
                //             return response($data);
                //         }
                //     }
                // }
                // if (count($noStockProducts) > 0) {
                //     $data['noStockProducts'] = $noStockProducts;
                //     return response($data);
                // }
                $orderCount = Trn_Order::count();

                $orderNumber = @$orderCount + 1;

                $settings = Mst_Setting::first();

                if (isset($settings->order_number_prefix)) {
                    $orderNumberPrefix = $settings->order_number_prefix;
                } else {
                    $orderNumberPrefix = '';
                }


                $order = new Trn_Order();

                $order->order_number = $orderNumberPrefix . @$orderNumber;
                $order->order_status_id = 1; // pending
                $order->customer_id = $request->customer_id;
                $order->time_slot_id = $request->time_slot_id;
                $order->order_type_id = null;
                $order->payment_type_id = $request->payment_type_id;
                $order->customer_address_id = $request->customer_address_id;
                $order->coupon_id = $request->coupon_id;
                $order->reward_points_used = $request->reward_points_used;
                $order->amount_reduced_by_rp = $request->amount_reduced_by_rp;
                $order->payment_status_id = $request->payment_status_id;
                $order->transaction_id = $request->transaction_id;
                $order->save();


                // $order->order_total_amount = $request->order_total_amount;
                // $order->delivery_charge = $request->delivery_charge;
                // $order->packing_charge = $request->packing_charge;
                // $order->amount_reduced_by_coupon = $request->amount_reduced_by_coupon;



                $orderId = DB::getPdo()->lastInsertId();


                //invoice table
                // $invoice_info['order_id'] = $order_id;
                // $invoice_info['invoice_date'] =  Carbon::now()->format('Y-m-d');
                // $invoice_info['invoice_id'] = "INV0" . $order_id;
                // $invoice_info['created_at'] = Carbon::now();
                // $invoice_info['updated_at'] = Carbon::now();
                // Trn_order_invoice::insert($invoice_info);


                $price = 0;
                $itemCount = 0;
                $discount = 0;
                $itemRegularPriceTotal = 0;

                foreach ($request->orderItems as $value) {

                    $itemTotalPrice = 0;
                    $singleItemPrice = 0;
                    $itemTotalTaxPrice = 0;


                    $productVarOlddata = Mst_ProductVariant::find($value['product_variant_id']);
                    $productData = Mst_Product::find(@$productVarOlddata->product_id);

                    if (@$productData->service_type != 2) {
                        Mst_ProductVariant::where('product_variant_id', '=', $value['product_variant_id'])
                            ->decrement('stock_count', $value['quantity']);
                    }

                    if (!isset($value['discount_amount'])) {
                        $value['discount_amount'] = 0;
                    }

                    if (@$productData->service_type != 2) {
                        $negStock = -1 * abs($value['quantity']);

                        $sd = new Trn_StockDetail;
                        $sd->product_id = @$productVarOlddata->product_id;
                        $sd->added_stock = @$negStock;
                        $sd->product_variant_id = $value['product_variant_id'];
                        $sd->current_stock = @$productVarOlddata->stock_count + $negStock;
                        $sd->prev_stock = @$productVarOlddata->stock_count;
                        $sd->save();
                    }



                    if (Helper::isOfferAvailable($value['product_variant_id'])) {
                        // offer available
                        $offerData = Helper::isOfferAvailable($value['product_variant_id']);
                        $singleItemPrice = $offerData->offer_price;

                        $itemTotalPrice = $offerData->offer_price * $value['quantity'];
                        $price += $itemTotalPrice;

                        $itemDiscount =  @$productVarOlddata->variant_price_regular - $offerData->offer_pric;
                        $itemTotalDiscount = $itemDiscount * $value['quantity'];
                        $itemTotalTaxPrice = 0; // tax to be calculated
                        $discount += $itemTotalDiscount;
                    } else {
                        // no offer product
                        $singleItemPrice = @$productVarOlddata->variant_price_offer;

                        $itemTotalPrice = @$productVarOlddata->variant_price_offer * $value['quantity'];
                        $price += $itemTotalPrice;

                        $itemDiscount = @$productVarOlddata->variant_price_regular - @$productVarOlddata->variant_price_offer;
                        $itemTotalDiscount = $itemDiscount * $value['quantity'];
                        $itemTotalTaxPrice = 0; // tax to be calculated

                        $discount += $itemTotalDiscount;
                    }

                    $itemRegularPriceTotal += ($productVarOlddata->variant_price_regular * $value['quantity']);


                    $lastOrderData = Trn_Order::find($orderId);

                    $data2 = [
                        'order_id' => $orderId,
                        'order_number' => $lastOrderData->order_number,
                        'customer_id' => $request['customer_id'],
                        'product_id' => $productData->product_id,
                        'product_variant_id' => $value['product_variant_id'],
                        'quantity' => $value['quantity'],
                        'unit_price' =>  $singleItemPrice,
                        'tax_amount' => $itemTotalTaxPrice,
                        'discount_amount' => $itemTotalDiscount,
                        'total_amount' => $itemTotalPrice,
                        'is_store_ticked' => 0,
                        'is_db_ticked' => 0,
                        'created_at'         => Carbon::now(),
                        'updated_at'         => Carbon::now(),
                    ];
                    Trn_OrderItem::insert($data2);
                }


                $orderUpdate = Trn_Order::find($orderId);
                $orderUpdate->order_total_amount = $price;
                $deliveryCharge = Helper::findDeliveryCharge($request->customer_id, $request->customer_address_id); // delivery charge
                $orderUpdate->delivery_charge = $deliveryCharge;
                $orderUpdate->packing_charge = 0;

                $totalOrdAmount = ($price - 0) + $deliveryCharge;
                @$couponData = Mst_Coupon::find($request->coupon_id);
                $couponDiscount = floatval(Helper::reduceCouponDiscount($request->customer_id, @$couponData->coupon_code, $totalOrdAmount));

                $orderUpdate->amount_reduced_by_coupon = $couponDiscount;
                $orderUpdate->update();




                // $storeDatas = Trn_StoreAdmin::where('store_id', $request->store_id)->where('role_id', 0)->first();
                // $customerDevice = Trn_CustomerDeviceToken::where('customer_id', $request->customer_id)->get();
                // $storeDevice = Trn_StoreDeviceToken::where('store_admin_id', $storeDatas->store_admin_id)->where('store_id', $request->store_id)->get();
                // $orderdatas = Trn_store_order::find($order_id);

                // foreach ($storeDevice as $sd) {
                //     $title = 'New order arrived';
                //     $body = 'New order with order id ' . $orderdatas->order_number . ' has been saved successully..';
                //     $data['response'] =  $this->storeNotification($sd->store_device_token, $title, $body);
                // }


                // $storeWeb = Trn_StoreWebToken::where('store_admin_id', $storeDatas->store_admin_id)->where('store_id', $request->store_id)->get();
                // foreach ($storeWeb as $sw) {
                //     $title = 'New order arrived';
                //     $body = 'New order with order id ' . $orderdatas->order_number . ' has been saved successully..';
                //     $data['response'] =  Helper::storeNotifyWeb($sw->store_web_token, $title, $body);
                // }

                // foreach ($customerDevice as $cd) {
                //     $title = 'Order Placed';
                //     $body = 'Your order with order id ' . $orderdatas->order_number . ' has been saved successully..';

                //     //   $title = 'Title';
                //     //  $body = 'Body';

                //     $data['response'] =  $this->customerNotification($cd->customer_device_token, $title, $body);
                // }



                $data['status'] = 1;
                $data['orderId'] = $orderId;
                $data['orderNumber'] = $lastOrderData->order_number;

                $data['message'] = "Order saved.";
                return response($data);
            } else {
                $data['status'] = 0;
                $data['message'] = "failed";
                        $data['inputData'] = $request->all();

                $data['errors'] = $validator->errors();
                return response($data);
            }
        } catch (\Exception $e) {

            $response = ['status' => 0, 'message' => $e->getMessage(),'inputData' => $request->all()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => 0, 'message' => $e->getMessage(),'inputData' => $request->all()];
            return response($response);
        }
    }
}
