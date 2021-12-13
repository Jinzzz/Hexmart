<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_CustomerBanner extends Model
{
    use SoftDeletes;


    protected $table = "mst__customer_banners";
    protected $primaryKey = "customer_banner_id";

    protected $fillable = [
        'customer_banner',
        'link',
        'is_default',
        'is_active',
    ];
}
