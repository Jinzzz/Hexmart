<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_ItemLevelTwoSubCategory extends Model
{
    use SoftDeletes;

    protected $table = "mst__item_level_two_sub_categories";
    protected $primaryKey = "iltsc_id";

    protected $fillable = [
        'item_category_id',
        'item_sub_category_id',
        'iltsc_name',
        'iltsc_name_slug',
        'iltsc_icon',
        'iltsc_description',
        'is_active',
    ];

    public function itemCategoryData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemCategory', 'item_category_id', 'item_category_id');
    }

    public function itemSubCategoryData()
    {
        return $this->belongsTo('App\Models\admin\Mst_ItemSubCategory', 'item_sub_category_id', 'item_sub_category_id');
    }
}
