<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

  public function index()
  {


    // dd('111');

    $get_unit = DB::table('dataset_product_unit')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->get();
    return view('backend/unit', compact('get_unit'));
  }
  public function insert(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'product_unit_th' => $rs->unit_name,
      'product_unit_en' => $rs->unit_en_name,
      'status' => $rs->unit_status,
    ];

    try {
      DB::BeginTransaction();
      $get_unit = DB::table('dataset_product_unit')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/Unit')->withSuccess('เพิ่มหน่วยสินค้าสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Unit')->withError('เพิ่มหน่วยสินค้าไม่สำเร็จ');

    }

    // dd('success');

  }
  public function edit_unit(Request $rs)
  {

    $dataPrepare = [
      'product_unit_th' => $rs->unit_name,
      'product_unit_en' => $rs->unit_en_name,
      'status' => $rs->unit_status,
    ];

    try {
      DB::BeginTransaction();

      $get_unit = DB::table('dataset_product_unit')
      ->where('id','=',$rs->id)
        ->update($dataPrepare);

      DB::commit();
      return redirect('admin/Unit')->withSuccess('แก้ไขข้อมูลหน่วยสินค้าสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Unit')->withError('แก้ไขข้อมูลหน่วยสินค้าไม่สำเร็จ');

    }

  }


  public function view_unit(Request $rs)
  {
     $dataset_product_unit = DB::table('dataset_product_unit')
     ->where('id','=',$rs->id)
     ->first();



     $data = ['status' => 'success', 'data' => $dataset_product_unit];


     return $data;

  }
}
