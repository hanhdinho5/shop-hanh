<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show(){
        $orders_new = Order::orderBy('created_at', 'desc')->where('status', '0')->simplepaginate(10);

        $count_01 = Order::where('status', '0')->orWhere('status', '1')->count();
        $count_2 = Order::where('status', '2')->count();
        $count_3 = Order::where('status', '3')->count();
        $count = [$count_01, $count_2, $count_3];

        $total_revenue = 0;
        $list_complete = Order::where('status', '2')->get();
        foreach ($list_complete as $item){
            $total_revenue += intval(str_replace(',', '', $item->total_price));
        }

        return view('admin.dashboard', compact('orders_new', 'count', 'total_revenue'));
    }
}
