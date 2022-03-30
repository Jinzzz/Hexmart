<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mst_Customer extends Authenticatable
{
    protected $guard = 'customer';

    use SoftDeletes, HasApiTokens;


    protected $table = "mst__customers";
    protected $primaryKey = "customer_id";

    protected $fillable = [
        'customer_id'.
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_dob',
        'customer_gender',
        'password',
        'latitude',
        'longitude',
        'place',
        'otp',
        'otp_genarated_time',
        'is_otp_verified',
        'is_active',
    ];

    public function addresses()
    {
        return $this->hasMany('App\Models\admin\Trn_CustomerAddress', 'customer_id', 'customer_id');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\Models\OauthAccessToken', 'user_id', 'customer_id');
    }
}
