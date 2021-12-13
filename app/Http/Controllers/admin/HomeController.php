<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller // non authendicated controller
{
    public function index()
    {
        $pageTitle = "JBM-Stock Administrator";
        return view('admin.login', compact('pageTitle'));
    }
}
