<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Arr;
use DataTables;

class StockReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }


  public function index()
  {
    //     // dd(Auth::guard('admin')->user()->id);
    $get_stock_lot = DB::table('db_stock_lot')
      ->select('db_stock_lot.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stock_lot.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stock_lot.warehouse_id_fk')
      ->get();

    // dd($get_stock_lot);

    $get_branch = DB::table('branch')
      ->where('status', 1)
      ->get();

    $get_warehouse = DB::table('db_warehouse')
      ->where('status', 1)
      ->get();

    $get_product = DB::table('products')
      ->where('status', 1)
      ->get();


    return view('backend/stock_report', compact('get_stock_lot', 'get_branch', 'get_warehouse', 'get_product'));
  }

  public function get_data_warehouse_select(Request $request)
  {

    $get_warehouse = DB::table('db_warehouse')
      ->where('branch_id_fk', $request->id)
      ->where('status', 1)
      ->get();

    return response()->json($get_warehouse);
  }

  public function Stock_report_datatable(Request $rs)
  {

    $get_stock_lot = DB::table('db_stock_lot')
      ->select('db_stock_lot.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stock_lot.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stock_lot.warehouse_id_fk')
      ->where('db_stock_lot.stock_status','=','confirm')

      ->whereRaw(("case WHEN  '{$rs->s_branch_id_fk}' != ''  THEN  db_stock_lot.branch_id_fk = '{$rs->s_branch_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_warehouse_id_fk}' != ''  THEN  db_stock_lot.warehouse_id_fk = '{$rs->s_warehouse_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_product_name}' != ''  THEN  db_stock_lot.product_id_fk = '{$rs->s_product_name}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_lot_number}' != ''  THEN  db_stock_lot.lot_number = '{$rs->s_lot_number}' else 1 END"))
      ->orderBy('id','desc'); 


      // ->whereRaw(("case WHEN  '{$rs->s_lot_number}' != ''  THEN  db_stock_lot.lot_number = '{$rs->s_lot_number}' else 1 END"))->get();
      // dd($rs->s_lot_number);


    // ->whereRaw(("case WHEN  '{$rs->position}' != ''  THEN  customers.qualification_id = '{$rs->position}' else 1 END"))
    // ->whereRaw(("case WHEN  '{$rs->id_card}' != ''  THEN  customers.id_card = '{$rs->id_card}' else 1 END"))


    //$query->orderBy($request->input('order.0.column'), $request->input('order.0.dir'))

    $sQuery = Datatables::of($get_stock_lot);
    return $sQuery


      ->addColumn('branch_name', function ($row) {
        return $row->branch_name;
      })

      ->addColumn('warehouse_name', function ($row) {
        return $row->warehouse_name;
      })

      ->addColumn('product_name', function ($row) {
        return $row->product_name;
      })

      ->addColumn('lot_number', function ($row) {
        return $row->lot_number;
      })

      
      ->addColumn('amt', function ($row) {
        return $row->amt;
      })

      ->addColumn('lot_balance', function ($row) {
        return $row->lot_balance;
      })

      ->addColumn('product_unit_name', function ($row) {
        return $row->product_unit_name;
      })

      ->addColumn('stock_type', function ($row) {
        if ($row->stock_type == 'in') {
          $html = '<span class="badge badge-rounded outline-badge-success">รับเข้าสินค้า</span>';
        } elseif ($row->stock_type == 'transfer') {
          $html = '<span class="badge badge-rounded outline-badge-danger">โอนย้ายระหว่างสาขา (ฝั่งโอน)</span>';
        } elseif ($row->stock_type == 'in_transfer') {
          $html = '<span class="badge badge-rounded outline-badge-success">โอนย้ายระหว่างสาขา (ฝั่งรับโอน)</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('date_in_stock', function ($row) {

        if ($row->date_in_stock) {
          return date('Y/m/d', strtotime($row->date_in_stock));
        } else {
          return '';
        }
      })

      ->addColumn('lot_expired_date', function ($row) {


        if ($row->lot_expired_date) {
          return date('Y/m/d', strtotime($row->lot_expired_date));
        } else {
          return '';
        }
      })

    
      ->addColumn('action', function ($row) {

        $url = route('admin/Stock_card',['lot_id'=>$row->id]);
        $html = '<a href="'.$url.'" class="badge badge-rounded outline-badge-info">STOCK CARD</a>';

        return $html;
      })


      ->rawColumns(['stock_type','action'])

      ->make(true);
  }
}
