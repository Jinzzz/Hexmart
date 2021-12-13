<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\admin\Mst_Coupon;
use Response;
use Image;
use DB;
use Hash;
use Carbon\Carbon;
use Crypt;
use Mail;
use PDF;
use Auth;
use Validator;

class CouponController extends Controller
{



    public function couponList(Request $request)
    {
        $data = array();

        try {

            $today = Carbon::now()->toDateTimeString();

            $couponDetail = Mst_Coupon::where('coupon_status', 1);
            //  $couponDetail = $couponDetail->whereNotIn('coupon_id',$usedCoupinIds);

            $couponDetail = $couponDetail->whereDate('valid_from', '<=', $today)->whereDate('valid_to', '>=', $today);
            $couponDetail = $couponDetail->orderBy('coupon_id', 'DESC')->get();


            $data['couponDetails'] = $couponDetail;
            $data['status'] = 1;
            $data['message'] = "success";

            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];

            return response($response);
        }
    }
}
