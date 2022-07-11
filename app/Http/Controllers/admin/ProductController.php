<?php

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Image;
use Hash;
use DB;
use Carbon\Carbon;
use Crypt;

use App\Models\admin\Mst_AttributeGroup;
use App\Models\admin\Mst_AttributeValue;
use App\Models\admin\Mst_Brand;
use App\Models\admin\Mst_CustomerGroup;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_Tax;
use App\Models\admin\Mst_Unit;
use App\Models\admin\Trn_ItemImage;
use App\Models\admin\Trn_ItemVariantAttribute;
use App\Models\admin\Trn_SpecialPrice;
use App\Models\admin\Trn_StockDetail;
use App\Models\admin\Trn_TaxSplit;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listProduct(Request $request)
    {
        $pageTitle = "Products";

        $products = Mst_Product::join('mst__item_categories', 'mst__item_categories.item_category_id', '=', 'mst__products.item_category_id')
            ->orderBy('mst__products.product_id', 'DESC')
            ->get();

        return view(
            'admin.elements.products.list',
            compact(
                'products',
                'pageTitle',
            )
        );
    }

    public function createProduct()
    {
        $pageTitle = 'Create Product';
        $tax = Mst_Tax::where('is_active', 1)->orderBy('tax_id', 'DESC')->get();
        $category = Mst_ItemCategory::where('is_active', 1)->orderBy('item_category_id', 'DESC')->get();
        $brands = Mst_Brand::where('is_active', 1)->orderBy('brand_id', 'DESC')->get();
        $units = Mst_Unit::where('is_active', 1)->orderBy('unit_id', 'DESC')->get();
        $attr_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group_id', 'DESC')->get();

        $customerGroups = Mst_CustomerGroup::where('is_active', 1)->orderBy('customer_group_id', 'DESC')->get();
        return view(
            'admin.elements.products.create',
            compact(
                'tax',
                'pageTitle',
                'category',
                'brands',
                'attr_groups',
                'units',
                'customerGroups',
            )
        );
    }

    public function editProduct(Request $request, $product_id)
    {
        $pageTitle = 'Edit Product';
        $product = Mst_Product::find($product_id);
        $productVar = Mst_ProductVariant::where('product_id', $product_id)->get();
        $product_images  = Trn_ItemImage::where('product_id', $product_id)->orderBy('product_variant_id')->get();
        $tax = Mst_Tax::where('is_active', 1)->orderBy('tax_id', 'DESC')->get();
        $subcategories = Mst_ItemSubCategory::where('item_category_id', $product->item_category_id)->where('is_active', 1)->orderBy('item_sub_category_id', 'DESC')->get();
        $subcategorieslevtwo = Mst_ItemLevelTwoSubCategory::where('item_sub_category_id', $product->item_sub_category_id)
            ->where('is_active', 1)->orderBy('iltsc_id', 'DESC')
            ->get();
        $category = Mst_ItemCategory::where('is_active', 1)->orderBy('item_category_id', 'DESC')->get();
        $brands = Mst_Brand::where('is_active', 1)->orderBy('brand_id', 'DESC')->get();
        $units = Mst_Unit::where('is_active', 1)->orderBy('unit_id', 'DESC')->get();
        $attr_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group_id', 'DESC')->get();
        return view(
            'admin.elements.products.edit',
            compact(
                'tax',
                'pageTitle',
                'category',
                'brands',
                'attr_groups',
                'units',
                'product',
                'subcategories',
                'productVar',
                'product_images',
                'subcategorieslevtwo',
            )
        );
    }

    public function listProductVariant(Request $request, $product_id)
    {
        $pageTitle = "Product Variants";
        $attr_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group')->get();

        $product_variants  = Mst_ProductVariant::where('product_id', '=', $product_id)->orderBy('product_variant_id')->get();
        return view('admin.elements.products.list_variants', compact('attr_groups', 'product_variants', 'pageTitle'));
    }
    public function editProductVariant(Request $request, $product_variant_id)
    {
        $pageTitle = "Edit Product Variant";
        $attr_groups = Mst_AttributeGroup::where('is_active', 1)->orderBy('attribute_group')->get();

        $product_variant = Mst_ProductVariant::find($product_variant_id);
        return view('admin.elements.products.edit_variant', compact('attr_groups', 'product_variant', 'pageTitle'));
    }



    public function viewProduct(Request $request, $id)
    {
        $pageTitle = "View Product";

        $product = Mst_Product::where('product_id', '=', $id)->first();
        $product_id = $product->product_id;
        $product_varients = Mst_ProductVariant::where('product_id', $product_id)
            ->orderBy('product_variant_id', 'DESC')
            ->get();
        $product_images = Trn_ItemImage::where('product_id', '=', $product_id)->get();

        return view('admin.elements.products.view', compact('product_varients', 'product', 'pageTitle', 'product_images'));
    }


    public function updateProductVariant(Request $request, $product_variant_id)
    {
        $data['variant_name'] = $request->variant_name;
        $data['variant_name_slug'] = Str::of($request->variant_name)->slug('-');
        $data['variant_price_regular'] = $request->product_varient_price;
        $data['variant_price_offer'] = $request->product_varient_offer_price;
        Mst_ProductVariant::where('product_variant_id', $product_variant_id)->update($data);


        $productData = Mst_ProductVariant::find($product_variant_id);

        if ($request->hasFile('product_image')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg',];
            $files = $request->file('product_image');
            $c = 1;
            foreach ($files as $file) {

                $filename = time() . '_' . $file->getClientOriginalName();
                if ($file->move('assets/uploads/products', $filename)) {

                    $itemImage = new Trn_ItemImage;
                    $itemImage->product_id = $productData->product_id;
                    $itemImage->product_variant_id = $product_variant_id;
                    $itemImage->item_image_name = $filename;

                    $itemImage->is_default = 0;

                    $itemImage->is_active = 1;
                    $itemImage->save();

                    $c++;
                }
            }
        }


        return redirect('/admin/product-variant/list/' . $productData->product_id)->with('status', 'Product variant updated successfully.');
    }



    public function storeProVarAttr(Request $request, Trn_ItemVariantAttribute $var_att)
    {
        $varData = Mst_ProductVariant::find($request->product_variant_id);
        $var_att->product_id = $varData->product_id;
        $var_att->product_variant_id = $request->product_variant_id;
        $var_att->attribute_group_id = $request->attr_grp_id;
        $var_att->attribute_value_id = $request->attr_val_id;
        $var_att->save();
        return redirect()->back()->with('status', 'New attribute added to product variant successfully.');
    }

    public function removeProVarAttr(Request $request, $variant_attribute_id)
    {
        $pro_variant_attr = Trn_ItemVariantAttribute::where('variant_attribute_id', '=', $variant_attribute_id);
        $pro_variant_attr->delete();
        return redirect()->back()->with('status', 'Product variant attribute deleted successfully.');
    }

    public function removeProductVariant(Request $request, $product_variant_id)
    {
        // dd($product_variant_id);
        $pro_variant = Mst_ProductVariant::where('product_variant_id', '=', $product_variant_id)->first();
        Mst_ProductVariant::where('product_variant_id', '=', $product_variant_id)->delete();
        Trn_ItemImage::where('product_variant_id', '=', $product_variant_id)->delete();

        $productVarCount = Mst_ProductVariant::where('product_id', $pro_variant->product_id)->count();
        if ($productVarCount < 1) {
            Mst_Product::where('product_id', $pro_variant->product_id)->update(['is_active' => 0]);
        }
        return redirect()->back()->with('status', 'Product variant deleted successfully.');
    }

    public function storeProduct(Request $request, Mst_Product $product)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    // 'product_name'          => 'required|unique:mst__products,product_name',
                    'product_name'          => 'required',
                    'product_description'   => 'required',
                    'regular_price'   => 'required',
                    'sale_price'   => 'required',
                    'tax_id'   => 'required',
                    'min_stock'   => 'required',
                    'product_code'   => 'required',
                    'product_cat_id'   => 'required',
                    'brand_id'   => 'required',
                    // 'product_image.*' => 'required|dimensions:min_width=1000,min_height=800',
                    'product_image.*' => 'required',

                ],
                [

                    'product_name.required'             => 'Product name required',
                    'product_name.unique'             => 'Product name already exist',
                    'product_description.required'      => 'Product description required',
                    'regular_price.required'      => 'Regular price required',
                    'sale_price.required'      => 'Sale price required',
                    'tax_id.required'      => 'Tax required',
                    'min_stock.required'      => 'Minimum stock required',
                    'product_code.required'      => 'Product code required',
                    'business_type_id.required'        => 'Product type required',
                    'attr_group_id.required'        => 'Attribute group required',
                    'attr_value_id.required'        => 'Attribute value required',
                    'product_cat_id.required'        => 'Product category required',
                    'brand_id.required'        => 'Brand required',
                    'color_id.required'        => 'Color required',
                    'product_image.required'        => 'Product image required',
                    'product_image.dimensions'        => 'Product image dimensions invalid',

                ]
            );

            if (!$validator->fails()) {


                $product->product_name           = $request->product_name;
                $product->product_name_slug      = Str::of($request->product_name)->slug('-');
                $product->product_code           = $request->product_code;
                $product->item_category_id         = $request->product_cat_id;
                $product->item_sub_category_id   = $request->sub_category_id; // new
                $product->iltsc_id   = $request->iltsc_id; // new
                $product->brand_id               = $request->brand_id;
                $product->product_price_regular          = $request->regular_price;
                $product->product_price_offer    = $request->sale_price;
                $product->product_description    = $request->product_description;
                $product->tax_id                 = $request->tax_id; // new
                $product->min_stock                 = $request->min_stock; // min count
                $product->is_active                 = $request->is_active; // status

                if (!isset($request->is_active))
                    $product->is_active = 1;

                $product->product_type               =  $request->product_type; // new
                if ($request->product_type == 2)
                    $product->service_type               =  $request->service_type; // new
                else
                    $product->service_type               =  0; // new

                $product->save();
                $id = DB::getPdo()->lastInsertId();

                $c_bcg = 0;
                foreach ($request->customer_group_id as $bcg) {

                    $cgSpObject = new Trn_SpecialPrice;
                    $cgSpObject->product_id = $id;
                    $cgSpObject->product_variant_id = null;
                    $cgSpObject->customer_group_id = $bcg;
                    $cgSpObject->special_price = $request->customer_group_id[$c_bcg];
                    $cgSpObject->is_active = 1;
                    $cgSpObject->save();
                    $c_bcg++;
                }


                if ($request->hasFile('product_image')) {
                    $allowedfileExtension = ['jpg', 'png', 'jpeg',];
                    $files = $request->file('product_image');
                    $c = 1;
                    foreach ($files as $file) {

                        $filename = time() . '_' . $file->getClientOriginalName();
                        if ($file->move('assets/uploads/products', $filename)) {

                            $itemImage = new Trn_ItemImage;
                            $itemImage->product_id = $id;
                            $itemImage->product_variant_id = null;
                            $itemImage->item_image_name = $filename;

                            if ($c == 1)
                                $itemImage->is_default = 1;
                            else
                                $itemImage->is_default = 0;

                            $itemImage->is_active = 1;
                            $itemImage->save();

                            $c++;
                        }

                        $proImg_Id = DB::getPdo()->lastInsertId();
                    }
                }

                $vc = 0;

                foreach ($request->variant_name as  $varName) {

                    if (isset($varName)) {

                        $var = new Mst_ProductVariant;
                        $var->product_id = $id;
                        $var->variant_name = $request->variant_name[$vc];
                        $var->variant_name_slug = Str::of($request->variant_name[$vc])->slug('-');
                        $var->variant_price_regular = $request->var_regular_price[$vc];
                        $var->variant_price_offer = $request->var_sale_price[$vc];
                        $var->stock_count = 0;
                        $var->is_active = 1;
                        $var->unit_id = $request->unit[$vc];
                        $var->save();

                        $vari_id = DB::getPdo()->lastInsertId();

                        $vac = 0;
                        //  dd($vari_id);
                        foreach ($request->attr_group_id[$vc] as $attrGrp) {

                            $data4 = [
                                'product_id' => $id,
                                'product_variant_id' => $vari_id,
                                'attribute_group_id' => $attrGrp,
                                'attribute_value_id' => $request->attr_value_id[$vc][$vac],
                            ];
                            Trn_ItemVariantAttribute::create($data4);
                            // dd($data4);
                            $vac++;
                        }

                        $c_bcg = 0;
                        foreach ($request->var_customer_group_id[$vc] as $bcg_var) {
                            if (isset($bcg_var) && isset($request->var_special_price[$vc][$c_bcg])) {
                                $dataSpCg = [
                                    'product_id' => $id,
                                    'product_variant_id' => $vari_id,
                                    'customer_group_id' => $bcg_var,
                                    'special_price' => $request->var_special_price[$vc][$c_bcg],
                                    'is_active' => 1,
                                ];
                                Trn_SpecialPrice::create($dataSpCg);
                            }
                            $c_bcg++;
                        }

                        $vic = 0;
                        if (isset($request->file('var_images')[$vc])) {

                            $files = $request->file('var_images')[$vc];
                            $c = 1;
                            foreach ($files as $file) {
                                $filename = time() . '_' . $file->getClientOriginalName();
                                $file->move('assets/uploads/products', $filename);

                                $itemImage = new Trn_ItemImage;
                                $itemImage->product_id = $id;
                                $itemImage->product_variant_id = $vari_id;
                                $itemImage->item_image_name = $filename;

                                if ($c == 1)
                                    $itemImage->is_default = 1;
                                else
                                    $itemImage->is_default = 0;

                                $itemImage->is_active = 1;
                                $itemImage->save();
                                $c++;
                            }
                        }
                        $vc++;
                    }
                }

                $countVariants = Mst_ProductVariant::where('product_id', $id)->count();

                if ($countVariants < 1) {

                    $varImages = Trn_ItemImage::where('product_id', $id)->orderBy('item_image_id', 'ASC')->get();

                    $var = new Mst_ProductVariant;
                    $var->product_id = $id;
                    $var->variant_name = $request->product_name;
                    $var->variant_name_slug = Str::of($request->product_name)->slug('-');
                    $var->variant_price_regular = $request->regular_price;
                    $var->variant_price_offer = $request->sale_price;
                    $var->stock_count = 0;
                    $var->is_active = 1;
                    $var->unit_id = null;
                    $var->save();

                    $vari_id = DB::getPdo()->lastInsertId();


                    $c_bcg = 0;
                    foreach ($request->customer_group_id as $bcg) {

                        $cgSpObject = new Trn_SpecialPrice;
                        $cgSpObject->product_id = $id;
                        $cgSpObject->product_variant_id = $vari_id;
                        $cgSpObject->customer_group_id = $bcg;
                        $cgSpObject->special_price = $request->customer_group_id[$c_bcg];
                        $cgSpObject->is_active = 1;
                        $cgSpObject->save();
                        $c_bcg++;
                    }



                    $vic = 0;
                    $c = 1;
                    foreach ($varImages as $vi) {

                        $itemImage = new Trn_ItemImage;
                        $itemImage->product_id = $id;
                        $itemImage->product_variant_id = $vari_id;
                        $itemImage->item_image_name = $vi->item_image_name;

                        if ($c == 1)
                            $itemImage->is_default = 1;
                        else
                            $itemImage->is_default = 0;

                        $itemImage->is_active = 1;
                        $itemImage->save();
                        $c++;
                    }
                }
                //  echo "done";
                //die;
                //dd($request->all(), $request->customer_group_id);

                return redirect('admin/products/list')->with('status', 'Product added successfully.');
            } else {

                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function removeProduct(Request $request, $product_id)
    {
        Mst_Product::where('product_id', '=', $product_id)->delete();
        return redirect('admin/products/list')->with('status', 'Product deleted successfully.');
    }

    public function updateProduct(Request $request,  $product_id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'product_name'       => 'required|unique:mst__products,product_name,' . $product_id . ',product_id',
                    //  'product_name'          => 'required',
                    'product_description'   => 'required',
                    'regular_price'   => 'required',
                    'sale_price'   => 'required',
                    'tax_id'   => 'required',
                    'min_stock'   => 'required',
                    'product_code'   => 'required',
                    'product_cat_id'   => 'required',
                    'brand_id'   => 'required',
                    // 'product_image.*' => 'required|dimensions:min_width=1000,min_height=800',
                    'product_image.*' => 'required',

                ],
                [

                    'product_name.required'             => 'Product name required',
                    'product_name.unique'             => 'Product name already exist',
                    'product_description.required'      => 'Product description required',
                    'regular_price.required'      => 'Regular price required',
                    'sale_price.required'      => 'Sale price required',
                    'tax_id.required'      => 'Tax required',
                    'min_stock.required'      => 'Minimum stock required',
                    'product_code.required'      => 'Product code required',
                    'business_type_id.required'        => 'Product type required',
                    'attr_group_id.required'        => 'Attribute group required',
                    'attr_value_id.required'        => 'Attribute value required',
                    'product_cat_id.required'        => 'Product category required',
                    'brand_id.required'        => 'Brand required',
                    'color_id.required'        => 'Color required',
                    'product_image.required'        => 'Product image required',
                    'product_image.dimensions'        => 'Product image dimensions invalid',

                ]
            );

            if (!$validator->fails()) {

                $product = Mst_Product::find($product_id);
                $product->product_name           = $request->product_name;
                $product->product_name_slug      = Str::of($request->product_name)->slug('-');
                $product->product_code           = $request->product_code;
                $product->item_category_id         = $request->product_cat_id;
                $product->item_sub_category_id   = $request->sub_category_id; // new
                $product->iltsc_id   = $request->iltsc_id; // new
                $product->brand_id               = $request->brand_id;
                $product->product_price_regular          = $request->regular_price;
                $product->product_price_offer    = $request->sale_price;
                $product->product_description    = $request->product_description;
                $product->tax_id                 = $request->tax_id; // new
                $product->min_stock                 = $request->min_stock; // min count
                $product->is_active                 = $request->is_active; // status

                if (!isset($request->is_active))
                    $product->is_active = 1;

                $product->product_type               =  $request->product_type; // new
                if ($request->product_type == 2)
                    $product->service_type               =  $request->service_type; // new
                else
                    $product->service_type               =  0; // new

                $product->update();


                if ($request->hasFile('product_image')) {
                    $allowedfileExtension = ['jpg', 'png', 'jpeg',];
                    $files = $request->file('product_image');
                    $c = 1;
                    foreach ($files as $file) {

                        $filename = time() . '_' . $file->getClientOriginalName();
                        if ($file->move('assets/uploads/products', $filename)) {

                            $itemImage = new Trn_ItemImage;
                            $itemImage->product_id = $product_id;
                            $itemImage->product_variant_id = null;
                            $itemImage->item_image_name = $filename;

                            if ($c == 1)
                                $itemImage->is_default = 1;
                            else
                                $itemImage->is_default = 0;

                            $itemImage->is_active = 1;
                            $itemImage->save();

                            $c++;
                        }

                        $proImg_Id = DB::getPdo()->lastInsertId();
                    }
                }

                $vc = 0;

                foreach ($request->variant_name as  $varName) {

                    if (isset($varName)) {

                        $var = new Mst_ProductVariant;
                        $var->product_id = $product_id;
                        $var->variant_name = $request->variant_name[$vc];
                        $var->variant_name_slug = Str::of($request->variant_name[$vc])->slug('-');
                        $var->variant_price_regular = $request->var_regular_price[$vc];
                        $var->variant_price_offer = $request->var_sale_price[$vc];
                        $var->stock_count = 0;
                        $var->is_active = 1;
                        $var->unit_id = $request->unit[$vc];
                        $var->save();

                        $vari_id = DB::getPdo()->lastInsertId();

                        $vac = 0;
                        foreach ($request->attr_group_id[$vc] as $attrGrp) {

                            $data4 = [
                                'product_id' => $product_id,
                                'product_variant_id' => $vari_id,
                                'attribute_group_id' => $attrGrp,
                                'attribute_value_id' => $request->attr_value_id[$vc][$vac],
                            ];
                            Trn_ItemVariantAttribute::create($data4);
                            $vac++;
                        }

                        $vic = 0;
                        if (isset($request->file('var_images')[$vc])) {

                            $files = $request->file('var_images')[$vc];
                            $c = 1;
                            foreach ($files as $file) {
                                $filename = time() . '_' . $file->getClientOriginalName();
                                $file->move('assets/uploads/products', $filename);

                                $itemImage = new Trn_ItemImage;
                                $itemImage->product_id = $product_id;
                                $itemImage->product_variant_id = $vari_id;
                                $itemImage->item_image_name = $filename;

                                if ($c == 1)
                                    $itemImage->is_default = 1;
                                else
                                    $itemImage->is_default = 0;

                                $itemImage->is_active = 1;
                                $itemImage->save();
                                $c++;
                            }
                        }
                        $vc++;
                    }
                }


                return redirect('admin/products/list')->with('status', 'Product updated successfully.');
            } else {

                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function setDefaultImage(Request $request)
    {
        $imageData = Trn_ItemImage::where('item_image_id', $request->item_image_id)->first();

        if ($request->product_variant_id == 0) {

            Trn_ItemImage::where('product_id', $imageData->product_id)->where('product_variant_id', null)->update(['is_default' => 0]);
            Trn_ItemImage::where('item_image_id', $request->item_image_id)->where('product_variant_id', null)->update(['is_default' => 1]);
            return true;
        } else {
            Trn_ItemImage::where('product_id', $imageData->product_id)->where('product_variant_id', $request->product_variant_id)->update(['is_default' => 0]);
            Trn_ItemImage::where('item_image_id', $request->item_image_id)->where('product_variant_id', $request->product_variant_id)->update(['is_default' => 1]);
            return true;
        }
        return false;
    }

    public function GetItemSubCategory(Request $request)
    {
        $item_category_id = $request->item_category_id;

        $subcategory  = Mst_ItemSubCategory::where("item_category_id", '=', $item_category_id)->pluck("sub_category_name", "item_sub_category_id");
        return response()->json($subcategory);
    }


    public function GetItemSubCategoryL2(Request $request)
    {
        $sub_category_id = $request->sub_category_id;

        $subcategory  = Mst_ItemLevelTwoSubCategory::where("item_sub_category_id", '=', $sub_category_id)->pluck("iltsc_name", "iltsc_id");
        return response()->json($subcategory);
    }

    public function GetAttribiteValue(Request $request)
    {
        $attribute_group_id = $request->attribute_group_id;
        // dd($grp_id);
        $attr_values  = Mst_AttributeValue::where("attribute_group_id", '=', $attribute_group_id)
            ->pluck("attribute_value", "attribute_value_id");

        return response()->json($attr_values);
    }

    public function editStatusProduct(Request $request)
    {
        $product_id = $request->product_id;
        if ($c = Mst_Product::findOrFail($product_id)) {
            if ($c->is_active == 0) {
                Mst_Product::where('product_id', $product_id)->update(['is_active' => 1]);
                echo "active";
            } else {
                Mst_Product::where('product_id', $product_id)->update(['is_active' => 0]);
                echo "inactive";
            }
        }
    }

    public function listInventory(Request $request)
    {
        $pageTitle = "Inventory Management";

        $products = Mst_Product::join('mst__product_variants', 'mst__product_variants.product_id', '=', 'mst__products.product_id')
            ->where('mst__products.product_type', 1);
        if ($_GET) {
            if ($request->product_cat_id) {
                $products = $products->where('mst__products.item_category_id', $request->product_cat_id);
            }
        }
        $products = $products->orderBy('mst__products.product_id', 'DESC')->get();
        $category = Mst_ItemCategory::where('is_active', 1)->get();
        return view(
            'admin.elements.inventory.list',
            compact(
                'products',
                'pageTitle',
                'category'
            )
        );
    }



    public function UpdateStock(Request $request)
    {

        $updated_stock = $request->updated_stock;
        $product_variant_id = $request->product_variant_id;

        $usOld = Mst_ProductVariant::find($product_variant_id);


        if ($us = Mst_ProductVariant::where('product_variant_id', $product_variant_id)->increment('stock_count', $updated_stock)) {
            $usData = Mst_ProductVariant::find($product_variant_id);
            $usProData = Mst_Product::find($usData->product_id);

            $sd = new Trn_StockDetail;
            $sd->product_id = $usData->product_id;
            $sd->product_variant_id = $usData->product_variant_id;
            $sd->added_stock = $request->updated_stock;
            $sd->current_stock = $usData->stock_count;
            $sd->prev_stock = $usOld->stock_count;
            $sd->save();

            $s = Mst_ProductVariant::where('product_variant_id', $product_variant_id)->pluck("stock_count");

            return response()->json($s);
        } else {
            echo "error";
        }
    }

    public function resetStock(Request $request)
    {

        $product_variant_id = $request->product_variant_id;


        $usOld = Mst_ProductVariant::find($product_variant_id);

        if ($usOld->stock_count < 0)
            $updated_stock =  abs($usOld->stock_count);
        else
            $updated_stock =  -$usOld->stock_count;



        if ($us = Mst_ProductVariant::where('product_variant_id', $product_variant_id)->increment('stock_count', $updated_stock)) {
            $usData = Mst_ProductVariant::find($product_variant_id);
            $usProData = Mst_Product::find($usData->product_id);

            $sd = new Trn_StockDetail;
            $sd->product_id = $usData->product_id;
            $sd->product_variant_id = $usData->product_variant_id;
            $sd->added_stock = $updated_stock;
            $sd->current_stock = $usData->stock_count;
            $sd->prev_stock = $usOld->stock_count;
            $sd->save();

            $s = Mst_ProductVariant::where('product_variant_id', $product_variant_id)->pluck("stock_count");

            return response()->json($s);
        } else {
            echo "error";
        }
    }
}
