<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sys_PaymentStatus extends Model
{
    use SoftDeletes;


    protected $table = "sys__payment_statuses";
    protected $primaryKey = "payment_status_id";

    protected $fillable = [
        'payment_status',
        'is_active',
    ];
}
