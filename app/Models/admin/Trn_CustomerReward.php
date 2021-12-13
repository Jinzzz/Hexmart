<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_CustomerReward extends Model
{

    use SoftDeletes;
    protected $table = "trn__customer_rewards";
    protected $primaryKey = "customer_reward_id";

    protected $fillable = [
        'reward_points_earned',
        'discription',
        'customer_id',
        'order_id',
        'added_date',
        'is_active'
    ];


    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function orderData()
    {
        return $this->belongsTo('App\Models\admin\Trn_Order', 'order_id', 'order_id');
    }
}
