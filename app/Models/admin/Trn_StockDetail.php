<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Trn_StockDetail extends Model
{
    protected $table = "trn__stock_details";
    protected $primaryKey = "stock_detail_id";

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'added_stock',
        'current_stock',
        'prev_stock',
        'is_added',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function product_varient()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }
}
