<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_CustomerAddress extends Model
{
    use SoftDeletes;


    protected $table = "trn__customer_addresses";
    protected $primaryKey = "customer_address_id";

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'alternative_phone',
        'pincode',
        'state',
        'city',
        'house',
        'street',
        'landmark',
        'longitude',
        'latitude',
        'is_home_address',
        'is_default',
        'is_active',
    ];

    public function customerData()
    {
        return $this->belongsTo('App\Models\admin\Mst_Customer', 'customer_id', 'customer_id');
    }
}
