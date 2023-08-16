<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Arr;
use DataTables;

class MemberRigisterController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }


  public function index()
  {


    return view('backend/member_regis');
  }

  public function MemberRegister_datatable(Request $rs)
  {

    $get_member_regis_doc = DB::table('customers')

      ->where('regis_doc_status', '=', 'approve')
      ->orderBy('regis_date_doc');
    // ->get();


    // dd($get_history_doc);

    $sQuery = Datatables::of($get_member_regis_doc);
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

      ->addColumn('pv_all', function ($row) {
        return $row->pv_all;
      })

      ->addColumn('regis_date_doc', function ($row) {
        if ($row->regis_date_doc) {
          return date('Y/m/d', strtotime($row->regis_date_doc));
        } else {
          return '';
        }
      })

      ->addColumn('regis_doc_status', function ($row) {
        if ($row->regis_doc_status == 'approve') {
          $html = '<span class="badge badge-pill outline-badge-success light">ใช้งาน</span>';
        } elseif ($row->stock_status == 'cancel') {
          $html = '<span class="badge badge-pill outline-badge-danger light">ไม่ใช้งาน</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('action', function ($row) {

        $html = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
              <i class="las la-sign-in-alt font-25 text-success"></i></a>';
        $html1 = "<a href='" . route('admin/EditProfile') . "' onclick='edit(" . $row->id . ")' class='p-2'>
              <i class='las la-user-edit font-25 text-info'></i></a>";
        // $html2 = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
        //       <i class="lab la-whmcs font-25 text-warning"></i></a>';
        $html2 = '<i class="lab la-whmcs font-25 text-warning" id="btnGroupDrop1"  data-toggle="dropdown"></i>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="#">เปลี่ยนรหัส</a>
                <a class="dropdown-item" href="#">ยกเลิกรหัส</a>
              </div>';

        return $html . $html1 . $html2; // รวมค่า $html และ $html1 ด้วยเครื่องหมาย .

      })


      ->rawColumns(['regis_doc_status', 'action'])

      ->make(true);
  }
}
