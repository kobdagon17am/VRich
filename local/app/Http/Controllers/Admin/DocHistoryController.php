<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Arr;
use DataTables;

class DocHistoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }


  public function index()
  {


    return view('backend/history_doc');
  }

  public function History_Doc_datatable(Request $rs)
  {

    $get_history_doc = DB::table('customers')

      ->where('regis_doc_status', '=', 'approve')
      ->orderBy('regis_date_doc');
    // ->get();


    // dd($get_history_doc);

    $sQuery = Datatables::of($get_history_doc);
    return $sQuery


      ->addColumn('username', function ($row) {
        return $row->username;
      })

      ->addColumn('first_name', function ($row) {
        return $row->first_name;
      })

      ->addColumn('last_name', function ($row) {
        return $row->last_name;
      })

      ->addColumn('upline_id', function ($row) {
        return $row->upline_id;
      })


      ->addColumn('regis_doc1_status', function ($row) {
        if ($row->regis_doc1_status == '0') {
          $html = '<span class="badge badge-rounded outline-badge-dark">ยังไม่ส่งเอกสาร</span>';
        } elseif ($row->regis_doc1_status == '1') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',1)"> <span class="badge badge-rounded outline-badge-warning">รอตรวจสอบ</span>';
        } elseif ($row->regis_doc1_status == '2') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',1)"> <span class="badge badge-rounded badge-success">อนุมัติ</span>';
        } elseif ($row->regis_doc1_status == '3') {
          $html = '<span class="badge badge-rounded badge-danger">ไม่อนุมัติ</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('regis_doc2_status', function ($row) {
        if ($row->regis_doc2_status == '0') {
          $html = '<span class="badge badge-rounded outline-badge-dark">ยังไม่ส่งเอกสาร</span>';
        } elseif ($row->regis_doc2_status == '1') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',2)"> <span class="badge badge-rounded outline-badge-warning">รอตรวจสอบ</span>';
        } elseif ($row->regis_doc2_status == '2') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',2)"> <span class="badge badge-rounded badge-success">อนุมัติ</span>';
        } elseif ($row->regis_doc2_status == '3') {
          $html = '<span class="badge badge-rounded badge-danger">ไม่อนุมัติ</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('regis_doc3_status', function ($row) {
        if ($row->regis_doc3_status == '0') {
          $html = '<span class="badge badge-rounded outline-badge-dark">ยังไม่ส่งเอกสาร</span>';
        } elseif ($row->regis_doc3_status == '1') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',3)"> <span class="badge badge-rounded outline-badge-warning">รอตรวจสอบ</span>';
        } elseif ($row->regis_doc3_status == '2') {
          $html = '<a href="#!" onclick="edit(' . $row->id . ',3)"> <span class="badge badge-rounded badge-success">อนุมัติ</span>';
        } elseif ($row->regis_doc3_status == '3') {
          $html = '<span class="badge badge-rounded badge-danger">ไม่อนุมัติ</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('regis_doc4_status', function ($row) {
        if ($row->regis_doc4_status == '0') {
          $html = '<span class="badge badge-rounded outline-badge-dark">ยังไม่ส่งเอกสาร</span>';
        } elseif ($row->regis_doc4_status == '1') {
          $html = '<a href="#!" onclick="edit1(' . $row->id . ',4)"> <span class="badge badge-rounded outline-badge-warning">รอตรวจสอบ</span>';
        } elseif ($row->regis_doc4_status == '2') {
          $html = '<a href="#!" onclick="edit1(' . $row->id . ',4)"> <span class="badge badge-rounded badge-success">อนุมัติ</span>';
        } elseif ($row->regis_doc4_status == '3') {
          $html = '<span class="badge badge-rounded badge-danger">ไม่อนุมัติ</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('regis_doc_status', function ($row) {
        $html = '<span class="badge badge-rounded badge-success">ผ่านการอนุมัติ</span>';

        return  $html;
      })

      ->addColumn('regis_date_doc', function ($row) {
        if ($row->regis_date_doc) {
          return date('Y/m/d', strtotime($row->regis_date_doc));
        } else {
          return '';
        }
      })


      ->rawColumns(['regis_doc1_status', 'regis_doc2_status', 'regis_doc3_status', 'regis_doc4_status', 'regis_doc_status'])
      ->make(true);
  }

  public function History_Doc_view(Request $rs)
  {
    // dd($rs->all());

    $get_member_doc = DB::table('register_files')
      ->select('register_files.*', 'customers.first_name', 'customers.last_name', 'customers.id_card',)
      ->leftJoin('customers', 'customers.id', '=', 'register_files.customer_id')
      ->where('register_files.customer_id', '=', $rs->id)
      ->where('register_files.type', '=', $rs->type)
      ->first();

    // dd($get_member_doc);

    $data = ['status' => 'success', 'data' => $get_member_doc];

    return $data;
  }

  public function History_Acc_view(Request $rs)
  {
    // dd($rs->all());

    $get_member_doc = DB::table('register_files')
      ->select('register_files.*', 'customers_bank.username', 'customers_bank.account_name', 'customers_bank.account_no','customers_bank.bank_name','customers_bank.bank_branch','customers_bank.bank_type')
      ->leftJoin('customers_bank', 'customers_bank.customer_id', '=', 'register_files.customer_id')
      ->where('register_files.customer_id', '=', $rs->id)
      ->where('register_files.type', '=', $rs->type)
      ->first();

    // dd($get_member_doc);

    $data = ['status' => 'success', 'data' => $get_member_doc];

    return $data;
  }

  public function History_Acc_update(Request $rs)
  {
// dd($rs->all());
    if ($rs->regis_doc_status == "2") {
      // อัปเดตเมื่อ regis_doc_status เป็น "อนุมัติ"
      $updateData = [
        'regis_doc_status' => '2',
        'remark' => $rs->remark1,
        'approve_id_fk' => Auth::guard('admin')->user()->id,
        'approve_name' => Auth::guard('admin')->user()->first_name,
        'approve_date' => now(),
      ];

      // dd($updateData);
      DB::table('register_files')
        ->where('id', $rs->id1)
        ->update($updateData);

      // update db customers
      $get_db_register_file = DB::table('register_files')
        ->where('id', '=', $rs->id1)
        ->first();

        // dd($get_db_register_file);

      if ($get_db_register_file->type == '1') {
        // กรณี type เป็น 1
        $regis_doc1_status = $get_db_register_file->regis_doc_status;
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc1_status' => $regis_doc1_status]);
      } elseif ($get_db_register_file->type == '2') {
        // กรณี type เป็น 2
        $regis_doc2_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc2_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc2_status' => $regis_doc2_status]);
      } elseif ($get_db_register_file->type == '3') {
        // กรณี type เป็น 3
        $regis_doc3_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc3_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc3_status' => $regis_doc3_status]);
      } elseif ($get_db_register_file->type == '4') {
        // กรณี type เป็น 4
        $regis_doc4_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc4_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc4_status' => $regis_doc4_status]);
      }


      return redirect('admin/HistoryDocument')->withSuccess('อนุมัติเอกสาร');
    } elseif ($rs->regis_doc_status == "3") {
      // อัปเดตเมื่อ regis_doc_status เป็น "ไม่อนุมัติ"
      $updateData = [
        'regis_doc_status' => '3',
        'remark' => $rs->remark1,
        'approve_id_fk' => Auth::guard('admin')->user()->id,
        'approve_name' => Auth::guard('admin')->user()->first_name,
        'approve_date' => now(),
      ];

      DB::table('register_files')
        ->where('id', $rs->id1) // แนะนำให้ใช้ id หรือ primary key เพื่ออัปเดตแถวที่ต้องการ
        ->update($updateData);

      // update db customers
      $get_db_register_file = DB::table('register_files')
        ->where('id', '=', $rs->id1)
        ->first();

      // dd($update_db_customer);

      if ($get_db_register_file->type == '1') {
        // กรณี type เป็น 1
        $regis_doc1_status = $get_db_register_file->regis_doc_status;
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc1_status' => $regis_doc1_status]);
      } elseif ($get_db_register_file->type == '2') {
        // กรณี type เป็น 2
        $regis_doc2_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc2_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc2_status' => $regis_doc2_status]);
      } elseif ($get_db_register_file->type == '3') {
        // กรณี type เป็น 3
        $regis_doc3_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc3_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc3_status' => $regis_doc3_status]);
      } elseif ($get_db_register_file->type == '4') {
        // กรณี type เป็น 4
        $regis_doc4_status = $get_db_register_file->regis_doc_status;
        // dd($regis_doc4_status);
        DB::table('customers')
          ->where('id', $get_db_register_file->customer_id)
          ->update(['regis_doc4_status' => $regis_doc4_status]);
      }
      return redirect('admin/HistoryDocument')->withError('ไม่อนุมัติเอกสาร');
    }
  }
}
