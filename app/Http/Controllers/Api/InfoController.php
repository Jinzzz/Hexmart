<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\admin\Sys_DeliveryStatus;
use App\Models\admin\Sys_DisputeStatus;
use App\Models\admin\Sys_IssueType;
use App\Models\admin\Sys_OrderStatus;
use App\Models\admin\Sys_OrderType;
use App\Models\admin\Sys_PaymentStatus;
use App\Models\admin\Sys_PaymentType;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function info(Request $request) // sys table infos
    {
        $data = array();
        $data['orderType'] = Sys_OrderType::all();
        $data['issueType'] = Sys_IssueType::all();
        $data['orderStatus'] = Sys_OrderStatus::all();
        $data['paymentType'] = Sys_PaymentType::all();
        $data['disputeStatus'] = Sys_DisputeStatus::all();
        $data['paymentStatus'] = Sys_PaymentStatus::all();
        $data['deliveryStatus'] = Sys_DeliveryStatus::all();
        return response($data);
    }
}
