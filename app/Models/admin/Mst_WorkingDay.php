<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_WorkingDay extends Model
{
    use SoftDeletes;


    protected $table = "mst__working_days";
    protected $primaryKey = "working_day_id";

    protected $fillable = [
        'day',
        'time_start',
        'time_end',
        'is_active'
    ];
}
