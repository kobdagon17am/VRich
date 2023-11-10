<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Arr;
use DataTables;

class StockCardController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }


  public function index($lot_id)
  {
    //     // dd(Auth::guard('admin')->user()->id);


    $get_stock_lot = DB::table('db_stock_lot')
      ->where('id', $lot_id)
      ->first();


    $get_stock_movement = DB::table('db_stock_movement')
      ->select('db_stock_movement.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stock_movement.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stock_movement.warehouse_id_fk')
      ->where('db_stock_movement.branch_id_fk', $get_stock_lot->branch_id_fk)
      ->where('db_stock_movement.warehouse_id_fk', $get_stock_lot->warehouse_id_fk)
      ->where('db_stock_movement.product_id_fk', $get_stock_lot->product_id_fk)
      ->where('db_stock_movement.lot_number', $get_stock_lot->lot_number)
      ->orderByDesc('db_stock_movement.id')
      ->first();


    //  dd($get_stock_movement);

    $get_branch = DB::table('branch')
      ->where('status', 1)
      ->get();

    $get_warehouse = DB::table('db_warehouse')
      ->where('status', 1)
      ->get();

    $get_product = DB::table('products')
      ->where('status', 1)
      ->get();


    return view('backend/stock_card', compact('get_stock_movement', 'get_branch', 'get_warehouse', 'get_product'));
  }


  public function Stock_card_datatable(Request $rs)
  {

    $get_stock_movement = DB::table('db_stock_movement')
      ->select('db_stock_movement.*', 'products.product_name as product_name_p', 'products.product_unit_name as product_unit_name_p', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stock_movement.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stock_movement.warehouse_id_fk')
      ->where('db_stock_movement.branch_id_fk', $rs->s_branch_id_fk)
      ->where('db_stock_movement.warehouse_id_fk', $rs->s_warehouse_id_fk)
      ->where('db_stock_movement.product_id_fk', $rs->s_product_id_fk)
      ->where('db_stock_movement.lot_number', $rs->s_lot_number)
      ->orderBy('db_stock_movement.id','DESC');

    //   ->get();

    //   dd($get_stock_movement);


    // ->whereRaw(("case WHEN  '{$rs->s_lot_number}' != ''  THEN  db_stock_lot.lot_number = '{$rs->s_lot_number}' else 1 END"))->get();
    // dd($rs->s_lot_number);


    // ->whereRaw(("case WHEN  '{$rs->position}' != ''  THEN  customers.qualification_id = '{$rs->position}' else 1 END"))
    // ->whereRaw(("case WHEN  '{$rs->id_card}' != ''  THEN  customers.id_card = '{$rs->id_card}' else 1 END"))


    //$query->orderBy($request->input('order.0.column'), $request->input('order.0.dir'))

    $sQuery = Datatables::of($get_stock_movement);
    return $sQuery


      ->addColumn('branch_name', function ($row) {
        return $row->branch_name;
      })

      ->addColumn('warehouse_name', function ($row) {
        return $row->warehouse_name;
      })

      ->addColumn('branch_out_name', function ($row) {
        if ($row->in_out == 'in'||$row->in_out == 'in_transfer' || $row->in_out == 'order') {
          return '';
        } else {
          $get_branch = DB::table('branch')
          ->where('id', $row->branch_out_id_fk)
          ->first();

        return $get_branch->branch_name;
        }
      })

      ->addColumn('warehouse_out_name', function ($row) {
        if ($row->in_out == 'in'||$row->in_out == 'in_transfer' || $row->in_out == 'order') {
          return '';
        } else {
          $get_warehouse = DB::table('db_warehouse')
          ->where('id', $row->warehouse_out_id_fk)
          ->first();

          return $get_warehouse->warehouse_name;
        }
      })

      ->addColumn('product_name', function ($row) {
        return $row->product_name_p;
      })

      ->addColumn('product_unit_name', function ($row) {
        return $row->product_unit_name_p;
      })

      ->addColumn('stock_type', function ($row) {
        if ($row->in_out == 'in') {
          $html = '<span class="badge badge-rounded outline-badge-success">รับเข้าสินค้า</span>';
        } elseif ($row->in_out == 'transfer') {
          $html = '<span class="badge badge-rounded outline-badge-danger">โอนย้ายระหว่างสาขา (ฝั่งโอน)</span>';
        } elseif ($row->in_out == 'in_transfer') {
          $html = '<span class="badge badge-rounded outline-badge-success">โอนย้ายระหว่างสาขา (ฝั่งรับโอน)</span>';
        } elseif ($row->in_out == 'order') {
            $html = '<span class="badge badge-rounded outline-badge-danger">สั่งซื้อสินค้า </span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('amt', function ($row) {
        return number_format($row->amt);
      })

      ->addColumn('lot_balance', function ($row) {
        return $row->lot_balance;
      })

      ->addColumn('create_name', function ($row) {
        return $row->create_name;
      })

      ->addColumn('approve_name', function ($row) {
        return $row->approve_name;
      })

      ->addColumn('approve_date', function ($row) {

        if ($row->approve_date) {
          return date('Y/m/d', strtotime($row->approve_date));
        } else {
          return '';
        }
      })

      // ->addColumn('lot_expired_date', function ($row) {


      //   if ($row->lot_expired_date) {
      //     return date('Y/m/d', strtotime($row->lot_expired_date));
      //   } else {
      //     return '';
      //   }
      // })


      // ->addColumn('action', function ($row) {

      //   $url = route('admin/Stock_card', ['lot' => $row->id]);
      //   $html = '<a href="' . $url . '" class="badge badge-rounded outline-badge-info">STOCK CARD</a>';

      //   return $html;
      // })


      ->rawColumns(['stock_type', 'action'])

      ->make(true);
  }
}
