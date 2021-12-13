<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_Tax extends Model
{
    use SoftDeletes;

    protected $table = "mst__taxes";
    protected $primaryKey = "tax_id";

    protected $fillable = [
        'tax_value',
        'tax_name',
        'is_active'
    ];
    public function taxSplits()
    {
        return $this->hasMany('App\Models\admin\Trn_TaxSplit', 'tax_id', 'tax_id');
    }
}
