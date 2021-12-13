<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_AttributeValue extends Model
{
    use SoftDeletes;


    protected $table = "mst__attribute_values";
    protected $primaryKey = "attribute_value_id";

    protected $fillable = [
        'attribute_group_id',
        'attribute_value',
        'is_active'
    ];

    public function ag()
    {
        return $this->belongsTo('App\Models\admin\Mst_AttributeGroup', 'attribute_group_id', 'attribute_group_id');
    }
}
