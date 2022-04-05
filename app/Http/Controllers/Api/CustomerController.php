<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Trn_CustomerOtpVerify;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\admin\Mst_Coupon;
use App\Models\admin\Trn_CustomerAddress;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_Brand;
use Response;
use Image;
use DB;
use Carbon\Carbon;
use Crypt;
use Mail;
use PDF;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function listAddress(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $customerData  = Trn_CustomerAddress::where('customer_id', $request->customer_id)->get();
                $data['customerAddressData'] = $customerData;
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


    public function editAddress(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_address_id) && $cusAddr =  Trn_CustomerAddress::find($request->customer_address_id)) {
                if (isset($request->customer_id) && $cusAddr =  Mst_Customer::find($request->customer_id)) {
                    $validator = Validator::make(
                        $request->all(),
                        [
                            'customer_id' => 'required',
                            'name' => 'required',
                            'phone' => 'required',
                        ]
                    );

                    if (!$validator->fails()) {

                        $addr = Trn_customerAddress::find($request->customer_address_id);
                        $addr->customer_id = $request->customer_id;

                        if (isset($request->name))
                            $addr->name = $request->name;
                        else
                            $addr->name = $cusAddr->customer_name;

                        if (isset($request->phone))
                            $addr->phone = $request->phone;
                        else
                            $addr->phone = $cusAddr->customer_mobile;


                        $addr->alternative_phone = $request->alternative_phone;
                        $addr->pincode = $request->pincode;
                        $addr->state = $request->state;
                        $addr->city = $request->city;
                        $addr->street = $request->street;
                        $addr->house = $request->house;
                        $addr->landmark = $request->landmark;

                        $addr->longitude = $request->longitude;
                        $addr->latitude = $request->latitude;
                        $addr->is_home_address = $request->is_home_address;
                        $addr->is_active = 1;


                        if ($request->is_default != 1) {
                            $addr->is_default = 0;
                        } else {
                            $countAddress =  Trn_customerAddress::where('customer_id', $request->customer_id)
                                ->update(['is_default' => 0]);
                            $addr->is_default = 1;
                        }

                        if ($addr->save()) {
                            $data['status'] = 1;
                            $data['message'] = "Address edited";
                            return response($data);
                        } else {
                            $data['status'] = 0;
                            $data['message'] = "failed";
                            return response($data);
                        }
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "Address required";
                        return response($data);
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Customer not found ";
                    return response($data);
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer address not found ";
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


    public function addAddress(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && $cusAddr =  Mst_Customer::find($request->customer_id)) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'customer_id' => 'required',
                        // 'name' => 'required',
                        // 'phone' => 'required',
                    ]
                );

                if (!$validator->fails()) {

                    $addr = new Trn_customerAddress;
                    $addr->customer_id = $request->customer_id;
                    $addr->address = $request->address;

                    if (isset($request->name))
                        $addr->name = $request->name;
                    else
                        $addr->name = $cusAddr->customer_name;

                    if (isset($request->phone))
                        $addr->phone = $request->phone;
                    else
                        $addr->phone = $cusAddr->customer_mobile;

                    $addr->alternative_phone = $request->alternative_phone;
                    $addr->pincode = $request->pincode;
                    $addr->state = $request->state;
                    $addr->city = $request->city;
                    $addr->street = $request->street;
                    $addr->house = $request->house;
                    $addr->landmark = $request->landmark;

                    $addr->longitude = $request->longitude;
                    $addr->latitude = $request->latitude;
                    $addr->is_home_address = $request->is_home_address;
                    $addr->is_active = 1;


                    if ($request->is_default != 1) {
                        $addr->is_default = 0;
                    } else {
                        $countAddress =  Trn_customerAddress::where('customer_id', $request->customer_id)
                            ->update(['is_default' => 0]);
                        $addr->is_default = 1;
                    }

                    if ($addr->save()) {
                        $data['status'] = 1;
                        $data['message'] = "Address added";
                        return response($data);
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "failed";
                        return response($data);
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Address required";
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






    public function removeAddress(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_address_id) && Trn_customerAddress::find($request->customer_address_id)) {
                $addr = Trn_customerAddress::find($request->customer_address_id);
                if ($addr->delete()) {
                    if ($addr->is_default == 1) {
                        $cus = Trn_customerAddress::where('customer_id', $addr->customer_id)->first();
                        Trn_customerAddress::where('customer_address_id', $cus->customer_address_id)->update(['is_default' => 1]);
                    }
                    $data['status'] = 1;
                    $data['message'] = "Address removed";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "failed";
                    return response($data);
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Address not found ";
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


    public function viewAddress(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_address_id) && Trn_customerAddress::find($request->customer_address_id)) {
                $addressData  = Trn_customerAddress::find($request->customer_address_id);
                $addressData->customer_data =  $addressData->customerData;
                $data['addressData'] = $addressData;
                $data['status'] = 1;
                $data['message'] = "success";
                return response($data);
            } else {
                $data['status'] = 0;
                $data['message'] = "Address not found ";
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

    public function ViewProfile(Request $request)
    {
        $data = array();

        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $customerData  = Mst_Customer::find($request->customer_id);
                $customerData->addresses =  $customerData->addresses;
                $data['customerData'] = $customerData;
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



    function saveCustomer(Request $request, Mst_Customer $customer, Trn_CustomerOtpVerify $otp_verify)
    {
        $data = array();
        try {

            $validator = Helper::validateCustomer($request->all());
            if (!$validator->fails()) {

                $customer->customer_name            = $request->customer_name;
                $customer->customer_email   = $request->customer_email;
                $customer->customer_mobile   = $request->customer_mobile;
                $customer->password              = Hash::make($request->password);
                $customer->is_active       = 1;
                $customer->is_otp_verified       = 0;
                $customer->save();
                $customer_id = DB::getPdo()->lastInsertId();

                if (isset($customer_id)) {
                    $ca = new Trn_CustomerAddress;
                    $ca->customer_id = $customer_id;
                    $ca->name = $request->customer_name;
                    $ca->phone = $request->customer_mobile;
                    $ca->pincode = $request->pincode;
                    $ca->state = $request->state;
                    $ca->city = $request->city;
                    $ca->house = $request->house;
                    $ca->street = $request->street;
                    $ca->landmark = $request->landmark;
                    $ca->longitude = $request->longitude;
                    $ca->latitude = $request->latitude;
                    $ca->is_default = 1;
                    $ca->is_active = 1;
                    $ca->save();
                }

                $customer_otp =  rand(1000, 9999);
                $customer_otp_expirytime = Carbon::now()->addMinute(10);
                $otp_verify->customer_id                 = $customer_id;
                $otp_verify->otp_expirytime     = $customer_otp_expirytime;
                $otp_verify->otp                 = $customer_otp;
                $otp_verify->save();

                $data['customer_id'] = $customer_id;
                $data['otp'] = $customer_otp;
                $data['status'] = 1;
                $data['message'] = "Customer Registration Success";
            } else {
                $data['errors'] = $validator->errors();
                $data['status'] = 0;
                $data['message'] = "Customer Registration Failed";
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


    public function updateProfile(Request $request)
    {
        $data = array();




        try {

            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {


                $validator =   $validate = Validator::make(
                    $request->all(),
                    [
                        'customer_name' => 'required',
                        'password'  => 'required|min:5|same:password_confirmation',


                    ],
                    [
                        'customer_name.required'                => 'Customer name required',
                        'password.required'                  => 'Password required ',

                    ]
                );

                if (!$validator->fails()) {
                    $customer = Mst_Customer::find($request->customer_id);
                    $customer->customer_name            = $request->customer_name;
                    $customer->customer_email   = $request->customer_email;
                    $customer->place   = $request->place;

                    $customer->customer_gender   = $request->customer_gender;
                    $customer->customer_dob   = $request->customer_dob;

                    $customer->longitude   = $request->longitude;
                    $customer->latitude   = $request->latitude;
                    if (isset($request->password))
                        $customer->password              = Hash::make($request->password);
                    $customer->save();

                    $data['status'] = 1;
                    $data['message'] = "Profile updated";
                } else {
                    $data['errors'] = $validator->errors();
                    $data['status'] = 0;
                    $data['message'] = "Failed";
                }

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



    public function loginCustomer(Request $request)
    {
        $data = array();
        try {
            $phone = $request->input('customer_mobile');
            $passChk = $request->input('password');
            // $devType = $request->input('device_type');
            //    $devToken = $request->input('device_token');

            $validator = Validator::make(
                $request->all(),
                [
                    'customer_mobile' => 'required',
                    'password' => 'required',
                    // 'device_type' => 'required',
                    // 'device_token' => 'required',
                ],
                [
                    'customer_mobile.required' => "Customer Mobile Number is required",
                    'password.required' => "Password is required",
                    // 'device_type.required' => "Device Type is required",
                    // 'device_toke.required' => "Device Token is required",
                ]
            );
            // dd($validator);
            if (!$validator->fails()) {
                // $custCheck = Mst_Customer::where('customer_mobile', '=', $phone)->first();

                // $loginData = array('customer_mobile' => $request->customer_mobile, 'password' => $request->password);
                // if ($custCheck) {
                //     $accessToken = $custCheck->createToken('authToken')->accessToken;
                //     return response(['message' => "Valid details", "accessToken" => $accessToken]);
                // } else {
                //     return response(['message' => "Invalid details"]);
                // }


                $custCheck = Mst_Customer::where('customer_mobile', '=', $phone)->first();
                $today = Carbon::now()->toDateString();

                if ($custCheck) {

                    if (Hash::check($passChk, $custCheck->password)) {
                        if ($custCheck->is_active != 0) {
                            if ($custCheck->is_otp_verified != 0) {

                                //dd($custCheck);

                                //  dd(Auth::guard('api')->user());

                                // if (Auth::guard('api')->attempt(['customer_mobile' => request('customer_mobile'), 'password' => request('password')])) {
                                //  $custCheck = Mst_Customer::where('customer_mobile', '=', $phone)->first();

                                // dd($user);
                                // $data['token'] =  $user->createToken('authToken', ['customer'])->accessToken;

                                $data['status'] = 1;
                                $data['message'] = "Login Success";
                                $data['token'] =  $custCheck->createToken('authToken', [])->accessToken;
                                $data['customer_id'] = $custCheck->customer_id;

                                // $storeData = Mst_store::find($custCheck->store_id);
                                // // $storeData->online_status = 1;
                                // // $storeData->update();

                                // $data['online_status'] = $storeData->online_status;
                                // $data['store_id'] = $custCheck->store_id;
                                // $data['store_admin_id'] = $custCheck->store_admin_id;
                                // $data['store_name'] = $custCheck->admin_name;
                                // $data['store_username'] = $custCheck->username;
                                // $data['access_token'] = $custCheck->createToken('authToken')->accessToken;
                                // }
                            } else {
                                $data['status'] = 2;
                                $data['customer_id'] = $custCheck->customer_id;

                                $data['message'] = "OTP not verified";
                            }
                        } else {


                            $data['status'] = 4;
                            $data['message'] = "Profile not Activated";
                        }
                    } else {
                        $data['status'] = 3;
                        $data['message'] = "Mobile Number or Password is Invalid";
                    }
                } else {
                    $data['status'] = 0;
                    $data['message'] = "Invalid Login Details";
                }
            } else {
                $data['errors'] = $validator->errors();
                $data['message'] = "Login Failed";
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

    public function updatePassword(Request $request)
    {
        $data = array();
        try {
            if (isset($request->customer_id) && Mst_Customer::find($request->customer_id)) {
                $validator = Validator::make(
                    $request->all(),
                    [

                        'password' => 'required|confirmed',

                    ],
                    [
                        'store_admin_id.required'        => 'store admin id required',
                        'old_password.required'        => 'Old password required',
                        'password.required'        => 'Password required',
                        'password.confirmed'        => 'Passwords not matching',
                    ]
                );

                if (!$validator->fails()) {
                    $custCheck = Mst_Customer::where('customer_id', '=', $request->customer_id)->first();

                    if (Hash::check($request->old_password, $custCheck->password)) {
                        $data20 = [
                            'password'      => Hash::make($request->password),
                        ];
                        Mst_Customer::where('customer_id', $request->customer_id)->update($data20);

                        $data['status'] = 1;
                        $data['message'] = "Password updated successfully.";
                        return response($data);
                    } else {
                        $data['status'] = 0;
                        $data['message'] = "Old password incorrect.";
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
                $data['message'] = "Customer not found.";
                return response($data);
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






    public function verifyOtp(Request $request)
    {
        $data = array();
        try {
            $otp = $request->customer_otp;

            $customer_id = $request->customer_id;

            $otp_verify =  Trn_CustomerOtpVerify::where('customer_id', '=', $customer_id)->latest()->first();
            // dd($otp_verify);
            if ($otp_verify) {
                $customer_otp_expirytime = $otp_verify->otp_expirytime;
                $current_time = Carbon::now()->toDateTimeString();
                $customer_otp =  $otp_verify->otp;

                if ($customer_otp == $request->customer_otp) {
                    if ($current_time < $customer_otp_expirytime) {
                        $customer = Mst_Customer::Find($customer_id);
                        $customer->is_active = 1;
                        $customer->is_otp_verified = 1;
                        $customer->update();

                        $data['status'] = 1;
                        $data['message'] = "OTP Verifiction Success";
                    } else {
                        $data['status'] = 2;
                        $data['message'] = "OTP expired.click on resend OTP";
                    }
                } else {
                    $data['status'] = 3;
                    $data['message'] = "Incorrect OTP entered. Please enter a valid OTP.";
                }
            } else {
                $data['status'] = 3;
                $data['message'] = "OTP not found. Please click on resend OTP.";
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

/*
   Description : Customer Resend OTP 
   Date        : 25/3/2022

*/
    public function resend_Otp(Request $request,Mst_Customer $customer, Trn_CustomerOtpVerify $otp_verify){
        $data = array();
          try{
              $customer_id = $request->customer_id;
              if($customer_id)
              {
              $otp_verify = Trn_CustomerOtpVerify::where('customer_id','=',$customer_id)->latest()->first();
              $currentDate = date("Y-m-d H:i:s");
              $currentDate_timestamp = strtotime($currentDate);
              $endtime = strtotime("+10 minutes", $currentDate_timestamp);
              $endminute = date("Y-m-d H:i:s", $endtime);
                if($otp_verify !== null && $currentDate<=$endminute){
                      
                      $extented_time =$endminute;
                      $otp_verify->otp_expirytime = $extented_time;
                      $otp_verify->update();
                      $data['status'] = 1;
                      $data['otp'] = $otp_verify->otp;
                      $data['message'] = "OTP resent Success.";
                     
                  }else{
                      $cust_otp_verify = new Trn_CustomerOtpVerify;
                      $customer_otp =  rand ( 1000 , 9999 );
                      $customer_otp_expirytime = Carbon::now()->addMinute(10);
                      $cust_otp_verify->customer_id        = $customer_id;
                      $cust_otp_verify->otp_expirytime     = $customer_otp_expirytime;
                      $cust_otp_verify->otp                = $customer_otp;
                      $cust_otp_verify->save();
                      $data['status'] = 2;
                      $data['otp'] = $customer_otp;
                      $data['message'] = "OTP registerd successfully. Please verify OTP.";
                  }
              }else{
                  $data['status'] = 0;
                  $data['message'] = "Customer Doesn't Exist.";
              }
         
          
            return response($data);
         
            }catch (\Exception $e) {
             $response = ['status' => '0', 'message' => $e->getMessage()];
             return response($response);
          }catch (\Throwable $e) {
              $response = ['status' => '0','message' => $e->getMessage()];
              return response($response);
          }
  
      }


    public function resendOtp(Request $request, Mst_Customer $customer, Trn_CustomerOtpVerify $otp_verify)
    {
        $data = array();
        try {
            $customer_id = $request->customer_id;
            if ($customer_id) {
                $otp_verify = Trn_CustomerOtpVerify::where('customer_id', '=', $customer_id)->latest()->first();
                if ($otp_verify !== null) {
                    $customer_otp_id = $otp_verify->customer_otp_id;
                    $otp_verify = Trn_CustomerOtpVerify::Find($customer_otp_id);
                    $extented_time = Carbon::now()->addMinute(10);
                    $otp_verify->otp_expirytime = $extented_time;
                    $otp_verify->update();
                    $data['status'] = 1;
                    $data['otp'] = $otp_verify->otp;
                    $data['message'] = "OTP resent Success.";
                } else {
                    $otp_verify = new Trn_CustomerOtpVerify;
                    $customer_otp =  rand(1000, 9999);
                    $extented_time = Carbon::now()->addMinute(10);
                    $otp_verify->customer_id                 = $customer_id;
                    $otp_verify->otp_expirytime     = $extented_time;
                    $otp_verify->otp                 = $customer_otp;
                    $otp_verify->save();
                    $data['status'] = 2;
                    $data['otp'] = $customer_otp;
                    $data['message'] = "OTP genarated successfully. Please verify OTP.";
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Customer Doesn't Exist.";
            }


            return response($data);
        } catch (\Exception $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];
            return response($response);
        } catch (\Throwable $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];
            return response($response);
        }
    }
/*
   Description : Forgot-password 
   Date        : 4/4/2022

*/

    public function forgotpassword(Request $request)
    {
        $data = array();
        try {
                $validator = Validator::make($request->all(),
                [

                'customer_email' => 'required|email',

                ],
                [
                'customer_email.required'        => 'Customer Email required',
                ]
                );

                if (!$validator->fails()) {
                $email = Mst_Customer::where('customer_email', '=', $request->customer_email)->first();

                if ($email!='') {
                   
                    $data['status'] = 1;
                    $data['message'] = "Send Reset Password link through email.";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Matching Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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

/*
   Description : Reset Password
   Date        : 4/4/2022

*/

    public function reset_password(Request $request)
    {
        $data = array();
        try {
                $validator = Validator::make($request->all(),
                [
                'customer_id'      => 'required',
                'customer_email'   => 'required|email',
                'password'         => 'required|min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:6',

                ],
                [
                'customer_id.required'     => 'Customer ID required',

                'customer_email.required'  => 'Customer Email required',
                'password.required'        => 'Password required',
                'confirm_password.required'=> 'Confirm Password required',

                ]
                );

                if (!$validator->fails()) {
                $cust_id = Mst_Customer::where('customer_id', '=', $request->customer_id)->where('customer_email', '=', $request->customer_email)->first();

                if ($cust_id!='') {
                    $cust_id->customer_email = $request->customer_email;
                    $cust_id->password = Hash::make($request->password);
                    $cust_id->update();
                    $data['status'] = 1;
                    $data['message'] = "successfully Updated the password.";
                    return response($data);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Matching Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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


   /*
   Description : Category wise product filter
   Date        : 4/4/2022

   */

    public function productfilter_list(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'     => 'required',

                ],
                [
                'category_id.required'  => 'Category ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $product!=''&& $product_varient!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Product Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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



   /*
   Description : Sub-Category wise product filter
   Date        : 4/4/2022

   */

    public function subcatproductfilter_list(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'     => 'required',

                ],
                [
                'category_id.required'  => 'Category ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
                 ->first();
                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $product!=''&& $sub_category!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Product Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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



  /*
   Description : Main Sub Category wise product filter
   Date        : 4/4/2022

   */

    public function mainsubproductfilter_list(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'     => 'required',

                ],
                [
                'category_id.required'  => 'Category ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $sub_category = Mst_ItemSubCategory::where('item_category_id', $category->item_category_id)
                 ->first();
                $multi_Cat = Mst_ItemLevelTwoSubCategory::where('item_sub_category_id', $sub_category->item_sub_category_id)
                 ->first();
                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->where('item_sub_category_id', $sub_category->item_sub_category_id)->where('iltsc_id', $multi_Cat->iltsc_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $product!=''&& $sub_category!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Product Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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

  /*
   Description : Product brand  wise product filter
   Date        : 5/4/2022

   */

    public function product_brandfilter(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'     => 'required',
                'brand_id'     => 'required',

                ],
                [
                'category_id.required'  => 'Category ID required',
                'brand_id.required'  => 'Brand ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $brand = Mst_Brand::where('brand_id', '=', $request->brand_id)->first();

                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->where('brand_id', '=', $brand->brand_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $brand!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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
   
   /*
   Description : Product sub-brand  wise product filter
   Date        : 5/4/2022

   */

    public function product_subactbrandfilter(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'         => 'required',
                'brand_id'            => 'required',
                'item_sub_category_id'=>'required',

                ],
                [
                'category_id.required'=> 'Category ID required',
                'brand_id.required'   => 'Brand ID required',
                'item_sub_category_id'=>'Sub-Category ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $sub_category = Mst_ItemSubCategory::where('item_sub_category_id', $request->item_sub_category_id)
                 ->first();   
                $brand = Mst_Brand::where('brand_id', '=', $request->brand_id)->first();

                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->where('brand_id', '=', $brand->brand_id)->where('item_sub_category_id', '=', $sub_category->item_sub_category_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $brand!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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



   /*
   Description : Product main-sub-brand  wise product filter
   Date        : 5/4/2022

   */

    public function product_mainsubcatbrandfilter(Request $request)
    {
        $data = array();
        try {
              $validator = Validator::make($request->all(),
                [
                'category_id'         => 'required',
                'brand_id'            => 'required',
                'item_sub_category_id'=>'required',
                'iltsc_id'            =>'required',

                ],
                [
                'category_id.required'=> 'Category ID required',
                'brand_id.required'   => 'Brand ID required',
                'item_sub_category_id'=>'Sub-Category ID required',
                'iltsc_id'            =>'Main-Sub-Category ID required',

                ]
                );

                if (!$validator->fails()) {
                $category = Mst_ItemCategory::where('item_category_id', '=', $request->category_id)->first();
                $sub_category = Mst_ItemSubCategory::where('item_sub_category_id', $request->item_sub_category_id)
                 ->first();   
                $multi_Cat = Mst_ItemLevelTwoSubCategory::where('iltsc_id', $request->iltsc_id)
                 ->first();
                $brand = Mst_Brand::where('brand_id', '=', $request->brand_id)->first();

                $product = Mst_Product::where('item_category_id', '=', $category->item_category_id)->where('brand_id', '=', $brand->brand_id)->where('item_sub_category_id', '=', $sub_category->item_sub_category_id)->where('iltsc_id', '=', $multi_Cat->iltsc_id)->get();
                foreach ($product as $val)
                {
                    $product_data[] = [$val->product_id];
                }
                $pageNumber=4;
                $product_varient = Mst_ProductVariant::whereIn('product_id', $product_data)->orderBy('variant_name', 'asc')->where('stock_count','!=',null)->paginate($pageNumber);

                if ($category!=''&& $brand!='') {
                    $data['status'] = 1;
                    $data['message'] = "Products.";
                    return response($product_varient);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "No Records Fount.";
                    return response($data);
                }
                } 
                else {
                    $data['status'] = 0;
                    $data['errors'] = $validator->errors();
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

}