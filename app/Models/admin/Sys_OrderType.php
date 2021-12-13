<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sys_OrderType extends Model
{
    use SoftDeletes;


    protected $table = "sys__order_types";
    protected $primaryKey = "order_type_id";

    protected $fillable = [
        'order_type',
        'is_active',
    ];
}
