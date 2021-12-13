<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Sys_DisputeStatus extends Model
{
    protected $table = "sys__dispute_statuses";
    protected $primaryKey = "dispute_status_id";

    protected $fillable = [
        'dispute_status',
        'is_active',
    ];
}
