<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_ItemVariantAttribute extends Model
{
    use SoftDeletes;
    protected $table = "trn__item_variant_attributes";
	protected $primaryKey = "variant_attribute_id";

	protected $fillable = [
		'product_id',
		'product_variant_id',
		'attribute_group_id',
		'attribute_value_id',
	];

    public function product()
    {
        return $this->belongsTo('App\Models\admin\Mst_Product', 'product_id', 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo('App\Models\admin\Mst_ProductVariant', 'product_variant_id', 'product_variant_id');
    }

    public function attributeGroup()
    {
        return $this->belongsTo('App\Models\admin\Mst_AttributeGroup', 'attribute_group_id', 'attribute_group_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo('App\Models\admin\Mst_AttributeValue', 'attribute_value_id', 'attribute_value_id');
    }


}
