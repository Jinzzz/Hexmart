<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mst_CustomerGroup extends Model
{
    use SoftDeletes;


    protected $table = "mst__customer_groups";
    protected $primaryKey = "customer_group_id";

    protected $fillable = [
        'customer_group_name',
        'customer_group_description',
        'is_active',
    ];
}
