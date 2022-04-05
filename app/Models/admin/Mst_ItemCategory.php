<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_ItemCategory extends Model
{
    use SoftDeletes;

    protected $table = "mst__item_categories";
    protected $primaryKey = "item_category_id";

    protected $fillable = [
        'item_category_id',
        'category_name',
        'category_name_slug',
        'category_icon',
        'category_description',
        'is_active',
    ];
    public function itemSubCategoryL1Data()
    {
        return $this->hasMany('App\Models\admin\Mst_ItemSubCategory', 'item_category_id', 'item_category_id');
    }
}
