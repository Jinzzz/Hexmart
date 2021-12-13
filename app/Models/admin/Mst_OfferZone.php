<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_OfferZone extends Model
{
    use SoftDeletes;

    protected $table = "mst__offer_zones";
    protected $primaryKey = "offer_id";

    protected $fillable = [
        'product_variant_id',
        'date_start',
        'time_start',
        'date_end',
        'time_end',
        'link',
        'is_active',
        'offer_price',

    ];

    public function productVariantData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }
}
