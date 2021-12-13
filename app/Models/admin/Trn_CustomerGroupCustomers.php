<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_CustomerGroupCustomers extends Model
{
    use SoftDeletes;


    protected $table = "trn__customer_group_customers";
    protected $primaryKey = "cgc_id";

    protected $fillable = [
        'cgc_id',
        'customer_group_id',
        'customer_id',
        'is_active',
    ];

    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }

    public function customerGroupData()
    {
        return $this->belongsTo('App\Models\admin\Mst_CustomerGroup', 'customer_group_id', 'customer_group_id');
    }
}
