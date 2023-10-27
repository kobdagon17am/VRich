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
    $get_member_data = DB::table('customers')
      ->where('regis_doc_status', '=', 'approve')
      ->get();

    $position = DB::table('dataset_qualification')
      ->get();

    // dd($get_member_data);

    return view('backend/member_regis', compact('get_member_data','position'));
  }

  public function MemberRegister_datatable(Request $rs)
  {

    $get_member_regis_doc = DB::table('customers')

      ->where('regis_doc_status', '=', 'approve')

      ->whereRaw(("case WHEN  '{$rs->s_username}' != ''  THEN  customers.user_name = '{$rs->s_username}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_first_name}' != ''  THEN  customers.name LIKE '{$rs->s_first_name}%' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_id_card}' != ''  THEN  customers.id_card = '{$rs->s_id_card}' else 1 END"))
    //   ->whereRaw(("case WHEN  '{$rs->s_upline_id}' != ''  THEN  customers.upline_id = '{$rs->s_upline_id}' else 1 END"))
      ->whereRaw(("case WHEN  '{$rs->s_introduce_id}' != ''  THEN  customers.introduce_id = '{$rs->s_introduce_id}' else 1 END"))
      ->whereRaw(("case WHEN '{$rs->s_regis_date_doc}' != ''  THEN  date(customers.regis_date_doc) = '{$rs->s_regis_date_doc}' else 1 END"))

      // ->whereRaw(("case WHEN '{$request['s_date']}' != '' and '{$request['e_date']}' = ''  THEN  date(ewallet.created_at) = '{$request['s_date']}' else 1 END"))
      // ->whereRaw(("case WHEN '{$request['s_date']}' != '' and '{$request['e_date']}' != ''  THEN  date(ewallet.created_at) >= '{$request['s_date']}' and date(ewallet.created_at) <= '{$request['e_date']}'else 1 END"))
      // ->whereRaw(("case WHEN '{$request['s_date']}' = '' and '{$request['e_date']}' != ''  THEN  date(ewallet.created_at) = '{$request['e_date']}' else 1 END"))
      // ->whereRaw(("case WHEN  '{$rs->regis_date_doc}' != ''  THEN  customers.regis_date_doc = '{$rs->regis_date_doc}' else 1 END"))

      ->orderBy('regis_date_doc');
    // ->get();


    // dd($get_history_doc);

    $sQuery = Datatables::of($get_member_regis_doc);
    return $sQuery


      ->addColumn('username', function ($row) {
        return $row->user_name;
      })

      ->addColumn('first_name', function ($row) {
        return $row->name;
      })

      ->addColumn('last_name', function ($row) {
        return $row->last_name;
      })

      ->addColumn('id_card', function ($row) {
        return $row->id_card;
      })

    //   ->addColumn('upline_id', function ($row) {
    //     return $row->upline_id;
    //   })

    //   ->addColumn('line_type', function ($row) {
    //     return $row->line_type;
    //   })

      ->addColumn('introduce_id', function ($row) {
        return $row->introduce_id;
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

      ->addColumn('customer_status', function ($row) {
        if ($row->status_customer == 'normal') {
          $html = '<span class="badge badge-pill badge-success light">ใช้งาน</span>';
        } elseif ($row->status_customer == 'cancel') {
          $html = '<span class="badge badge-pill badge-danger light">ยกเลิกรหัส</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('action', function ($row) {

        // $html = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
        //       <i class="las la-sign-in-alt font-25 text-success"></i></a>';
        // $html1 = "<a href='" . route('admin/EditProfile') . "' onclick='edit(" . $row->id . ")' class='p-2'>
        //       <i class='las la-user-edit font-25 text-info'></i></a>";
        $html = '';
        $html1 ='';
        // $html2 = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
        //       <i class="lab la-whmcs font-25 text-warning"></i></a>';
        $html2 = '<i class="lab la-whmcs font-25 text-warning" id="btnGroupDrop1" data-toggle="dropdown"></i>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" >
              <a class="dropdown-item" href="#!" onclick="edit_position(' . $row->id . ')" class="p-2">ปรับตำแหน่ง</a>
                <a class="dropdown-item" href="#!" onclick="edit(' . $row->id . ')" class="p-2">แก้ไขรหัสผ่าน</a>
                <a class="dropdown-item" href="#!" onclick="cancel_member(' . $row->id . ')" class="p-2">ยกเลิกรหัส</a>
              </div>';

        return $html . $html1 . $html2; // รวมค่า $html และ $html1 ด้วยเครื่องหมาย .

      })


      ->rawColumns(['customer_status', 'action'])

      ->make(true);
  }

  public function edit_password(Request $rs)
  {
    // dd($rs->all());

    if ($rs->password_new == $rs->password_new_confirm) {

      // dd($rs->password_new,$rs->password_new_confirm);

      $dataPrepare = [
        'password' => md5($rs->password_new),
      ];

      $get_customer = DB::table('customers')
      ->where('id', '=', $rs->id)
      ->update($dataPrepare);

    DB::commit();
    return redirect('admin/MemberRegister')->withSuccess('แก้ไขรหัสผ่านสำเร็จ');
    } else {
      return redirect('admin/MemberRegister')->withError('แก้ไขรหัสไม่สำเร็จ');
    }
  }

  public function view_member_data(Request $rs)
  {

    $get_customer = DB::table('customers')
      ->where('id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $get_customer];


    return $data;
  }

  public function cancel_member(Request $rs)
  {
    // dd($rs->all());

    if ($rs->cencel_member == 'confirm') {
      $dataPrepare = [
        'status_customer' => 'cancel',
      ];

      $get_customer = DB::table('customers')
      ->where('id', '=', $rs->id)
      ->update($dataPrepare);

    DB::commit();
    return redirect('admin/MemberRegister')->withSuccess('ยกเลิกรหัสสำเร็จ');
    } else {
      return redirect('admin/MemberRegister')->withError('ยกเลิกรหัสไม่สำเร็จ');
    }
  }

  public function view_password(Request $rs)
  {

    $get_customer = DB::table('customers')
       ->select('customers.*','dataset_qualification.business_qualifications')
       ->leftjoin('dataset_qualification', 'customers.qualification_id', '=', 'dataset_qualification.id')
      ->where('customers.id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $get_customer];


    return $data;
  }

  public function edit_position(Request $request)
  {


    $user_action = DB::table('customers')
    ->select( 'id', 'user_name','name', 'last_name','qualification_id','introduce_id')
    ->where('id','=',$request->id_customer)
    ->first();
    if(empty($user_action)){
        return redirect('admin/MemberRegister')->withError('ไม่พบผู้ใช้งาน กรุณาทำรายการไหม่');
    }

    if($user_action->qualification_id == $request->new_position){
        return redirect('admin/MemberRegister')->withError('สมาชิกเป็น '.$request->new_position.' อยู่แล้วไม่สามารถปรับตำแหน่งได้');
    }

    try {

        DB::BeginTransaction();

        DB::table('log_up_vl')->insert([
            'user_name' => $user_action->user_name,'introduce_id' => $user_action->introduce_id,
            'old_lavel' => $user_action->qualification_id, 'new_lavel' =>$request->new_position,'pv_upgrad'=>0, 'status' => 'success', 'type' => 'jangpv','note'=>'ปรับตำแหน่งโดย Admin'
        ]);

        DB::table('customers')
        ->where('user_name', $user_action->user_name)
        ->update(['qualification_id' => $request->new_position, 'pv_upgrad' => 0]);
        DB::commit();

        return redirect('admin/MemberRegister')->withSuccess('ปรับตำแหน่งสำเร็จ');

} catch (Exception $e) {
     DB::rollback();
     return redirect('admin/MemberRegister')->withError('ผิดพลาดกรุณาทำรายการไหม่อีกครั้ง');
}



  }


}
