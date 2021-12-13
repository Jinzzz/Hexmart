<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_Dispute extends Model
{
    use SoftDeletes;
    protected $table = "trn__disputes";
    protected $primaryKey = "dispute_id";

    protected $fillable = [
        'issue_id',
        'order_id',
        'order_item_id',
        'customer_id',
        'dispute_status_id',
        'dispute_discription'
    ];

    public function issueData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Issue', 'issue_id', 'issue_id');
    }

    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function orderItemData()
    {
        return $this->belongsTo('App\Models\admin\Trn_OrderItem', 'order_item_id', 'order_item_id');
    }

    public function disputeStatusData()
    {
        return $this->belongsTo('App\Models\admin\Sys_DisputeStatus', 'dispute_status_id', 'dispute_status_id');
    }

    public function orderData()
    {
        return $this->belongsTo('App\Models\admin\Trn_Order', 'order_id', 'order_id');
    }
}
