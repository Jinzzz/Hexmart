<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Sys_DisputeStatus;
use App\Models\admin\Sys_OrderStatus;
use App\Models\admin\Trn_Dispute;
use App\Models\admin\Trn_Order;
use App\Models\admin\Mst_ConfigurePoints;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_Setting;
use App\Models\admin\Mst_WorkingDay;
use App\Models\admin\Trn_OrderItem;
use App\Models\admin\Trn_ServiceAreaSplit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listoffer(Request $request)
    {
        $pageTitle = "Offer Zone";
        $offers = Mst_OfferZone::orderBy('offer_id', 'DESC')->get();
        return view('admin.elements.offers.list', compact('offers', 'pageTitle'));
    }

    public function createoffer(Request $request)
    {
        $pageTitle = "Create Offer";
        $categories = Mst_ItemCategory::all();
        return view('admin.elements.offers.create', compact('pageTitle', 'categories'));
    }

    public function editoffer(Request $request, $offer_id)
    {
        $pageTitle = "Edit Offer";
        $categories = Mst_ItemCategory::all();
        $offer = Mst_OfferZone::find($offer_id);
        return view('admin.elements.offers.edit', compact('pageTitle', 'offer', 'categories'));
    }


    public function storeoffer(Request $request, Mst_OfferZone $offer)
    {
        $data = $request->except('_token');
        $validator = Validator::make(
            $request->all(),
            [
                'product_variant_id'       => 'required',
                'offer_price'       => 'required',
            ],
            [
                'product_variant_id.required'         => 'Product Variant required',
                'offer_price.required'        => 'Offer price required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $offer->product_variant_id         = $request->product_variant_id;
            $offer->offer_price         = $request->offer_price;
            $offer->date_start         = $request->date_start;
            $offer->time_start         = $request->time_start;
            $offer->date_end         = $request->date_end;
            $offer->time_end         = $request->time_end;
            $offer->link         = $request->link;
            $offer->is_active         = $request->is_active;
            $offer->save();

            return redirect('/admin/offers/list')->with('status', 'Offer added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeoffer(Request $request, $offer_id)
    {
        try {
            Mst_OfferZone::where('offer_id', $offer_id)->delete();
            return redirect()->route('admin.offers')->with('status', 'Offer deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }



    public function updateoffer(Request $request, $offer_id)
    {
        $data = $request->except('_token');
        $validator = Validator::make(
            $request->all(),
            [
                'product_variant_id'       => 'required',
                'offer_price'       => 'required',
            ],
            [
                'product_variant_id.required'         => 'Product Variant required',
                'offer_price.required'        => 'Offer price required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $offer = Mst_OfferZone::find($offer_id);
            $offer->product_variant_id         = $request->product_variant_id;
            $offer->offer_price         = $request->offer_price;
            $offer->date_start         = $request->date_start;
            $offer->time_start         = $request->time_start;
            $offer->date_end         = $request->date_end;
            $offer->time_end         = $request->time_end;
            $offer->link         = $request->link;
            $offer->is_active         = 1;
            $offer->update();

            return redirect('/admin/offers/list')->with('status', 'Offer updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function GetItemByCategory(Request $request)
    {
        $item_category_id = $request->item_category_id;

        $products  = Mst_ProductVariant::join('mst__products', 'mst__products.product_id', '=', 'mst__product_variants.product_id')
            ->select("mst__products.product_name", "mst__product_variants.variant_name", "mst__product_variants.product_variant_id")
            ->where("mst__products.item_category_id", '=', $item_category_id)
            ->get()->toArray();
        //dd($products);
        return response($products);
    }


    public function editStatusoffer(Request $request)
    {
        $offer_id = $request->offer_id;
        if ($c = Mst_OfferZone::findOrFail($offer_id)) {
            if ($c->is_active == 0) {
                Mst_OfferZone::where('offer_id', $offer_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_OfferZone::where('offer_id', $offer_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }


    public function workingDaysUpdate(Request $request)
    {
        // dd($request->all());

        $start = $request->start;
        $end = $request->end;
        $day = $request->day;

        $s_count = Mst_WorkingDay::count();

        if ($s_count > 1) {
            Mst_WorkingDay::all()->delete();
        }


        $i = 0;
        foreach ($request->day as $s) {
            $info = [
                'day' => $day[$i],
                'time_start' =>  $start[$i],
                'time_end' => $end[$i],
            ];

            //print_r($info);die;

            Mst_WorkingDay::insert($info);
            $i++;
        }
        return  redirect()->back()->with('status', 'Working days updated successfully.');
    }



    public function workingDays(Request $request)
    {
        $pageTitle = "Working Days";
        $time_slots_count = Mst_WorkingDay::count();
        $time_slots = Mst_WorkingDay::all();
        return view('admin.elements.settings.working_days', compact('time_slots', 'time_slots_count', 'pageTitle'));
    }
    public function Profile(Request $request)
    {
        $admin = User::find(auth()->user()->id);
        return view('admin.elements.profile.profile', compact('admin'));
    }

    // public function editProfile(Request $request)
    // {
    //     $admin = User::find(auth()->user()->id);
    //     return view('admin.elements.profile.profile', compact('admin'));
    // }

    public function updateProfile(Request $request)
    {
        $id =  auth()->user()->id;

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name'       => 'required',
                    'email'       => 'required|unique:users,email,' . $id . ',id',
                    'password' => 'confirmed',
                ],
                [
                    'name.required'         => 'Name required',
                    'email.required'         => 'Email required',
                    'email.unique'         => 'Email exists',
                    'password.required'         => 'Password required',
                    'password.confirmed'         => 'Passwords not matching',
                    'password.min'         => 'Password should have 6 character',
                ]
            );
            if (!$validator->fails()) {
              

                $user = User::find($id);
                
                $user->name = $request->name;
                $user->email = $request->email;
                if($request->filled('password'))
                {
                $user->password = Hash::make($request->password);
                $user->update();
                Auth::login($user);
                }
                else{
                    $user->update(); 
                }

                return redirect()->route('admin.profile')->with('status', 'Profile updated successfully');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }


    public function time_slot(Request $request)
    {
        $pageTitle = "Working Days";

        $time_slots_count = Mst_WorkingDay::count();
        $time_slots = Mst_WorkingDay::get();


        return view('store.elements.time_slot.create', compact('time_slots_count', 'time_slots', 'store', 'pageTitle', 'store_id'));
    }


    public function Settings(Request $request)
    {
        $pageTitle = 'Settings';
        $settings = Mst_Setting::first();
        $admin_settings = Trn_ServiceAreaSplit::orderBy('sas_id', 'DESC')->get();
        $settingcount = Trn_ServiceAreaSplit::count();

        return view('admin.elements.settings.create', compact('admin_settings', 'settingcount', 'pageTitle', 'settings'));
    }

    public function UpdateSettings(Request $request)
    {

        if (isset($request->start) < 1) {
            return redirect()->back();
        }

        $s_count = Trn_ServiceAreaSplit::count();

        if ($s_count >= 1) {
            Trn_ServiceAreaSplit::where('service_start', '!=', null)->delete();
        }

        $i = 0;
        $start = $request->start;
        $end = $request->end;
        $delivery_charge = $request->delivery_charge;
        $packing_charge = $request->packing_charge;

        $data = [

            'service_area' => $request->service_area,
            'order_number_prefix' => $request->order_number_prefix,
            'is_tax_included' => $request->is_tax_included,

        ];
        if (Mst_Setting::count() > 0)
            Mst_Setting::first()->update($data);
        else
            Mst_Setting::create($data);

        foreach ($request->start as $s) {
            $info = [
                'service_start' => $start[$i],
                'service_end' =>  $end[$i],
                'delivery_charge' => $delivery_charge[$i],
                'packing_charge' => $packing_charge[$i],

            ];
            Trn_ServiceAreaSplit::insert($info);
            $i++;
        }

        return redirect()->back()->with('status', 'Settings updated successfully.');
    }

    public function adminHome(Request $request)
    {
        return view('admin.home');
    }

    public function configurePoints(Request $request)
    {
        $pageTitle = "Configure Points";
        $configure_points = null;
        if (Mst_ConfigurePoints::find(1)) {
            $configure_points = Mst_ConfigurePoints::find(1);
        } else {
            $cp = new Mst_ConfigurePoints;
            $cp->registraion_points = null;
            $cp->first_order_points = null;
            $cp->referal_points = null;
            $cp->rupee = null;
            $cp->rupee_points = null;
            $cp->order_amount = null;
            $cp->order_points = null;
            $cp->redeem_percentage = null;
            $cp->max_redeem_amount = null;
            $cp->joiner_points = null;
            $cp->save();
            $configure_points = Mst_ConfigurePoints::find(1);
        }
        return view('admin.elements.customer_rewards.edit', compact('configure_points', 'pageTitle'));
    }

    public function updateConfigurePoints(Request $request)
    {
        //dd($request->all());
        $cp = Mst_ConfigurePoints::find(1);
        $cp->registraion_points = $request->registraion_points;
        $cp->first_order_points = $request->first_order_points;
        $cp->referal_points = $request->referal_points;
        $cp->rupee = $request->rupee;
        $cp->rupee_points = $request->rupee_points;
        $cp->order_amount = $request->order_amount;
        $cp->order_points = $request->order_points;
        $cp->redeem_percentage = $request->redeem_percentage;
        $cp->max_redeem_amount = $request->max_redeem_amount;
        $cp->joiner_points = $request->joiner_points;
        $cp->update();
        return redirect()->back()->with('status', 'Configure Points updated successfully.');
    }

    public function listDisputes(Request $request)
    {
        $pageTitle = "Disputes";
        $disputes = Trn_Dispute::orderBy('issue_id', 'DESC')->get();
        $disputeStatus = Sys_DisputeStatus::all();
        return view('admin.elements.disputes.list', compact('disputes', 'disputeStatus', 'pageTitle'));
    }

    public function viewDisputeStatus(Request $request)
    {
        $dispute_id = $request->dispute_id;
        $data = Trn_Dispute::where('dispute_id', $dispute_id)->first();
        $data->dispute_status = $data->disputeStatusData->dispute_status;
        $data->issue = @$data->issueData->issue;
        $data->issue_type = @$data->issueData->issueTypeData->issue_type;
        $data->customer_name = @$data->customerData->customer_name;
        $data->customer_mobile = @$data->customerData->customer_mobile;
        $data->order_number = @$data->orderData->order_number;
        $data->order_total_amount = @$data->orderData->order_total_amount;
        return json_encode($data);
    }


    public function viewOrder(Request $request)
    {
        $order_id = $request->order_id;
        $data = Trn_Order::where('order_id', $order_id)->first();
        // $data2 = Trn_OrderItem::where('order_id', $order_id)->get();
        $data->customer_name = @$data->customerData->customer_name;
        $data->customer_mobile = @$data->customerData->customer_mobile;
        $data->order_number = @$data->order_number;
        $data->order_total_amount = @$data->order_total_amount;
        return json_encode($data);
    }


    public function findDisputeStatus(Request $request)
    {
        $dispute_id = $request->dispute_id;
        $data = Trn_Dispute::where('dispute_id', $dispute_id)
            ->select('dispute_id', 'dispute_status_id')->first();
        $data->dispute_status = $data->disputeStatusData->dispute_status;

        return json_encode($data);
    }

    public function updateDisputeStatus(Request $request)
    {
        $dispute_id = $request->dispute_id;
        $dispute_status_id = $request->dispute_status_id;

        $data = array();
        $data['dispute_status_id'] = $dispute_status_id;

        if (Trn_Dispute::where('order_id', $dispute_id)->update(['dispute_status_id' => $dispute_status_id])) {
            $data = Trn_Dispute::find($dispute_id);
            $data->dispute_status = $data->disputeStatusData->dispute_status;
            return json_encode($data);
        } else {
            return false;
        }
    }

    public function listOrders(Request $request)
    {
        $pageTitle = "Order";
        $orders = Trn_Order::orderBy('order_id', 'DESC')->get();
        $orderStatus = Sys_OrderStatus::orderBy('order_status_id', 'ASC')->get();
        return view('admin.elements.order.list', compact('orders', 'orderStatus', 'pageTitle'));
    }

    public function findOrderStatus(Request $request)
    {
        $orderId = $request->order_id;
        $orderData = Trn_Order::where('order_id', $orderId)
            ->select('order_id', 'order_status_id', 'order_number')->first();
        $orderData->status = $orderData->orderStatusData->status;
        return json_encode($orderData);
    }

    public function updateOrderStatus(Request $request)
    {
        $orderId = $request->order_id;
        $orderStatusId = $request->order_status_id;

        $orderData = array();
        $orderData['order_status_id'] = $orderStatusId;

        if (Trn_Order::where('order_id', $orderId)->update(['order_status_id' => $orderStatusId])) {
            $orderDatas = Trn_Order::find($orderId);
            $orderDatas->status = $orderDatas->orderStatusData->status;
            return json_encode($orderDatas);
        } else {
            return false;
        }
    }
}
