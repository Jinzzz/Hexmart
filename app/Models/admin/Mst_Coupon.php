<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_Coupon extends Model
{
    use SoftDeletes;


    protected $table = "mst__coupons";
    protected $primaryKey = "coupon_id";

    protected $fillable = [
        'coupon_code',
        'coupon_type',
        'min_purchase_amt',
        'discount_type',
        'discount',
        'valid_from',
        'valid_to',
        'coupon_status',

    ];
}
