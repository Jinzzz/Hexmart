<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trn_TaxSplit extends Model
{
    use SoftDeletes;

    protected $table = "trn__tax_splits";
    protected $primaryKey = "tax_split_id";

    protected $fillable = [
        'tax_id',
        'tax_split_name',
        'tax_split_value'
    ];

    public function taxSplit()
    {
        return $this->belongsTo('App\Models\admin\Mst_Tax', 'tax_id', 'tax_id');
    }
}
