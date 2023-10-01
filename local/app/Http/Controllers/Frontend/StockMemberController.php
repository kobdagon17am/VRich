<?php

namespace App\Http\Controllers\Frontend;

use App\Customers;
use App\CustomersBank;
use App\eWallet;
use App\eWallet_tranfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Expr\FuncCall;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use DB;

class StockMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function index()
    {
        $stock = DB::table('db_stock_members')
        ->leftjoin('product_images', 'product_images.product_id_fk', '=', 'db_stock_members.product_id')
        ->where('db_stock_members.customers_id_fk', '=', Auth::guard('c_user')->user()->id)
        ->where('product_image_orderby','=',1)
        ->get();

        $stock_pv = DB::table('db_stock_members')
        ->select(DB::raw('sum(pv_total) as pv_total'))
        ->where('pv_total','>',0)
        ->where('db_stock_members.customers_id_fk', '=', Auth::guard('c_user')->user()->id)
        ->first();

        // if ($sql_reservations) {
        //   $poin = $sql_reservations->point;
        // } else {
        //   $poin = 0;
        // }

        if ($stock_pv) {
          $point = $stock_pv->pv_total;
        } else {
          $point = 0;
        }


        return view('frontend/StockMember',compact('stock'));
    }


}
