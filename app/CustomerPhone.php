<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPhone extends Model
{
    use SoftDeletes;


    protected $table = "customer_phone";

    protected $fillable = [
        'customer_id',
        'phone',
    ];
}
