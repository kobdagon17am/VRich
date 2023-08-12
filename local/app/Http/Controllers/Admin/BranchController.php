<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
  public function index()
  {
    // dd('111');

    $get_branch = DB::table('branch')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->get();
    return view('backend/branch', compact('get_branch'));
  }
  public function insert(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'branch_code' => $rs->branch_code,
      'branch_name' => $rs->branch_name,
      'branch_en_name' => $rs->branch_en_name,
      'province' => $rs->province,
      'phone' => $rs->phone,
      'status' => $rs->branch_status,
    ];

    try {
      DB::BeginTransaction();
      $get_branch = DB::table('branch')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/Branch')->withSuccess('เพิ่มสาขาบริษัทสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Branch')->withError('เพิ่มสาขาบริษัทไม่สำเร็จ');

    }

    // dd('success');

  }
  public function edit_branch(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'branch_code' => $rs->branch_code,
      'branch_name' => $rs->branch_name,
      'branch_en_name' => $rs->branch_en_name,
      'province' => $rs->province,
      'phone' => $rs->phone,
      'status' => $rs->branch_status,
    ];

    try {
      DB::BeginTransaction();
      $get_branch = DB::table('branch')
      ->where('id','=',$rs->id)
        ->update($dataPrepare);
      DB::commit();
      return redirect('admin/Branch')->withSuccess('แก้ไขสาขาบริษัทสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Branch')->withError('แก้ไขสาขาบริษัทไม่สำเร็จ');

    }



  }

  public function view_branch(Request $rs)
  {
     $branch = DB::table('branch')
     ->where('id','=',$rs->id)
     ->first();

     $data = ['status' => 'success', 'data' => $branch];


     return $data;

  }
}
