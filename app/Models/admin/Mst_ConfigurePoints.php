<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Mst_ConfigurePoints extends Model
{
    protected $table = "mst__configure_points";
    protected $primaryKey = "configure_point_id";

    protected $fillable = [
        'registraion_points',
        'first_order_points',
        'referal_points',
        'rupee',
        'rupee_points',
        'order_amount',
        'order_points',
        'redeem_percentage',
        'max_redeem_amount',
        'joiner_points',
    ];
}
