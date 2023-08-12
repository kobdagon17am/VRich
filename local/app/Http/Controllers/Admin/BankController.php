<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }
  public function index()
  {
    // dd('111');

    $get_bank = DB::table('dataset_bank')
      ->get();

    //  dd($get_bank);

    return view('backend/bank', compact('get_bank'));
  }
  public function insert(Request $rs)
  {
    // dd($rs->all());
    $dataPrepare = [
      'bank_name' => $rs->bank_name,
      'bank_en_name' => $rs->bank_en_name,
      'bank_short_name' => $rs->bank_short_name,
      'bank_code' => $rs->bank_code,
      'transfer_fee' => $rs->transfer_fee,
      'status' => $rs->status,
    ];

    try {
      DB::BeginTransaction();
      $get_bank = DB::table('dataset_bank')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/Bank')->withSuccess('เพิ่มบัญชีธนาคารงานสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Bank')->withError('เพิ่มบัญชีธนาคารงานไม่สำเร็จ');
    }

    // dd('success');

  }
  public function edit_bank(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'bank_name' => $rs->bank_name,
      'bank_en_name' => $rs->bank_en_name,
      'bank_short_name' => $rs->bank_short_name,
      'bank_code' => $rs->bank_code,
      'transfer_fee' => $rs->transfer_fee,
      'status' => $rs->status,
    ];

    // dd($dataPrepare);

    try {
      DB::BeginTransaction();
      $get_bank = DB::table('dataset_bank')
        ->where('id', '=', $rs->id)
        ->update($dataPrepare);
      DB::commit();
      return redirect('admin/Bank')->withSuccess('แก้ไขบัญชีธนาคารงานสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Bank')->withError('แก้ไขบัญชีธนาคารงานไม่สำเร็จ');
    }
  }

  public function view_bank(Request $rs)
  {
    $get_bank = DB::table('dataset_bank')
      ->where('id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $get_bank];


    return $data;
  }
}
