<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Arr;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DataTables;

class StockOutController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }


  public function index()
  {

    // dd(Auth::guard('admin')->user()->id);
    $get_stock = DB::table('db_stocks')
      ->select('db_stocks.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stocks.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stocks.warehouse_id_fk')
      ->get();


    return view('backend/stock_out', compact('get_stock'));
  }

  public function view_modal($id)
  {



    $y = date('Y');
    $y = substr($y, -2);
    $code =  IdGenerator::generate([
      'table' => 'db_stock_out',
      'field' => 'transaction_stock',
      'length' => 15,
      'prefix' => 'TRANS' . $y . '' . date("m") . date("d"),
      'reset_on_prefix_change' => true
    ]);

    $get_branch = DB::table('branch')
      ->where('status', 1)
      ->get();

    $get_warehouse = DB::table('db_warehouse')
      ->where('status', 1)
      ->get();

    $get_product = DB::table('products')
      ->where('status', 1)
      ->get();

    $get_stock = DB::table('db_stocks')
      ->select('db_stocks.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stocks.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stocks.warehouse_id_fk')
      ->where('db_stocks.id', $id)
      ->first();

    $get_stock_lot = DB::table('db_stock_lot')
      ->select('lot_number', 'lot_expired_date', 'lot_balance')
      ->where('branch_id_fk', $get_stock->branch_id_fk)
      ->where('warehouse_id_fk', $get_stock->warehouse_id_fk)
      ->where('product_id_fk', $get_stock->product_id_fk)
      ->wherein('stock_type', ['in', 'in_transfer'])
      ->where('lot_balance', '!=', 0)
      ->where('stock_status', 'confirm')
      ->distinct()
      ->get();

    //dd($get_stock_lot);



    $get_stock_out = DB::table('db_stock_out')
    ->select('db_stock_out.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name', 'db_branch_out.branch_name as branch_name_out', 'db_warehouse_out.warehouse_name as warehouse_name_out')
    ->leftJoin('products', 'products.id', '=', 'db_stock_out.product_id_fk')
    ->leftJoin('db_warehouse', 'db_warehouse.branch_id_fk', '=', 'db_stock_out.branch_id_fk')
    ->leftJoin('branch as db_branch_out', 'db_branch_out.id', '=', 'db_stock_out.branch_out_id_fk')
    ->leftJoin('db_warehouse as db_warehouse_out', 'db_warehouse_out.id', '=', 'db_stock_out.warehouse_out_id_fk')
      ->get();


    return view('backend/stock_out_detail', compact('get_branch', 'get_warehouse', 'get_product', 'get_stock', 'get_stock_lot', 'get_stock_out', 'code'));
  }

  public function get_data_warehouse_out_select(Request $request)
  {

    $get_warehouse_out = DB::table('db_warehouse')
      ->where('branch_id_fk', $request->id)
      ->get();


    return response()->json($get_warehouse_out);
  }

  public function insert(Request $rs)
  {


    $amt_total = array_sum($rs->amt);
    if ($amt_total <= 0) {
      return redirect('admin/Stock_out_detail/' . $rs->stock_id_fk)->withError('กรุณาใส่จำนวนสินค้าที่ต้องการโอนระหวางสาขา');
    }


    $get_stock_data = DB::table('db_stock_lot')
      ->where('branch_id_fk', '=', $rs->branch_id_fk)
      ->orderBy('lot_expired_date')
      ->first();

    // dd($get_stock_data);

    if ($rs->stock_out_add == "success") {
      // Insert new stock record

      try {
        DB::beginTransaction();

        foreach ($rs->amt as $key => $value) {
          if ($value > 0 || !empty($value)) {
            $dataPrepare = [
              'branch_id_fk' => $rs->branch_id_fk,
              'warehouse_id_fk' => $rs->warehouse_id_fk,
              'product_id_fk' => $rs->product_id_fk,
              'lot_number' => $rs->lot_number[$key],
              'product_unit_id_fk' => $get_stock_data->product_unit_id_fk,
              'date_in_stock' => $get_stock_data->date_in_stock,
              'stock_remark' => $get_stock_data->stock_remark,
              'lot_expired_date' => $get_stock_data->lot_expired_date,
              'create_id_fk' => Auth::guard('admin')->user()->id,
              'create_name' => Auth::guard('admin')->user()->first_name,

              'branch_out_id_fk' => $rs->branch_out_id_fk,
              'warehouse_out_id_fk' => $rs->warehouse_out_id_fk,
              'amt' => $value,
              'transaction_stock' => $rs->transaction_stock,
              'stock_type' => $rs->stock_type,

            ];
            // dd($dataPrepare);

            $get_stock_lot_out = DB::table('db_stock_lot')
              ->insertGetId($dataPrepare);
          }
          //dd($key,$value);

        }

        $total_amt_out_arr = array();
        $total_amt_out_arr = array_sum($rs->amt);

        // dd($total_amt_out_arr);

        $stock_out = [
          'branch_id_fk' => $rs->branch_id_fk,
          'warehouse_id_fk' => $rs->warehouse_id_fk,
          'product_id_fk' => $rs->product_id_fk,
          'product_unit_id_fk' => $get_stock_data->product_unit_id_fk,
          'branch_out_id_fk' => $rs->branch_out_id_fk,
          'warehouse_out_id_fk' => $rs->warehouse_out_id_fk,
          'total_amt_out' => $total_amt_out_arr,
          'stock_out_remark' => $rs->stock_out_remark,
          'create_id_fk' => Auth::guard('admin')->user()->id,
          'create_name' => Auth::guard('admin')->user()->first_name,
          'transaction_stock' => $rs->transaction_stock,

        ];
        // dd($stock_out);

        $get_stock_out = DB::table('db_stock_out')
          ->insertGetId($stock_out);


        DB::commit();
        return redirect('admin/Stock_out_detail/' . $rs->stock_id_fk)->withSuccess('โอนย้ายสินค้าสำเร็จ');
      } catch (Exception $e) {
        DB::rollback();
        return redirect('admin/Stock_out_detail/' . $rs->stock_id_fk)->withError('โอนย้ายสินค้าไม่สำเร็จ');
      }
    }
  }

  public function update_stock_out(Request $rs)
  {
    //  dd($rs->all());
    // อัปเดตเมื่อ stock_status เป็น "confirm"
    if ($rs->stock_status == "confirm") {

      // update DB stock out
      $updateData = [
        'stock_status' => 'confirm',
        'approve_id_fk' => Auth::guard('admin')->user()->id,
        'approve_name' => Auth::guard('admin')->user()->first_name,
        'approve_date' => now(),
      ];

      DB::table('db_stock_out')
        ->where('id', $rs->id)
        ->update($updateData);


      // update DB stock lot
      $get_stock_out = DB::table('db_stock_out')
        ->where('id', $rs->id)
        ->first();



      // dd($get_stock_out);

      $updateStockLot = [
        'stock_status' => 'confirm',
        'approve_id_fk' => Auth::guard('admin')->user()->id,
        'approve_name' => Auth::guard('admin')->user()->first_name,
        'approve_date' => now(),
      ];

      DB::table('db_stock_lot')
        ->where('transaction_stock', $get_stock_out->transaction_stock)
        ->update($updateStockLot);


      // update stock movement
      $get_stock_data = DB::table('db_stock_lot')
        ->where('transaction_stock', $get_stock_out->transaction_stock)
        ->orderByDesc('id')
        ->first();

      // dd($get_stock_data);

      //amt balance
      $query = DB::table('db_stock_movement')
        ->where('branch_id_fk', $get_stock_data->branch_id_fk)
        ->where('warehouse_id_fk', $get_stock_data->warehouse_id_fk)
        ->where('product_id_fk', $get_stock_data->product_id_fk)
        ->orderByDesc('id')
        ->first();

      // dd($query);

      if ($query === null) {
        // กรณี $query เป็น null
        $amt_balance = $get_stock_data->amt;
      } else {
        // กรณี $query ไม่เป็น null
        $amt_balance = $query->amt_balance - $get_stock_data->amt;
      }

      //lot_balance
      $query1 = DB::table('db_stock_movement')
        ->where('branch_id_fk', $get_stock_data->branch_id_fk)
        ->where('product_id_fk', $get_stock_data->product_id_fk)
        ->where('warehouse_id_fk', $get_stock_data->warehouse_id_fk)
        ->where('lot_number', $get_stock_data->lot_number)
        ->orderByDesc('id')
        ->first();

      if ($query1 === null) {
        // กรณี $query เป็น null
        // dd('1');
        $lot_balance = $get_stock_data->amt;
      } else {
        // กรณี $query ไม่เป็น null

        $lot_balance = $query1->amt_balance - $get_stock_data->amt;
        // dd($query1->amt, $get_stock_data->amt);
      }

      $updateMovement = [
        'branch_id_fk' => $get_stock_data->branch_id_fk,
        'warehouse_id_fk' => $get_stock_data->warehouse_id_fk,
        'branch_out_id_fk' => $get_stock_data->branch_out_id_fk,
        'warehouse_out_id_fk' => $get_stock_data->warehouse_out_id_fk,
        'product_id_fk' => $get_stock_data->product_id_fk,
        'stock_lot_id_fk' => $get_stock_data->id,
        'lot_number' => $get_stock_data->lot_number,
        'lot_balance' => $lot_balance,
        'amt_balance' => $amt_balance,
        'amt' => $get_stock_data->amt,
        'in_out' => 'transfer',
        'product_unit_id_fk' => $get_stock_data->product_unit_id_fk,
        'stock_status' => $get_stock_data->stock_status,
        'create_id_fk' => Auth::guard('admin')->user()->id,
        'create_name' => Auth::guard('admin')->user()->first_name,
        'approve_id_fk' => Auth::guard('admin')->user()->id,
        'approve_name' => Auth::guard('admin')->user()->first_name,
        'approve_date' => $get_stock_data->approve_date,
      ];

      // dd($updateMovement);

      DB::table('db_stock_movement')
        ->insert($updateMovement);

      // update lot balance in db_stock_lot
      $xxx = DB::table('db_stock_lot')
        ->where('branch_id_fk', $get_stock_data->branch_id_fk)
        ->where('warehouse_id_fk', $get_stock_data->warehouse_id_fk)
        ->where('product_id_fk', $get_stock_data->product_id_fk)
        ->where('lot_number', $get_stock_data->lot_number)

        // dd($lot_balance);
        ->update(['lot_balance' => $lot_balance]);


      // update stock balance
      $get_stock_lot_data = DB::table('db_stock_lot')
        ->where('transaction_stock', '=', $get_stock_out->transaction_stock)
        ->orderByDesc('id')
        ->first();

      $db_get_stock_balance = DB::table('db_stocks')
        ->where('branch_id_fk', $get_stock_lot_data->branch_id_fk)
        ->where('warehouse_id_fk', $get_stock_lot_data->warehouse_id_fk)
        ->where('product_id_fk', $get_stock_lot_data->product_id_fk)
        ->where('product_unit_id_fk', $get_stock_lot_data->product_unit_id_fk)
        ->orderByDesc('id')
        ->first();
      // dd($db_get_stock_balance);

      if (empty($db_get_stock_balance)) {
        // กรณี $get_stock_balance เป็น null
        $get_stock_balance = $get_stock_lot_data->amt;

        $updateStock = [
          // 'stock_id_fk' => $get_stock_lot_data->id,
          'branch_id_fk' => $get_stock_lot_data->branch_id_fk,
          'warehouse_id_fk' => $get_stock_lot_data->warehouse_id_fk,
          'product_id_fk' => $get_stock_lot_data->product_id_fk,
          'product_unit_id_fk' => $get_stock_lot_data->product_unit_id_fk,
          'stock_balance' => $get_stock_balance,
        ];
        DB::table('db_stocks')
          ->insert($updateStock);
      } else {
        // กรณี $get_stock_balance ไม่เป็น null
        $get_stock_balance = $db_get_stock_balance->stock_balance - $get_stock_lot_data->amt;

        $updateStock = [
          // 'stock_id_fk' => $get_stock_lot_data->id,
          'branch_id_fk' => $get_stock_lot_data->branch_id_fk,
          'warehouse_id_fk' => $get_stock_lot_data->warehouse_id_fk,
          'product_id_fk' => $get_stock_lot_data->product_id_fk,
          'product_unit_id_fk' => $get_stock_lot_data->product_unit_id_fk,
          'stock_balance' => $get_stock_balance,
        ];


        DB::table('db_stocks')
          ->where('id', "=", $db_get_stock_balance->id)

          ->update($updateStock);
      }

      //add row stock in db_stock lot
      $dataNewRow_in = [
        'branch_id_fk' => $get_stock_data->branch_out_id_fk,
        'warehouse_id_fk' => $get_stock_data->warehouse_out_id_fk,
        'product_id_fk' => $get_stock_data->product_id_fk,
        'transaction_stock' => $get_stock_data->transaction_stock,
        'lot_number' => $get_stock_data->lot_number,
        'amt' => $get_stock_data->amt,
        'product_unit_id_fk' => $get_stock_data->product_unit_id_fk,
        'date_in_stock' => $get_stock_data->date_in_stock,
        'stock_remark' => $get_stock_data->stock_remark,
        'lot_expired_date' => $get_stock_data->lot_expired_date,
        'create_id_fk' => Auth::guard('admin')->user()->id,
        'create_name' => Auth::guard('admin')->user()->first_name,
        'stock_type' => 'in_transfer',
      ];

      DB::table('db_stock_lot')
        ->insert($dataNewRow_in);

      return redirect('admin/Stock_out_detail/' . $rs->stock_id_fk)->withSuccess('โอนย้ายสินค้าสำเร็จ');
    } elseif ($rs->stock_status == "cancel") {
      // อัปเดตเมื่อ stock_status เป็น "cancel"
      $updateData = [
        'stock_status' => 'cancel'
      ];

      DB::table('db_stock_lot')
        ->where('id', $rs->id) // แนะนำให้ใช้ id หรือ primary key เพื่ออัปเดตแถวที่ต้องการ
        ->update($updateData);
      return redirect('admin/Stock_out_detail/' . $rs->stock_id_fk)->withError('โอนย้ายสินค้าไม่สำเร็จ');
    }
  }

  public function view_stock_out(Request $rs)
  {
    // dd($rs->all());

    $get_stock_out = DB::table('db_stock_out')
      ->select('db_stock_out.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name', 'db_branch_out.branch_name as branch_name_out', 'db_warehouse_out.warehouse_name as warehouse_name_out')
      ->leftJoin('products', 'products.id', '=', 'db_stock_out.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.branch_id_fk', '=', 'db_stock_out.branch_id_fk')
      ->leftJoin('branch as db_branch_out', 'db_branch_out.id', '=', 'db_stock_out.branch_out_id_fk')
      ->leftJoin('db_warehouse as db_warehouse_out', 'db_warehouse_out.id', '=', 'db_stock_out.warehouse_out_id_fk')
      ->where('db_stock_out.id', '=', $rs->id)
      ->first();


    // dd($get_stock_out);

    $data = ['status' => 'success', 'data' => $get_stock_out];

    return $data;

    // dd($data);
  }

  public function Stock_out_confirm_datatable(Request $rs)
  {



    $get_stock_out = DB::table('db_stock_out')
      ->select('db_stock_out.*', 'products.product_name', 'products.product_unit_name', 'db_warehouse.branch_name', 'db_warehouse.warehouse_name')
      ->leftJoin('products', 'products.id', '=', 'db_stock_out.product_id_fk')
      ->leftJoin('db_warehouse', 'db_warehouse.id', '=', 'db_stock_out.warehouse_id_fk')
      ->where('db_stock_out.stock_status', '=', 'confirm')

      ->whereRaw(("case WHEN  '{$rs->s_branch_id_fk}' != ''  THEN  db_stock_out.branch_id_fk = '{$rs->s_branch_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_warehouse_id_fk}' != ''  THEN  db_stock_out.warehouse_id_fk = '{$rs->s_warehouse_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->out_branch_id_fk}' != ''  THEN  db_stock_out.branch_out_id_fk = '{$rs->out_branch_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->out_warehouse_id_fk}' != ''  THEN  db_stock_out.warehouse_out_id_fk = '{$rs->out_warehouse_id_fk}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_product_name}' != ''  THEN  db_stock_out.product_id_fk = '{$rs->s_product_name}' else 1 END"));


    // ->whereRaw(("case WHEN  '{$rs->position}' != ''  THEN  customers.qualification_id = '{$rs->position}' else 1 END"))
    // ->whereRaw(("case WHEN  '{$rs->id_card}' != ''  THEN  customers.id_card = '{$rs->id_card}' else 1 END"))


    //$query->orderBy($request->input('order.0.column'), $request->input('order.0.dir'))

    $sQuery = Datatables::of($get_stock_out);
    return $sQuery


      ->addColumn('branch_name', function ($row) {
        return $row->branch_name;
      })

      ->addColumn('warehouse_name', function ($row) {
        return $row->warehouse_name;
      })

      ->addColumn('branch_out_name', function ($row) {
        $get_branch = DB::table('branch')
          ->where('id', $row->branch_out_id_fk)
          ->first();
        return $get_branch->branch_name;
      })

      ->addColumn('warehouse_out_name', function ($row) {
        $get_warehouse = DB::table('db_warehouse')
          ->where('id', $row->warehouse_out_id_fk)
          ->first();
        return $get_warehouse->warehouse_name;
      })

      ->addColumn('product_name', function ($row) {
        return $row->product_name;
      })


      ->addColumn('total_amt_out', function ($row) {
        return $row->total_amt_out;
      })

      ->addColumn('product_unit_name', function ($row) {
        return $row->product_unit_name;
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

      ->addColumn('stock_status', function ($row) {

        if ($row->stock_status == 'pending') {
          $html = '<span class="badge badge-pill badge-warning light">รออนุมัติ</span>';
        } elseif ($row->stock_status == 'confirm') {
          $html = '<span class="badge badge-pill badge-success light">สำเร็จ</span>';
        } elseif ($row->stock_status == 'cancel') {
          $html = '<span class="badge badge-pill badge-danger light">ยกเลิก</span>';
        } else {
          $html = '';
        }

        return  $html;
      })
      ->addColumn('stock_remark', function ($row) {
        return $row->stock_out_remark;
      })
      ->addColumn('action', function ($row) {

        $html = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
              <i class="lab la-whmcs font-25 text-warning"></i></a>';
        return $html;
      })


      ->rawColumns(['stock_status', 'action'])

      ->make(true);
  }
}
