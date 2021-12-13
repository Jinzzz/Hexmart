<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_Cart extends Model
{
    use SoftDeletes;
    protected $table = "trn__carts";
    protected $primaryKey = "cart_id";

    protected $fillable = [
        'customer_id',
        'product_variant_id',
        'quantity',
        'deleted_at',
    ];



    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function productVariantData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }
}
