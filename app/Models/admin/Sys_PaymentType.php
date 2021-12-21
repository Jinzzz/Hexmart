<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sys_PaymentType extends Model
{
    //  use SoftDeletes;


    protected $table = "sys__payment_types";
    protected $primaryKey = "payment_type_id";

    protected $fillable = [
        'payment_type',
    ];
}
