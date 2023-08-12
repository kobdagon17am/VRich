<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDataController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }
  public function index()
  {
    // dd('111');

    $get_admin_data = DB::table('admin')
      // ->select('admin.*', 'branch.id', 'branch.branch_name')
      // ->leftJoin('branch', 'branch.id', '=', 'admin.branch_id_fk')
      ->get();

    $get_branch = DB::table('branch')
      ->where('status', 1)
      ->get();


    // dd($get_admin_data);

    return view('backend/admin_data', compact('get_admin_data', 'get_branch'));
  }
  public function insert(Request $rs)
  {
    // dd($rs->all());

    $get_branch = DB::table('branch')
      ->where('id', '=', $rs->branch_id_fk)
      ->first();

    $dataPrepare = [
      'username' => $rs->usermame,
      'password' => $rs->password,
      'first_name' => $rs->first_name,
      'last_name' => $rs->last_name,
      'phone' => $rs->phone,
      'role' => $rs->role,
      'member_type' => $rs->member_type,
      'department' => $rs->department,
      'branch_id_fk' => $rs->branch_id_fk,
      'branch_name' => $get_branch->branch_name,
      'status' => $rs->status,
    ];

    try {
      DB::BeginTransaction();
      $get_admin_data = DB::table('admin')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/AdminData')->withSuccess('เพิ่มข้อมูลผู้ใช้งานสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/AdminData')->withError('เพิ่มข้อมูลผู้ใช้งานไม่สำเร็จ');
    }

    // dd('success');

  }
  public function edit_admin_data(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'username' => $rs->usermame,
      'password' => $rs->password,
      'first_name' => $rs->first_name,
      'last_name' => $rs->last_name,
      'phone' => $rs->phone,
      'role' => $rs->role,
      'member_type' => $rs->member_type,
      'department' => $rs->department,
      'branch_id_fk' => $rs->branch_id_fk,
      'status' => $rs->status,
    ];

    // dd($dataPrepare);

    try {
      DB::BeginTransaction();
      $get_admin_data = DB::table('admin')
        ->where('id', '=', $rs->id)
        ->update($dataPrepare);
      DB::commit();
      return redirect('admin/AdminData')->withSuccess('แก้ไขข้อมูลผู้ใช้งานสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/AdminData')->withError('แก้ไขข้อมูลผู้ใช้งานไม่สำเร็จ');
    }
  }

  public function view_admin_data(Request $rs)
  {
    $get_admin_data = DB::table('admin')
      ->where('id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $get_admin_data];


    return $data;
  }
}
