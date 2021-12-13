<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_DeliveryBoy extends Model
{
    use SoftDeletes;


    protected $table = "mst__delivery_boys";
    protected $primaryKey = "delivery_boy_id";

    protected $fillable = [
        'delivery_boy_name',
        'delivery_boy_phone',
        'delivery_boy_email',
        'delivery_boy_address',
        'state_id',
        'district_id',
        'town_id',
        'password',
        'is_online',
        'is_active',
    ];
}
