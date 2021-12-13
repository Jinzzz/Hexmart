<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_Brand extends Model
{
    use SoftDeletes;


    protected $table = "mst__brands";
    protected $primaryKey = "brand_id";

    protected $fillable = [
        'brand_name',
        'brand_name_slug',
        'brand_icon',
        'is_active'

    ];
}
