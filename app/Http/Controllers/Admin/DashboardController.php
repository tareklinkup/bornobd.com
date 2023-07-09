<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        // $dailyReport = Order::whereDate('updated_at', now())->where('status', 'd')->get();
        // $monthReport = Order::whereMonth('updated_at', now())->where('status', 'd')->get();
       $data['pending'] = Order::where('status','p')->count();
       $data['process'] = Order::where('status','on')->count();
       $data['way'] = Order::where('status','w')->count();
       $data['delivered'] = Order::where('status','d')->count();
        return view('admin.index',$data);
    }

    
}
