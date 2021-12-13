<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_WishList extends Model
{
    use SoftDeletes;
    protected $table = "trn__wish_lists";
    protected $primaryKey = "wish_list_id";

    protected $fillable = [
        'customer_id',
        'product_variant_id',
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
