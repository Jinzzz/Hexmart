<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_OrderItem extends Model
{
    use SoftDeletes;

    protected $table = "trn__order_items";
    protected $primaryKey = "order_item_id";

    protected $fillable = [
        'order_id',
        'order_number',
        'customer_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'is_store_ticked',
        'is_db_ticked',
        'offer_id',
        'created_at',
    ];

    public function orderData()
    {
        return $this->belongsTo('App\Models\admin\Trn_Order', 'order_id', 'order_id');
    }

    public function offerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_OfferZone', 'offer_id', 'offer_id');
    }

    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function productData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function productVariantData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }
    public function cart_Data()
    {
        return $this->belongsTo('App\Models\admin\Trn_Cart', 'product_variant_id', 'product_variant_id');
    }
}

