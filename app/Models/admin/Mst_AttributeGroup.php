<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_AttributeGroup extends Model
{
    use SoftDeletes;


    protected $table = "mst__attribute_groups";
    protected $primaryKey = "attribute_group_id";

    protected $fillable = [
        'attribute_group',
        'is_active'
    ];
}
