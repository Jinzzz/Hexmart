<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;
use Hash;
use DB;
use Carbon\Carbon;
use Crypt;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_AttributeGroup;
use App\Models\admin\Mst_AttributeValue;
use App\Models\admin\Mst_Brand;
use App\Models\admin\Mst_Coupon;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_DeliveryBoy;
use App\Models\admin\Mst_Issue;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_Tax;
use App\Models\admin\Mst_Unit;
use App\Models\admin\Sys_IssueType;
use App\Models\admin\Trn_TaxSplit;
use App\Models\admin\Mst_brandsubcat;
use App\Models\admin\Mst_Attributecategory;
use Illuminate\Http\Request;

class MasterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function listCustomerBanner(Request $request)
    {
        $pageTitle = "Item Customer Banner";
        $customer_banners = Mst_CustomerBanner::orderBy('customer_banner_id', 'DESC')->get();
        return view('admin.elements.customer_banners.list', compact('customer_banners', 'pageTitle'));
    }

    public function createCustomerBanner(Request $request)
    {
        $pageTitle = "Create Customer Banner";
        $customer_banners = Mst_CustomerBanner::all();
        return view('admin.elements.customer_banners.create', compact('pageTitle', 'customer_banners'));
    }


    public function storeCustomerBanner(Request $request, Mst_Issue $issue)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'images'       => 'required',

            ],
            [
                'images.required'         => 'Images required',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            if ($request->hasFile('images')) {
                $allowedfileExtension = ['jpg', 'png', 'jpeg',];
                $files = $request->file('images');
                $c = 1;
                foreach ($files as $file) {

                    $filename = time() . '_' . $file->getClientOriginalName();
                    if ($file->move('assets/uploads/customer_banners', $filename)) {

                        $itemImage = new Mst_CustomerBanner;
                        $itemImage->customer_banner = $filename;
                        $itemImage->is_default = 0;
                        $itemImage->is_active = 0;
                        $itemImage->save();

                        $c++;
                    }
                }
            }

            return redirect('/admin/customer-banners/list')->with('status', 'Customer banner added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function removeCustomerBanner(Request $request, $customer_banner_id)
    {
        try {
            Mst_CustomerBanner::where('customer_banner_id', $customer_banner_id)->delete();
            return redirect()->route('admin.customer_banners')->with('status', 'Customer Banner deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function editStatusCustomerBanner(Request $request)
    {
        $customer_banner_id = $request->customer_banner_id;
        if ($c = Mst_CustomerBanner::findOrFail($customer_banner_id)) {
            if ($c->is_active == 0) {
                Mst_CustomerBanner::where('customer_banner_id', $customer_banner_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_CustomerBanner::where('customer_banner_id', $customer_banner_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }



    public function listIssues(Request $request)
    {
        $pageTitle = "Item Issues";
        $issues = Mst_Issue::orderBy('issue_id', 'DESC')->get();
        return view('admin.elements.issues.list', compact('issues', 'pageTitle'));
    }

    public function editStatusissue(Request $request)
    {
        $issue_id = $request->issue_id;
        if ($c = Mst_Issue::findOrFail($issue_id)) {
            if ($c->is_active == 0) {
                Mst_Issue::where('issue_id', $issue_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Issue::where('issue_id', $issue_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }


    public function createissue(Request $request)
    {
        $pageTitle = "Create Issue";
        $issue_types = Sys_IssueType::all();
        return view('admin.elements.issues.create', compact('pageTitle', 'issue_types'));
    }

    public function editissue(Request $request, $issue_id)
    {
        $pageTitle = "Edit Issue";
        $issue_types = Sys_IssueType::all();
        $issue = Mst_Issue::where('issue_id', '=', $issue_id)->first();
        return view('admin.elements.issues.edit', compact('issue', 'issue_types', 'pageTitle'));
    }

    public function storeissue(Request $request, Mst_Issue $issue)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'issue_type_id'       => 'required',
                'issue'       => 'required',

            ],
            [
                'issue_type_id.required'         => 'Issue type required',
                'issue.required'         => 'Issue required',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            $issue->issue_type_id         = $request->issue_type_id;
            $issue->issue = $request->issue;
            $issue->is_active = $request->is_active;
            $issue->save();

            return redirect('/admin/issues/list')->with('status', 'Issue added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function updateissue(Request $request, $issue_id)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'issue_type_id'       => 'required',
                'issue'       => 'required',
            ],
            [
                'issue_type_id.required'         => 'Issue type required',
                'issue.required'         => 'Issue required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $issue = Mst_Issue::find($issue_id);
            $issue->issue_type_id         = $request->issue_type_id;
            $issue->issue = $request->issue;
            $issue->is_active = $request->is_active;
            $issue->update();

            return redirect('/admin/issues/list')->with('status', 'Issue updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function removeissue(Request $request, $issue_id)
    {
        try {
            Mst_Issue::where('issue_id', $issue_id)->delete();
            return redirect()->route('admin.issues')->with('status', 'Issue deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }





    public function listDeliveryBoy(Request $request)
    {
        $pageTitle = "Delivery Boy";
        $delivery_boys = Mst_DeliveryBoy::orderBy('delivery_boy_id', 'DESC')->get();
        return view('admin.elements.delivery_boy.list', compact('delivery_boys', 'pageTitle'));
    }

    public function createDeliveryBoy(Request $request)
    {
        $pageTitle = "Create Delivery Boy";
        return view('admin.elements.delivery_boy.create', compact('pageTitle'));
    }

    public function storeDeliveryBoy(Request $request, Mst_DeliveryBoy $db)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'delivery_boy_name'       => 'required',
                    'delivery_boy_phone'       => 'required|unique:mst__delivery_boys',
                    'delivery_boy_address'       => 'required',
                    'password' => 'required|confirmed|min:6',
                ],
                [
                    'delivery_boy_name.required'         => 'Customer name required',
                    'delivery_boy_phone.required'         => 'Customer mobile required',
                    'delivery_boy_address.required'         => 'Address required',
                    'password.required'         => 'Password required',
                    'password.confirmed'         => 'Passwords not matching',
                    'password.min'         => 'Password should have 6 character',
                ]
            );

            if (!$validator->fails()) {
                $db->delivery_boy_name = $request->delivery_boy_name;
                $db->delivery_boy_phone = $request->delivery_boy_phone;
                $db->delivery_boy_email = $request->delivery_boy_email;
                $db->delivery_boy_address = $request->delivery_boy_address;
                $db->password = Hash::make($request->password);;
                $db->is_active = $request->is_active;
                $db->is_online = 0;
                $db->save();

                return redirect()->route('admin.delivery_boys')->with('status', 'Delivery boy created successfully');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function updateDeliveryBoy(Request $request, $delivery_boy_id)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'delivery_boy_name'       => 'required',
                    'delivery_boy_phone'       => 'required|unique:mst__delivery_boys,delivery_boy_phone,' . $delivery_boy_id . ',delivery_boy_id',
                    'delivery_boy_address'       => 'required',
                    'password' => 'confirmed',
                ],
                [
                    'delivery_boy_name.required'         => 'Customer name required',
                    'delivery_boy_phone.required'         => 'Customer mobile required',
                    'delivery_boy_address.required'         => 'Address required',
                    'password.required'         => 'Password required',
                    'password.confirmed'         => 'Passwords not matching',
                    'password.min'         => 'Password should have 6 character',
                ]
            );
            if (!$validator->fails()) {

                $data = $request->except('_token');
                $db = Mst_DeliveryBoy::find($delivery_boy_id);
                $db->delivery_boy_name = $request->delivery_boy_name;
                $db->delivery_boy_phone = $request->delivery_boy_phone;
                $db->delivery_boy_email = $request->delivery_boy_email;
                $db->delivery_boy_address = $request->delivery_boy_address;
                $db->is_active = $request->is_active;

                if (isset($request->password))
                    $db->password = Hash::make($request->password);;

                $db->update();

                return redirect()->route('admin.delivery_boys')->with('status', 'Delivery boy updated successfully');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function removeDeliveryBoy(Request $request, $delivery_boy_id)
    {
        try {
            Mst_DeliveryBoy::where('delivery_boy_id', $delivery_boy_id)->delete();
            return redirect()->route('admin.delivery_boys')->with('status', 'Delivery boy deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }


    public function editStatusDeliveryBoy(Request $request)
    {
        $delivery_boy_id = $request->delivery_boy_id;
        if ($c = Mst_DeliveryBoy::findOrFail($delivery_boy_id)) {
            if ($c->is_active == 0) {
                Mst_DeliveryBoy::where('delivery_boy_id', $delivery_boy_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_DeliveryBoy::where('delivery_boy_id', $delivery_boy_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editDeliveryBoy(Request $request, $delivery_boy_id)
    {
        $pageTitle = "Edit Delivery Boy";
        $delivery_boy = Mst_DeliveryBoy::where('delivery_boy_id', '=', $delivery_boy_id)->first();
        return view('admin.elements.delivery_boy.edit', compact('delivery_boy', 'pageTitle'));
    }


    public function listCoupon(Request $request)
    {
        try {

            $pageTitle = "Coupons";
            $coupons = Mst_Coupon::orderBy('coupon_id', 'DESC')->get();
            if ($_GET) {
                $couponDetail =  Mst_Coupon::where('coupon_status', $request->status);
                if ($request->coupon_status == 0) {
                    $today = Carbon::now()->toDateTimeString();
                    $couponDetail = $couponDetail->whereDate('valid_to', '>=', $today);
                }
                $coupons = $couponDetail->orderBy('coupon_id', 'DESC')->get();
                return view('store.elements.coupon.list', compact('coupons',  'pageTitle'));
            }
            return view('admin.elements.coupon.list', compact('coupons', 'pageTitle'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function createcoupon(Request $request)
    {
        try {
            $pageTitle = "Create Coupon";
            return view('admin.elements.coupon.create', compact('pageTitle'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }


    public function storecoupon(Request $request, Mst_Coupon $coupon)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'coupon_code'          => 'required',
                    'coupon_type'          => 'required',
                    'discount_type'          => 'required',
                    'discount'          => 'required',
                    'valid_to'          => 'required',
                    'valid_from'          => 'required',
                    'min_purchase_amt'          => 'required',
                ],
                [
                    'coupon_code.required'             => 'Code required',
                    'coupon_type.required'             => 'Type required',
                    'discount.required'             => 'Discount required',
                    'discount_type.required'             => 'Discount type required',
                    'valid_to.required'             => 'Valid to required',
                    'valid_from.required'             => 'Valid from required',
                    'min_purchase_amt.required'             => 'Minimum purchase amount required',
                ]
            );

            if (!$validator->fails()) {
                $coupon->coupon_code = $request->coupon_code;
                $coupon->coupon_type = $request->coupon_type;
                $coupon->discount_type = $request->discount_type;
                $coupon->discount = $request->discount;
                $coupon->valid_to = $request->valid_to;
                $coupon->valid_from = $request->valid_from;
                $coupon->coupon_status = $request->coupon_status;
                $coupon->min_purchase_amt = $request->min_purchase_amt;
                $coupon->save();

                return redirect()->route('admin.list_coupon')->with('status', 'Coupon created successfully');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }


    public function editcoupon(Request $request, $coupon_id)
    {
        try {

            $pageTitle = "Edit Coupon";
            $coupon_id  = Crypt::decryptString($coupon_id);
            $coupon = Mst_Coupon::find($coupon_id);
            $coupon->valid_from = Carbon::parse($coupon->valid_from)->format('Y-m-d');
            $coupon->valid_to = Carbon::parse($coupon->valid_to)->format('Y-m-d');
            return view('admin.elements.coupon.edit', compact('coupon', 'pageTitle'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function updatecoupon(Request $request, $coupon_id)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'coupon_code'          => 'required',
                    'coupon_type'          => 'required',
                    'discount'          => 'required',
                    'discount_type'          => 'required',
                    'valid_to'          => 'required',
                    'valid_from'          => 'required',
                    'min_purchase_amt'          => 'required',
                ],
                [
                    'coupon_code.required'             => 'Code required',
                    'discount.required'             => 'Discount required',
                    'coupon_type.required'             => 'Type required',
                    'discount_type.required'             => 'Discount type required',
                    'valid_to.required'             => 'Valid to required',
                    'valid_from.required'             => 'Valid from required',
                    'min_purchase_amt.required'             => 'Minimum purchase amount required',
                ]
            );
            //   $coupon_id  = Crypt::decryptString($coupon_id);
            if (!$validator->fails()) {
                $coupon['coupon_code'] = $request->coupon_code;
                $coupon['coupon_type'] = $request->coupon_type;
                $coupon['discount'] = $request->discount;
                $coupon['discount_type'] = $request->discount_type;
                $coupon['valid_to'] = $request->valid_to;
                $coupon['valid_from'] = $request->valid_from;
                $coupon['coupon_status'] = $request->coupon_status;
                $coupon['min_purchase_amt'] = $request->min_purchase_amt;

                Mst_Coupon::where('coupon_id', $coupon_id)->update($coupon);

                return redirect()->route('admin.list_coupon')->with('status', 'Coupon updated successfully');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function removecoupon(Request $request, $coupon_id)
    {
        try {
            //  $coupon_id  = Crypt::decryptString($coupon_id);
            Mst_Coupon::where('coupon_id', $coupon_id)->delete();
            return redirect()->route('store.list_coupon')->with('status', 'Coupon deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function listIltsc(Request $request)
    {
        $pageTitle = "Item Sub Categories Level Two";
        $sub_category = Mst_ItemLevelTwoSubCategory::orderBy('iltsc_id', 'DESC')->get();
        return view('admin.elements.item_sub_cat_level_two.list', compact('sub_category', 'pageTitle'));
    }

    public function createIltsc(Request $request)
    {
        $pageTitle = "Create Item Sub Category Level Two";
        $sub_categories = Mst_ItemSubCategory::where('is_active', '=', '1')->orderBy('sub_category_name')->get();
        $categories = Mst_ItemCategory::where('is_active', '=', '1')->orderBy('category_name')->get();
        return view('admin.elements.item_sub_cat_level_two.create', compact('sub_categories', 'categories', 'pageTitle'));
    }

    public function storeIltsc(Request $request, Mst_ItemLevelTwoSubCategory $iltsc)
    {
        $data = $request->except('_token');
        $validator = Validator::make(
            $request->all(),
            [
                'item_sub_category_id'       => 'required',
                'iltsc_name'       => 'required',
                'iltsc_description' => 'required',
            ],
            [
                'iltsc_name.required'         => 'Sub category name required',
                'item_sub_category_id.required'        => 'Sub category level one required',
                'iltsc_icon.dimensions'        => 'Sub category icon dimensions is invalid',
                'iltsc_description.required'     => 'Sub category description required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $catData = Mst_ItemSubCategory::find($request->item_sub_category_id);
            $iltsc->item_category_id         = $catData->item_category_id;
            $iltsc->item_sub_category_id         = $request->item_sub_category_id;
            $iltsc->iltsc_name         = $request->iltsc_name;
            $iltsc->iltsc_name_slug      = Str::of($request->iltsc_name)->slug('-');
            $iltsc->iltsc_description = $request->iltsc_description;

            if ($request->hasFile('iltsc_icon')) {
                $file = $request->file('iltsc_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/category_icon', $filename);
                $iltsc->iltsc_icon = $filename;
            }
            $iltsc->is_active         = 1;
            $iltsc->save();

            return redirect('/admin/item-sub-category-level-two/list')->with('status', 'Sub category level two added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function updateIltsc(Request $request, $iltsc_id)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'item_sub_category_id'       => 'required',
                'iltsc_name'       => 'required',
                'iltsc_description' => 'required',
            ],
            [
                'iltsc_name.required'         => 'Sub category name required',
                'item_sub_category_id.required'        => 'Sub category level one required',
                'iltsc_icon.dimensions'        => 'Sub category icon dimensions is invalid',
                'iltsc_description.required'     => 'Sub category description required',
            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $iltsc = Mst_ItemLevelTwoSubCategory::find($iltsc_id);
            $catData = Mst_ItemSubCategory::find($request->item_sub_category_id);
            $iltsc->item_category_id         = $catData->item_category_id;
            $iltsc->item_sub_category_id         = $request->item_sub_category_id;
            $iltsc->iltsc_name         = $request->iltsc_name;
            $iltsc->iltsc_name_slug      = Str::of($request->iltsc_name)->slug('-');
            $iltsc->iltsc_description = $request->iltsc_description;

            if ($request->hasFile('iltsc_icon')) {
                $file = $request->file('iltsc_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/category_icon', $filename);
                $iltsc->iltsc_icon = $filename;
            }

            $iltsc->update();

            return redirect('/admin/item-sub-category-level-two/list')->with('status', 'Sub category updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function editStatusIltsc(Request $request)
    {
        $iltsc_id = $request->iltsc_id;
        if ($c = Mst_ItemLevelTwoSubCategory::findOrFail($iltsc_id)) {
            if ($c->is_active == 0) {
                Mst_ItemLevelTwoSubCategory::where('iltsc_id', $iltsc_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_ItemLevelTwoSubCategory::where('iltsc_id', $iltsc_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editIltsc(Request $request, $iltsc_id)
    {
        $pageTitle = "Edit Item Sub Category Level Two";

        $sub_category_l_2 = Mst_ItemLevelTwoSubCategory::where('iltsc_id', '=', $iltsc_id)->first();
        $categories = Mst_ItemCategory::where('is_active', '=', '1')->orderBy('category_name')->get();
        $sub_categories = Mst_ItemSubCategory::where('is_active', '=', '1')
            ->where('item_category_id', $sub_category_l_2->item_category_id)
            ->orderBy('sub_category_name')->get();

        return view('admin.elements.item_sub_cat_level_two.edit', compact('sub_category_l_2', 'categories', 'sub_categories', 'pageTitle'));
    }


    public function removeIltsc(Request $request, $iltsc_id)
    {
        Mst_ItemLevelTwoSubCategory::where('iltsc_id', '=', $iltsc_id)->delete();
        return redirect('/admin/item-sub-category-level-two/list')->with('status', 'Sub category removed successfully.');
    }

    public function listItemSubCategory(Request $request)
    {
        $pageTitle = "Item Sub Categories Level One";
        $sub_category = Mst_ItemSubCategory::orderBy('item_sub_category_id', 'DESC')->get();
        return view('admin.elements.item_sub_cat_level_one.list', compact('sub_category', 'pageTitle'));
    }



    public function createItemSubCategory(Request $request)
    {
        $pageTitle = "Create Item Sub Category";
        $categories = Mst_ItemCategory::where('is_active', '=', '1')->orderBy('category_name')->get();
        return view('admin.elements.item_sub_cat_level_one.create', compact('categories', 'pageTitle'));
    }

    public function editItemSubCategory(Request $request, $item_sub_category_id)
    {
        $pageTitle = "Edit Item Sub Category";
        $sub_category = Mst_ItemSubCategory::where('item_sub_category_id', '=', $item_sub_category_id)->first();
        $categories = Mst_ItemCategory::where('is_active', '=', '1')->orderBy('category_name')->get();
        return view('admin.elements.item_sub_cat_level_one.edit', compact('categories', 'sub_category', 'pageTitle'));
    }





    public function storeItemSubCategory(Request $request, Mst_ItemSubCategory $sub_category)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'category_id'       => 'required',
                'sub_category_name'       => 'required',
                //  'sub_category_icon'        => 'required',
                // 'sub_category_icon'        => 'dimensions:width=150,height=150|image|mimes:jpeg,png,jpg',
                'sub_category_description' => 'required',


            ],
            [
                'category_id.required'         => 'Parent category required',
                'sub_category_name.required'         => 'Sub category name required',
                'sub_category_icon.required'        => 'Sub category icon required',
                'sub_category_icon.dimensions'        => 'Sub category icon dimensions is invalid',
                'sub_category_description.required'     => 'Sub category description required',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');

            $sub_category->sub_category_name         = $request->sub_category_name;
            $sub_category->sub_category_name_slug      = Str::of($request->sub_category_name)->slug('-');
            $sub_category->sub_category_description = $request->sub_category_description;
            $sub_category->item_category_id         =  $request->category_id;

            if ($request->hasFile('sub_category_icon')) {
                $file = $request->file('sub_category_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/category_icon', $filename);
                $sub_category->sub_category_icon = $filename;
            }


            $sub_category->is_active         = 1;

            $sub_category->save();

            return redirect('/admin/item-sub-category/list')->with('status', 'Sub category added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function updateItemSubCategory(Request $request, $item_sub_category_id)
    {
        $data = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'category_id'       => 'required',
                'sub_category_name'       => 'required',
                //  'sub_category_icon'        => 'required',
                // 'sub_category_icon'        => 'dimensions:width=150,height=150|image|mimes:jpeg,png,jpg',
                'sub_category_description' => 'required',


            ],
            [
                'category_id.required'         => 'Parent category required',
                'sub_category_name.required'         => 'Sub category name required',
                'sub_category_icon.required'        => 'Sub category icon required',
                'sub_category_icon.dimensions'        => 'Sub category icon dimensions is invalid',
                'sub_category_description.required'     => 'Sub category description required',

            ]
        );

        if (!$validator->fails()) {

            $data = $request->except('_token');
            $sub_category = Mst_ItemSubCategory::find($item_sub_category_id);
            $sub_category->sub_category_name         = $request->sub_category_name;
            $sub_category->sub_category_name_slug      = Str::of($request->sub_category_name)->slug('-');
            $sub_category->sub_category_description = $request->sub_category_description;
            $sub_category->item_category_id         =  $request->category_id;

            if ($request->hasFile('sub_category_icon')) {
                $file = $request->file('sub_category_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/category_icon', $filename);
                $sub_category->sub_category_icon = $filename;
            }

            $sub_category->update();

            return redirect('/admin/item-sub-category/list')->with('status', 'Sub category updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeItemSubCategory(Request $request, $item_sub_category_id)
    {
        Mst_ItemSubCategory::where('item_sub_category_id', '=', $item_sub_category_id)->delete();
        return redirect('/admin/item-sub-category/list')->with('status', 'Sub category removed successfully.');
    }


    public function editStatusItemSubCategory(Request $request)
    {
        $item_sub_category_id = $request->item_sub_category_id;
        if ($c = Mst_ItemSubCategory::findOrFail($item_sub_category_id)) {
            if ($c->is_active == 0) {
                Mst_ItemSubCategory::where('item_sub_category_id', $item_sub_category_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_ItemSubCategory::where('item_sub_category_id', $item_sub_category_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function listItemCategory(Request $request)
    {
        $pageTitle = "Item Categories";
        $categories = Mst_ItemCategory::orderBy('item_category_id', 'DESC')->get();
        return view('admin.elements.item_categories.list', compact('categories', 'pageTitle'));
    }

    public function createItemCategory(Request $request)
    {
        $pageTitle = "Create Item Category";
        return view('admin.elements.item_categories.create', compact('pageTitle'));
    }

    public function storeItemCategory(Request $request, Mst_ItemCategory $category)
    {
        //  dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'category_name'       => 'required|unique:mst__item_categories',
                //'category_icon'        => 'dimensions:width=150,height=150|image|mimes:jpeg,png,jpg',
                'category_icon'        => 'required|image|mimes:jpeg,png,jpg',
                'category_description' => 'required',
            ],
            [
                'category_name.required'         => 'Category name required',
                'category_icon.required'        => 'Category icon required',
                'category_icon.dimensions'        => 'Category icon dimensions is invalid',
                'category_description.required'     => 'Category description required',
            ]
        );

        if (!$validator->fails()) {
            $data = $request->except('_token');
            $category->category_name         = $request->category_name;
            $category->category_name_slug      = Str::of($request->category_name)->slug('-');
            $category->category_description = $request->category_description;
            $category->is_active = $request->is_active;
            if ($request->hasFile('category_icon')) {
                $file = $request->file('category_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/category_icon', $filename);
                $category->category_icon = $filename;
            }
            $category->save();
            return redirect('admin/item-category/list')->with('status', 'Category added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function editStatusItemCategory(Request $request)
    {
        $item_category_id = $request->item_category_id;
        if ($c = Mst_ItemCategory::findOrFail($item_category_id)) {
            if ($c->is_active == 0) {
                Mst_ItemCategory::where('item_category_id', $item_category_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_ItemCategory::where('item_category_id', $item_category_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editItemCategory(Request $request, $category_name_slug)
    {
        $pageTitle = "Edit Item Category";
        $category = Mst_ItemCategory::where('category_name_slug', '=', $category_name_slug)->first();
        return view('admin.elements.item_categories.edit', compact('category', 'pageTitle'));
    }

    public function listUnit(Request $request)
    {
        $pageTitle = "Item Units";
        $units = Mst_Unit::orderBy('unit_id', 'DESC')->get();
        return view('admin.elements.units.list', compact('units', 'pageTitle'));
    }

    public function editStatusUnit(Request $request)
    {
        $unit_id = $request->unit_id;
        if ($c = Mst_Unit::findOrFail($unit_id)) {
            if ($c->is_active == 0) {
                Mst_Unit::where('unit_id', $unit_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Unit::where('unit_id', $unit_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }


    public function createUnit(Request $request)
    {
        $pageTitle = "Create Unit";
        return view('admin.elements.units.create', compact('pageTitle'));
    }

    public function editUnit(Request $request, $unit_id)
    {
        $pageTitle = "Edit Unit";
        $unit = Mst_Unit::where('unit_id', '=', $unit_id)->first();
        return view('admin.elements.units.edit', compact('unit', 'pageTitle'));
    }


    public function storeUnit(Request $request, Mst_Unit $row)
    {
        //  dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'unit_name'       => 'required',
                'unit_sf'       => 'required',
            ],
            [
                'unit_name.required'         => 'Unit name required',
                'unit_sf.required'         => 'Unit shotform required',
            ]
        );

        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row->unit_name         = $request->unit_name;
            $row->unit_sf         = $request->unit_sf;
            $row->is_active = $request->is_active;

            $row->save();
            return redirect('admin/units/list')->with('status', 'Unit added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeUnit(Request $request, $unit_id)
    {
        Mst_Unit::where('unit_id', '=', $unit_id)->delete();
        return redirect('admin/units/list')->with('status', 'Unit deleted successfully.');
    }

    public function updateUnit(Request $request, $unit_id)
    {
        //  dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'unit_name'       => 'required',
                'unit_sf'       => 'required',
            ],
            [
                'unit_name.required'         => 'Unit name required',
                'unit_sf.required'         => 'Unit shotform required',
            ]
        );
        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row = Mst_Unit::find($unit_id);
            $row->unit_name         = $request->unit_name;
            $row->unit_sf         = $request->unit_sf;
            $row->is_active = $request->is_active;

            $row->update();
            return redirect('admin/units/list')->with('status', 'Unit updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function listAttributeGroup(Request $request)
    {
        $pageTitle = "Item Attribute Groups";
        $attribute_groups = Mst_AttributeGroup::orderBy('attribute_group_id', 'DESC')->get();
        return view('admin.elements.attribute_groups.list', compact('attribute_groups', 'pageTitle'));
    }

    public function createAttributeGroup(Request $request)
    {
        $pageTitle = "Create Attribute Group";
        $category=Mst_ItemLevelTwoSubCategory::where('is_active',1)->get();

        return view('admin.elements.attribute_groups.create', compact('pageTitle','category'));
    }

    public function storeAttributeGroup(Request $request, Mst_AttributeGroup $row)
    {
        //  dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'attribute_group'       => 'required|unique:mst__attribute_groups',
            ],
            [
                'attribute_group.required'         => 'Attribute group name required',
                'attribute_group.unique'         => 'Attribute group exists',
            ]
        );
        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row->attribute_group         = $request->attribute_group;
            $row->is_active = $request->is_active;
            if ($row->save()) {
                $lastCatid = DB::getPdo()->lastInsertId();
                // dd($records);
                foreach (array_unique($request->category) as  $row) {
                $records=Mst_ItemLevelTwoSubCategory::where('iltsc_id',$row)->first();

                    $cb = new Mst_Attributecategory;
                    $cb->attribute_group_id = $lastCatid;
                    $cb->item_category_id = $records->item_category_id;
                    $cb->item_sub_category_id = $records->item_sub_category_id;
                    $cb->iltsc_id = $row;
                    $cb->save();
                }
            }
            return redirect('admin/attribute-group/list')->with('status', 'Attribute group added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function editStatusAttributeGroup(Request $request)
    {
        $attribute_group_id = $request->attribute_group_id;
        if ($c = Mst_AttributeGroup::findOrFail($attribute_group_id)) {
            if ($c->is_active == 0) {
                Mst_AttributeGroup::where('attribute_group_id', $attribute_group_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_AttributeGroup::where('attribute_group_id', $attribute_group_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editAttributeGroup(Request $request, $attribute_group_id)
    {
        $pageTitle = "Edit Attribute Group";
        $attribute_group = Mst_AttributeGroup::where('attribute_group_id', '=', $attribute_group_id)->first();
        $category=Mst_ItemLevelTwoSubCategory::where('is_active',1)->get();

        return view('admin.elements.attribute_groups.edit', compact('attribute_group', 'pageTitle','category'));
    }

    public function removeAttributeGroup(Request $request, $attribute_group_id)
    {
        Mst_AttributeGroup::where('attribute_group_id', '=', $attribute_group_id)->delete();
        return redirect('admin/attribute-group/list')->with('status', 'Attribute group deleted successfully.');
    }

    public function updateAttributeGroup(Request $request, $attribute_group_id)
    {
        //  dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'attribute_group'       => 'required|unique:mst__attribute_groups,attribute_group,' . $attribute_group_id . ',attribute_group_id',
            ],
            [
                'attribute_group.required'         => 'Attribute group name required',
                'attribute_group.unique'         => 'Attribute group exists',
            ]
        );
        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row = Mst_AttributeGroup::find($attribute_group_id);
            $row->attribute_group         = $request->attribute_group;
            $row->is_active = $request->is_active;
            if ($row->update()) {
                Mst_Attributecategory::where('attribute_group_id', $attribute_group_id)->delete();
    
                    foreach (array_unique($request->category) as  $row) {
                    $records=Mst_ItemLevelTwoSubCategory::where('iltsc_id',$row)->first();

                    $cb = new Mst_Attributecategory;
                    $cb->attribute_group_id = $attribute_group_id;
                    $cb->item_category_id = $records->item_category_id;
                    $cb->item_sub_category_id = $records->item_sub_category_id;
                    $cb->iltsc_id = $row;
                    $cb->save();

                }
            }
            return redirect('admin/attribute-group/list')->with('status', 'Attribute group updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function listAttributeValue(Request $request)
    {
        $pageTitle = "Item Attribute Values";
        $attribute_values = Mst_AttributeValue::orderBy('attribute_value_id', 'DESC')->get();
        return view('admin.elements.attribute_values.list', compact('attribute_values', 'pageTitle'));
    }

    public function createAttributeValue(Request $request)
    {
        $pageTitle = "Create Attribute Value";
        $attribute_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group_id', 'DESC')->get();
        return view('admin.elements.attribute_values.create', compact('attribute_groups', 'pageTitle'));
    }

    public function storeAttributeValue(Request $request, Mst_AttributeValue $row)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'attribute_group_id'       => 'required',
                'attribute_value'       => 'required',
            ],
            [
                'attribute_group_id.required'         => 'Attribute group required',
                'attribute_value.required'         => 'Attribute value required',
            ]
        );
        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row->attribute_group_id         = $request->attribute_group_id;
            $row->attribute_value         = $request->attribute_value;
            $row->is_active = $request->is_active;
            $row->save();
            return redirect('admin/attribute-value/list')->with('status', 'Attribute value added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function editStatusAttributeValue(Request $request)
    {
        $attribute_value_id = $request->attribute_value_id;
        if ($c = Mst_AttributeValue::findOrFail($attribute_value_id)) {
            if ($c->is_active == 0) {
                Mst_AttributeValue::where('attribute_value_id', $attribute_value_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_AttributeValue::where('attribute_value_id', $attribute_value_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editAttributeValue(Request $request, $attribute_value_id)
    {
        $pageTitle = "Edit Attribute Value";
        $attribute_value = Mst_AttributeValue::where('attribute_value_id', '=', $attribute_value_id)->first();
        $attribute_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group_id', 'DESC')->get();
        return view('admin.elements.attribute_values.edit', compact('attribute_groups', 'attribute_value', 'pageTitle'));
    }

    public function updateAttributeValue(Request $request, $attribute_value_id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'attribute_group_id'       => 'required',
                'attribute_value'       => 'required',
            ],
            [
                'attribute_group_id.required'         => 'Attribute group required',
                'attribute_value.required'         => 'Attribute value required',
            ]
        );
        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row = Mst_AttributeValue::find($attribute_value_id);
            $row->attribute_group_id         = $request->attribute_group_id;
            $row->attribute_value         = $request->attribute_value;
            $row->is_active = $request->is_active;
            $row->update();
            return redirect('admin/attribute-value/list')->with('status', 'Attribute value updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeAttributeValue(Request $request, $attribute_value_id)
    {
        Mst_AttributeValue::where('attribute_value_id', '=', $attribute_value_id)->delete();
        return redirect('admin/attribute-value/list')->with('status', 'Attribute value deleted successfully.');
    }


    public function listBrand(Request $request)
    {
        $pageTitle = "Item Brands";
        $brands = Mst_Brand::orderBy('brand_id', 'DESC')->get();
        return view('admin.elements.brands.list', compact('brands', 'pageTitle'));
    }

    public function createBrand(Request $request)
    {
        $pageTitle = "Create Brand";
        $category=Mst_ItemLevelTwoSubCategory::where('is_active',1)->get();
        return view('admin.elements.brands.create', compact('pageTitle','category'));
    }


    public function storeBrand(Request $request, Mst_Brand $row)
    {
        //  dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'brand_name'       => 'required|unique:mst__brands',
                //'brand_icon'        => 'dimensions:width=150,height=150|image|mimes:jpeg,png,jpg',
                'brand_icon'        => 'required|image|mimes:jpeg,png,jpg',
            ],
            [
                'brand_name.required'         => 'Brand name required',
                'brand_name.unique'         => 'Brand name exists',
                'brand_icon.required'        => 'Brand icon required',
                'brand_icon.dimensions'        => 'Brand icon dimensions is invalid',
            ]
        );

        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row->brand_name         = $request->brand_name;
            $row->brand_name_slug      = Str::of($request->brand_name)->slug('-');
            $row->is_active = $request->is_active;
            if ($request->hasFile('brand_icon')) {
                $file = $request->file('brand_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/brand_icon', $filename);
                $row->brand_icon = $filename;
            }
            if ($row->save()) {
                $lastCatid = DB::getPdo()->lastInsertId();
                // dd($records);
                foreach (array_unique($request->category) as  $row) {
                $records=Mst_ItemLevelTwoSubCategory::where('iltsc_id',$row)->first();

                    $cb = new Mst_brandsubcat;
                    $cb->brand_id = $lastCatid;
                    $cb->item_category_id = $records->item_category_id;
                    $cb->item_sub_category_id = $records->item_sub_category_id;
                    $cb->iltsc_id = $row;
                    $cb->save();
                }
            }

            return redirect('admin/brands/list')->with('status', 'Brand added successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function editStatusBrand(Request $request)
    {
        $brand_id = $request->brand_id;
        if ($c = Mst_Brand::findOrFail($brand_id)) {
            if ($c->is_active == 0) {
                Mst_Brand::where('brand_id', $brand_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Brand::where('brand_id', $brand_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function editBrand(Request $request, $brand_id)
    {
        $pageTitle = "Edit Brand";
        $brand = Mst_Brand::where('brand_id', '=', $brand_id)->first();
        $category=Mst_ItemLevelTwoSubCategory::where('is_active',1)->get();

        return view('admin.elements.brands.edit', compact('brand', 'pageTitle','category'));
    }


    public function updateBrand(Request $request, $brand_id)
    {
        //  dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'brand_name'       => 'required|unique:mst__brands,brand_name,' . $brand_id . ',brand_id',
                //'brand_name'       => 'required|unique:mst__brands',
                //'brand_icon'        => 'dimensions:width=150,height=150|image|mimes:jpeg,png,jpg',
                'brand_icon'        => 'image|mimes:jpeg,png,jpg',
            ],
            [
                'brand_name.required'         => 'Brand name required',
                'brand_name.unique'         => 'Brand name exists',
                'brand_icon.required'        => 'Brand icon required',
                'brand_icon.dimensions'        => 'Brand icon dimensions is invalid',
            ]
        );

        //  dd($request->all());

        if (!$validator->fails()) {
            $data = $request->except('_token');
            $row = Mst_Brand::find($brand_id);
            $row->brand_name         = $request->brand_name;
            $row->brand_name_slug      = Str::of($request->brand_name)->slug('-');
            $row->is_active = $request->is_active;
            if ($request->hasFile('brand_icon')) {
                $file = $request->file('brand_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/brand_icon', $filename);
                $row->brand_icon = $filename;
            }
            
                if ($row->update()) {
                Mst_brandsubcat::where('brand_id', $brand_id)->delete();
               
                    foreach (array_unique($request->category) as  $row) {
                    $records=Mst_ItemLevelTwoSubCategory::where('iltsc_id',$row)->first();

                    $cb = new Mst_brandsubcat;
                    $cb->brand_id = $brand_id;
                    $cb->item_category_id = $records->item_category_id;
                    $cb->item_sub_category_id = $records->item_sub_category_id;
                    $cb->iltsc_id = $row;
                    $cb->save();
                }
            }
            return redirect('admin/brands/list')->with('status', 'Brand updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function removeBrand(Request $request, $brand_id)
    {
        Mst_Brand::where('brand_id', '=', $brand_id)->delete();
        return redirect('admin/brands/list')->with('status', 'Brand deleted successfully.');
    }




    public function listTaxes(Request $request)
    {
        $pageTitle = "Taxes";
        $taxes = Mst_Tax::orderBy('tax_id', 'DESC')->get();
        $tax_splits = Trn_TaxSplit::orderBy('tax_split_id', 'DESC')->get();
        return view('admin.elements.taxes.list', compact('tax_splits', 'pageTitle', 'taxes'));
    }

    public function addTaxes(Request $request)
    {
        $pageTitle = "Add Tax";
        return view('admin.elements.taxes.create', compact('pageTitle'));
    }

    public function createTax(Request $request, Mst_Tax $tax)
    {
        $tax->tax_value  = $request->tax_value;
        $tax->tax_name  = $request->tax_name;
        $tax->is_active  = $request->is_active;
        $tax->save();

        $last_id = DB::getPdo()->lastInsertId();
        $i = 0;
        foreach ($request->split_tax_name as $tax) {
            $taxSplit = new Trn_TaxSplit;
            $taxSplit->tax_id = $last_id;
            $taxSplit->tax_split_name  = $tax;
            $taxSplit->tax_split_value  =  $request->split_tax_value[$i];
            $taxSplit->save();
            $i++;
        }
        return redirect('admin/tax/list')->with('status', 'Tax added successfully.');
    }

    public function editTax(Request $request, Mst_Tax $tax, $tax_id)
    {
        $pageTitle = "Edit Tax";
        $tax = Mst_Tax::find($tax_id);
        $tax_splits = Trn_TaxSplit::where('tax_id', $tax_id)->get();
        return view('admin.elements.taxes.edit', compact('tax_splits', 'pageTitle', 'tax'));
    }

    public function editStatusTax(Request $request)
    {
        $tax_id = $request->tax_id;
        if ($c = Mst_Tax::findOrFail($tax_id)) {
            if ($c->is_active == 0) {
                Mst_Tax::where('tax_id', $tax_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Tax::where('tax_id', $tax_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function updateTax(Request $request, Mst_Tax $tax, $tax_id)
    {
        $tax = Mst_Tax::find($tax_id);
        $tax->tax_value  = $request->tax_value;
        $tax->tax_name  = $request->tax_name;
        $tax->is_active  = $request->is_active;
        $tax->update();

        Trn_TaxSplit::where('tax_id', $tax_id)->delete();

        $i = 0;
        foreach ($request->split_tax_name as $tax) {
            $taxSplit = new Trn_TaxSplit;
            $taxSplit->tax_id = $tax_id;
            $taxSplit->tax_split_name  = $tax;
            $taxSplit->tax_split_value  =  $request->split_tax_value[$i];
            $taxSplit->save();
            $i++;
        }

        return redirect('admin/tax/list')->with('status', 'Tax updated successfully.');
    }
}
