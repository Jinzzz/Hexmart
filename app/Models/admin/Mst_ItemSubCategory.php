<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_ItemSubCategory extends Model
{
    use SoftDeletes;

    protected $table = "mst__item_sub_categories";
    protected $primaryKey = "item_sub_category_id";

    protected $fillable = [
        'item_category_id',
        'sub_category_name',
        'sub_category_name_slug',
        'sub_category_icon',
        'sub_category_description',
        'is_active',
    ];
    public function itemCategoryData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemCategory', 'item_category_id', 'item_category_id');
    }

    public function itemSubCategoryL2Data()
    {
        return $this->hasMany('App\Models\admin\Mst_ItemLevelTwoSubCategory', 'item_sub_category_id', 'item_sub_category_id');
    }
}
