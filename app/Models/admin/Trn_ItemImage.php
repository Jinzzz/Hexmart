<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_ItemImage extends Model
{
    use SoftDeletes;
    protected $table = "trn__item_images";
    protected $primaryKey = "item_image_id";

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'item_image_name',
        'is_default',
        'is_active'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }
}
