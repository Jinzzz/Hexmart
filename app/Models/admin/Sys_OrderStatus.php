<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Sys_OrderStatus extends Model
{

    protected $table = "sys__order_statuses";
    protected $primaryKey = "order_status_id";

    protected $fillable = [
        'status',
    ];
}
