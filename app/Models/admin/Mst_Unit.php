<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Mst_Unit extends Model
{
	use SoftDeletes;


	protected $table = "mst__units";
	protected $primaryKey = "unit_id";

	protected $fillable = [
		'unit_name',
		'unit_sf',
		'is_active'
	];
}
