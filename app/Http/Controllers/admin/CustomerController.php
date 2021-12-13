<?php

namespace App\Http\Controllers\admin;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;
use DB;
use Carbon\Carbon;
use Crypt;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Mst_CustomerGroup;
use App\Models\admin\Trn_CustomerGroupCustomers;
use App\Models\admin\Trn_CustomerReward;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function listCustomeRewards(Request $request)
    {
        $pageTitle = "Customer Rewards";
        $customer_rewards = Trn_CustomerReward::orderBy('customer_reward_id', 'DESC')->get();
        // dd($customers);

        if ($_GET) {

            // $datefrom = $request->date_from;
            // $dateto = $request->date_to;

            // $a1 = Carbon::parse($request->date_from)->startOfDay();
            // $a2  = Carbon::parse($request->date_to)->endOfDay();
            // $customer_name = $request->customer_name;
            // $query = Trn_CustomerReward::join('mst__customers', 'mst__customers.customer_id', 'trn_customer_rewards.customer_id');

            // if (isset($request->date_from) && isset($request->date_to)) {
            //     $query = $query->whereBetween('trn__customer_rewards.created_at', [$a1, $a2]);
            // }

            // if (isset($request->customer_name)) {
            //     $query = $query->where("mst__customers.customer_name like '%$customer_name%' ");
            // }

            // $customer_rewards = $query->get();


            // return view('admin.masters.customer_rewards.list', compact('dateto', 'datefrom', 'customer_rewards', 'pageTitle'));
        }


        return view('admin.elements.customer_rewards.list', compact('customer_rewards', 'pageTitle'));
    }

    public function listCustomerGroupCustomers(Request $request)
    {
        $pageTitle = "Customer Group Customers";
        $customers = Trn_CustomerGroupCustomers::orderBy('cgc_id', 'DESC')->get();
        // dd($customers);
        return view('admin.elements.customer_group.cgc_list', compact('customers', 'pageTitle'));
    }

    public function removeCGC(Request $request)
    {
        Trn_CustomerGroupCustomers::where('cgc_id', '=', $request->cgc_id)->delete();
        return redirect('admin/customer-group-customers/list')->with('status', 'Customer removed from customer group successfully.');
    }

    public function assignCGC(Request $request)
    {
        $pageTitle = "Assign Customer to Customer Group";
        $customers = Mst_Customer::where('is_active', 1)
            ->select('customer_id', 'customer_name', 'customer_mobile')
            ->orderBy('customer_name')->get();
        $customerGroups = Mst_CustomerGroup::where('is_active', 1)->orderBy('customer_group_name')->get();
        return view('admin.elements.customer_group.cgc_assign', compact('customerGroups', 'customers', 'pageTitle'));
    }

    public function storeCGC(Request $request, Trn_CustomerGroupCustomers $cgc)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'customer_group_id'       => 'required',
                'customer_id'       => 'required',
            ],
            [
                'customer_group_id.required'         => 'Customer group required',
                'customer_id.required'         => 'Customer required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            $cgc->customer_group_id = $request->customer_group_id;
            $cgc->customer_id = $request->customer_id;
            $cgc->is_active = 1;
            $cgc->save();

            return redirect('/admin/customer-group-customers/list')->with('status', 'Customer added to Customer group added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function listCustomers(Request $request)
    {
        $pageTitle = "Customers";
        $customers = Mst_Customer::orderBy('customer_id', 'DESC')->get();
        return view('admin.elements.customers.list', compact('customers', 'pageTitle'));
    }

    public function createCustomer(Request $request)
    {
        $pageTitle = "Create Customer";
        return view('admin.elements.customers.create', compact('pageTitle'));
    }

    public function editCustomer(Request $request, $customer_id)
    {
        $pageTitle = "Edit Customer";
        $customer = Mst_Customer::find($customer_id);
        return view('admin.elements.customers.edit', compact('customer', 'pageTitle'));
    }

    public function storeCustomer(Request $request, Mst_Customer $customer)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'customer_name'       => 'required',
                'customer_mobile'       => 'required|unique:mst__customers',
                'password' => 'required|confirmed|min:6',


            ],
            [
                'customer_name.required'         => 'Customer name required',
                'customer_mobile.required'         => 'Customer mobile required',
                'password.required'         => 'Password required',
                'password.confirmed'         => 'Passwords not matching',
                'password.min'         => 'Password should have 6 character',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            $customer->customer_name = $request->customer_name;
            $customer->customer_mobile = $request->customer_mobile;
            $customer->customer_email = $request->customer_email;
            $customer->customer_dob = $request->customer_dob;
            $customer->customer_gender = $request->customer_gender;
            $customer->password = Hash::make($request->password);;
            $customer->is_active = $request->is_active;
            $customer->save();

            return redirect('/admin/customers/list')->with('status', 'Customer added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function updateCustomer(Request $request, $customer_id)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'customer_name'       => 'required',
                'customer_mobile'       => 'required|unique:mst__customers,customer_mobile,' . $customer_id . ',customer_id',
                'password' => 'confirmed',


            ],
            [
                'customer_name.required'         => 'Customer name required',
                'customer_mobile.required'         => 'Customer mobile required',
                'password.required'         => 'Password required',
                'password.confirmed'         => 'Passwords not matching',
                'password.min'         => 'Password should have 6 character',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $customer = Mst_Customer::find($customer_id);
            $customer->customer_name = $request->customer_name;
            $customer->customer_mobile = $request->customer_mobile;
            $customer->customer_email = $request->customer_email;
            $customer->customer_dob = $request->customer_dob;
            $customer->customer_gender = $request->customer_gender;
            if (isset($request->password))
                $customer->password = Hash::make($request->password);;

            $customer->is_active = $request->is_active;
            $customer->update();

            return redirect('/admin/customers/list')->with('status', 'Customer updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeCustomer(Request $request, $customer_id)
    {
        Mst_Customer::where('customer_id', '=', $customer_id)->delete();
        return redirect('admin/customers/list')->with('status', 'Customer deleted successfully.');
    }

    public function editStatusCustomer(Request $request)
    {
        $customer_id = $request->customer_id;
        if ($c = Mst_Customer::findOrFail($customer_id)) {
            if ($c->is_active == 0) {
                Mst_Customer::where('customer_id', $customer_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Customer::where('customer_id', $customer_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function listCustomerGroup(Request $request)
    {
        $pageTitle = "Customer Group";
        $customerGroups = Mst_CustomerGroup::orderBy('customer_group_id', 'DESC')->get();
        return view('admin.elements.customer_group.list', compact('customerGroups', 'pageTitle'));
    }

    public function createCustomerGroup(Request $request)
    {
        $pageTitle = "Create Customer Group";
        return view('admin.elements.customer_group.create', compact('pageTitle'));
    }

    public function editCustomerGroup(Request $request, $customer_group_id)
    {
        $pageTitle = "Edit Customer Group";
        $customer_group = Mst_CustomerGroup::find($customer_group_id);
        return view('admin.elements.customer_group.edit', compact('customer_group', 'pageTitle'));
    }

    public function editStatusCustomerGroup(Request $request)
    {
        $customer_group_id = $request->customer_group_id;
        if ($c = Mst_CustomerGroup::findOrFail($customer_group_id)) {
            if ($c->is_active == 0) {
                Mst_CustomerGroup::where('customer_group_id', $customer_group_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_CustomerGroup::where('customer_group_id', $customer_group_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function removeCustomerGroup(Request $request, $customer_group_id)
    {
        Mst_CustomerGroup::where('customer_group_id', '=', $customer_group_id)->delete();
        return redirect('/admin/customer-group/list')->with('status', 'Customer group deleted successfully.');
    }



    public function storeCustomerGroup(Request $request, Mst_CustomerGroup $customer_group)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'customer_group_name'       => 'required',
            ],
            [
                'customer_group_name.required'         => 'Customer group name required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            $customer_group->customer_group_name = $request->customer_group_name;
            $customer_group->customer_group_description = $request->customer_group_description;
            $customer_group->is_active = $request->is_active;
            $customer_group->save();

            return redirect('/admin/customer-group/list')->with('status', 'Customer group added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function updateCustomerGroup(Request $request, $customer_group_id)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'customer_group_name'       => 'required',
            ],
            [
                'customer_group_name.required'         => 'Customer group name required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $customer_group = Mst_CustomerGroup::find($customer_group_id);

            $customer_group->customer_group_name = $request->customer_group_name;
            $customer_group->customer_group_description = $request->customer_group_description;
            $customer_group->is_active = $request->is_active;
            $customer_group->update();

            return redirect('/admin/customer-group/list')->with('status', 'Customer group updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
