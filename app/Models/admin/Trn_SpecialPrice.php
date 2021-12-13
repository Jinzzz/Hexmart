<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_SpecialPrice extends Model
{
    use SoftDeletes;


    protected $table = "trn__special_prices";
    protected $primaryKey = "special_price_id";

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'customer_group_id',
        'special_price',
        'is_active',
    ];

    public function productData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function productVariantData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }

    public function customerGroupData()
    {
        return $this->belongsTo('App\Models\admin\Mst_CustomerGroup', 'customer_group_id', 'customer_group_id');
    }
}
