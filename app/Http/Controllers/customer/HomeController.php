<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_CustomerBanner;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function Home(Request $request)
    {
        $sliderBanner = Mst_CustomerBanner::where('is_active', 1)->orderBy('is_default', 'DESC')->orderBy('customer_banner_id', 'DESC')->get();
        return view('customer.home', compact('sliderBanner'));
    }
}
