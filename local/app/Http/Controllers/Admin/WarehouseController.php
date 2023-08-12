<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }
  public function index()
  {

    // dd('111');
    $get_warehouse = DB::table('db_warehouse')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->get();

    $get_branch = DB::table('branch')
      ->where('status', 1)
      ->get();

    // dd($get_branch);

    return view('backend/warehouse', compact('get_warehouse', 'get_branch'));
  }


  public function insert(Request $rs)
  {
    // dd($rs->all());

    $get_branch = DB::table('branch')
      ->where('id', '=', $rs->branch_name)
      ->first();


    $dataPrepare = [
      'branch_id_fk' => $rs->branch_name,
      'branch_code' => $get_branch->branch_code,
      'branch_name' => $get_branch->branch_name,
      'warehouse_code' => $rs->warehouse_code,
      'warehouse_name' => $rs->warehouse_name,
      'warehouse_details' => $rs->warehouse_details,
      'status' => $rs->warehouse_status,
    ];

    try {
      DB::BeginTransaction();
      $get_branch = DB::table('db_warehouse')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/Warehouse')->withSuccess('เพิ่มคลังสินค้าสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Warehouse')->withError('เพิ่มคลังสินค้าไม่สำเร็จ');
    }
  }

  public function edit_warehouse(Request $rs)
  {
    // dd($rs->all());

    $get_branch = DB::table('branch')
      ->where('id', '=', $rs->branch_name)
      ->first();

    $dataPrepare = [
      'branch_id_fk' => $get_branch->id,
      'branch_code' => $get_branch->branch_code,
      'branch_name' => $get_branch->branch_name,
      'warehouse_code' => $rs->warehouse_code,
      'warehouse_name' => $rs->warehouse_name,
      'warehouse_details' => $rs->warehouse_details,
      'status' => $rs->warehouse_status,
    ];


    try {
      DB::BeginTransaction();
      $get_warehouse = DB::table('db_warehouse')
        ->where('id', '=', $rs->id)
        ->update($dataPrepare);
      DB::commit();
      return redirect('admin/Warehouse')->withSuccess('แก้ไขข้อมูลสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Warehouse')->withError('แก้ไขข้อมูลไม่สำเร็จ');
    }
  }

  public function view_warehouse(Request $rs)
  {

    $warehouse = DB::table('db_warehouse')
      ->where('id', '=', $rs->id)
      ->first();


    $data = ['status' => 'success', 'data' => $warehouse];


    return $data;
  }
}
