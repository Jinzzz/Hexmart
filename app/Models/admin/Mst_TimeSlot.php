<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mst_TimeSlot extends Model
{
    use SoftDeletes;

    protected $table = "mst__time_slots";
    protected $primaryKey = "time_slot_id";

    protected $fillable = [
        'time_start',
        'time_end',
        'is_active',
    ];
}
