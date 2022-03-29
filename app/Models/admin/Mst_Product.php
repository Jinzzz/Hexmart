<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_Product extends Model
{
    use SoftDeletes;

    protected $table = "mst__products";
    protected $primaryKey = "product_id";

    protected $fillable = [
        'product_id',
        'product_name',
        'product_name_slug',
        'product_code',
        'item_category_id',
        'item_sub_category_id',
        'iltsc_id',
        'brand_id',
        'product_price_regular',
        'product_price_offer',
        'product_description',
        'min_stock',
        'tax_id',
        'product_type',
        'service_type',
        'is_active'
    ];

    public function taxData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Tax', 'tax_id', 'tax_id');
    }

    public function brandData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Brand', 'brand_id', 'brand_id');
    }

    public function itemCategoryData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemCategory', 'item_category_id', 'item_category_id');
    }

    public function itemSubCategoryData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemSubCategory', 'item_sub_category_id', 'item_sub_category_id');
    }

    public function itemSubCatLevTwoData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemLevelTwoSubCategory', 'iltsc_id', 'iltsc_id');
    }

    public function Productvarients()
    {
        return $this->hasMany('App\Models\admin\Mst_ProductVariant', 'product_id', 'product_id');
    }

    public function attribute_group()
    {
        return $this->belongsTo('App\Models\admin\Trn_ItemVariantAttribute', 'product_id', 'product_id');
    }
}
