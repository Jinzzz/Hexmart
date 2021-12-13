<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_Setting extends Model
{
    use SoftDeletes;
    protected $table = "mst__settings";
    protected $primaryKey = "setting_id";

    protected $fillable = [
        'service_area',
        'order_number_prefix',
        'is_tax_included',
        'is_active',
        'deleted_at',
    ];
}
