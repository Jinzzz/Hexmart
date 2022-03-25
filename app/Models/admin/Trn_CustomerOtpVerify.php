<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Trn_CustomerOtpVerify extends Model
{
    protected $table = "trn__customer_otp_verifies";
    protected $primaryKey = "customer_otp_id";

    protected $fillable = [
        'customer_id',
        'otp_expirytime',
        'otp',
        'customer_otp_id',
    ];
}
