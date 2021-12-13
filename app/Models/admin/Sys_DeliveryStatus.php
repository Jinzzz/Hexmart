<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sys_DeliveryStatus extends Model
{
    use SoftDeletes;


    protected $table = "sys__delivery_statuses";
    protected $primaryKey = "delivery_status_id";

    protected $fillable = [
        'delivery_status',
        'is_active',
    ];
}
