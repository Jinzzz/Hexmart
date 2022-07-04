<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_Order extends Model
{
    use SoftDeletes;
    protected $table = "trn__orders";
    protected $primaryKey = "order_id";

    protected $fillable = [
        'order_number',
        'order_status_id',
        'customer_id',
        'time_slot_id',
        'order_total_amount',
        'order_total_quantity',
        'delivery_charge',
        'packing_charge',
        'delivery_date',
        'payment_type_id',
        'customer_address_id',
        'payment_status_id',
        'delivery_boy_id',
        'delivery_status_id',
        'db_accept_status',
        'order_note',
        'order_type_id',
        'coupon_id',
        'amount_reduced_by_coupon',
        'reward_points_used',
        'amount_reduced_by_rp',
        'transaction_id',
        'created_at',
    ];

    public function orderItems()
    {
        return $this->hasMany('App\Models\admin\Trn_OrderItem', 'order_id', 'order_id');
    }


    public function orderStatusData()
    {
        return $this->belongsTo('App\Models\admin\Sys_OrderStatus', 'order_status_id', 'order_status_id');
    }

    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function timeSlotData()
    {
        return $this->belongsTo('App\Models\admin\Mst_TimeSlot', 'time_slot_id', 'time_slot_id');
    }

    public function paymentTypeData()
    {
        return $this->belongsTo('App\Models\admin\Sys_PaymentType', 'payment_type_id', 'payment_type_id');
    }

    public function customerAddressData()
    {
        return $this->belongsTo('App\Models\admin\Trn_CustomerAddress', 'customer_address_id', 'customer_address_id');
    }

    public function paymentStatusData()
    {
        return $this->belongsTo('App\Models\admin\Sys_PaymentStatus', 'payment_status_id', 'payment_status_id');
    }

    public function deliveryBoyData()
    {
        return $this->belongsTo('App\Models\admin\Mst_DeliveryBoy', 'delivery_boy_id', 'delivery_boy_id');
    }

    public function deliveryBoyStatus()
    {
        return $this->belongsTo('App\Models\admin\Sys_DeliveryStatus', 'delivery_status_id', 'delivery_status_id');
    }

    public function orderTypeData()
    {
        return $this->belongsTo('App\Models\admin\Sys_OrderType', 'order_type_id', 'order_type_id');
    }

    public function couponData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Coupon', 'coupon_id', 'coupon_id');
    }
}
