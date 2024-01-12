<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
public function __construct()
{
    $this->middleware('admin');
}
  public function index()
  {

    $customers_count = DB::table('customers')
    ->count();

    $date_start = date('Y-m-d 00:00:00');
    $date_end = date('Y-m-d 23:59:59');
    $orders_count = DB::table('db_orders')

    ->where('db_orders.order_status_id_fk', '=', '5')
    ->where('db_orders.sent_stock_type', '=', 'send')
    ->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)))
    ->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)))
    ->count();
    return  view('backend.dashboard',compact('customers_count','orders_count'));

  }
}
