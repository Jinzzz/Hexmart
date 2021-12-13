<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_ServiceAreaSplit extends Model
{
    use SoftDeletes;


    protected $table = "trn__service_area_splits";
    protected $primaryKey = "sas_id";

    protected $fillable = [
        'service_start',
        'service_end',
        'delivery_charge',
        'packing_charge',
    ];
}
