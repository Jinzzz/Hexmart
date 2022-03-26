<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_ProductVariant extends Model
{
    use SoftDeletes;
    protected $table = "mst__product_variants";
    protected $primaryKey = "product_variant_id";

    protected $fillable = [
        'product_variant_id',
        'product_id',
        'variant_name',
        'variant_name_slug',
        'variant_price_regular',
        'variant_price_offer',
        'stock_count',
        'unit_id',
        'is_active',
    ];

    public function productData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function unitData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Unit', 'unit_id', 'unit_id');
    }
    public function Productvarients()
    {
        return $this->hasMany('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }
}
