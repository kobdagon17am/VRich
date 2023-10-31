<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class learningController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }

  public function index()
  {
    // dd('111');

    $get_learning = DB::table('learning')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->orderByDesc('id')
      ->get();

    return view('backend/learning', compact('get_learning'));
  }

  public function insert(Request $rs)
  {

    $dataPrepare = [
      'learning_title' => $rs->learning_title,
      'learning_name' => $rs->learning_name,
      'learning_detail' => $rs->learning_detail,
      'vdeo_url_1' => $rs->vdeo_url_1,
      'vdeo_url_2' => $rs->vdeo_url_2,
      'vdeo_url_3' => $rs->vdeo_url_3,
      'learning_status' => $rs->learning_status,
    ];

    // dd($dataPrepare);

    try {
      DB::BeginTransaction();
      $get_learning = DB::table('learning')
        ->insertGetId($dataPrepare);


        if (isset($rs->learning_image1)) {
          $file_1 = $rs->learning_image1;
          $url = 'local/public/learning/';

          $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
          if ($file_1->move($url, $f_name)) {
            $dataPrepare = [
              'learning_id_fk' => $get_learning,
              'learning_image_url' => $url,
              'learning_image_name' => $f_name,
              'learning_image_orderby' => '1',

            ];
            DB::table('learning_images')
              ->insert($dataPrepare);
          }
        }



      DB::commit();
      return redirect('admin/Learning')->withSuccess('เพิ่มสื่อการเรียนรู้สำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Learning')->withError('เพิ่มสื่อการเรียนรู้ไม่สำเร็จ');
    }

    // dd('success');

  }

  public function edit_learning(Request $rs)
  {

    $dataPrepare = [
      'learning_title' => $rs->learning_title,
      'learning_name' => $rs->learning_name,
      'learning_detail' => $rs->learning_detail,
      'vdeo_url_1' => $rs->vdeo_url_1,
      'vdeo_url_2' => $rs->vdeo_url_2,
      'vdeo_url_3' => $rs->vdeo_url_3,
      'learning_status' => $rs->learning_status,
    ];

    try {
      DB::BeginTransaction();

      $get_learning = DB::table('learning')
        ->where('id', '=', $rs->id)
        ->update($dataPrepare);

        if (isset($rs->learning_image1)) {
          $file_1 = $rs->learning_image1;
          $url = 'local/public/learning/';

          $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
          if ($file_1->move($url, $f_name)) {
            $dataPrepare = [
              'learning_id_fk' => $rs->id,
              'learning_image_url' => $url,
              'learning_image_name' => $f_name,
              'learning_image_orderby' => '1',

            ];
            DB::table('learning_images')
              ->updateOrInsert(
                ['learning_id_fk' => $rs->id, 'learning_image_orderby' =>  1],
                $dataPrepare
              );
          }
        }

      DB::commit();
      return redirect('admin/Learning')->withSuccess('แก้ไขสื่อการเรียนรู้สำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Learning')->withError('แก้ไขสื่อการเรียนรู้ไม่สำเร็จ');
    }
  }


  public function view_learning(Request $rs)
  {
    $learning = DB::table('learning')
      ->where('id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $learning];


    return $data;
  }

  public function learning_datatable(Request $rs)
  {

    $get_learning = DB::table('learning')
    ->select('learning.*', 'learning_images.learning_image_url', 'learning_images.learning_image_name')
    ->leftJoin('learning_images', 'learning_images.learning_id_fk', '=', 'learning.id')
    ->where('learning_images.learning_image_orderby', '=', '1')
    ->orderByDesc('learning.id')
    ->get();


    $sQuery = Datatables::of($get_learning);
    return $sQuery


    ->addColumn('news_title', function ($row) {
      return $row->learning_title;
    })

      ->addColumn('learning_name', function ($row) {
        return $row->learning_name;
      })

      ->addColumn('learning_detail', function ($row) {
        return $row->learning_detail;
      })

      ->addColumn('learning_image', function ($row) {
        $html = '<img src="' . asset($row->learning_image_url . '' . $row->learning_image_name) . '"
            alt="contact-img" title="contact-img" class=".avatar-xl mr-3" height="100"
            width="100" style="object-fit: cover;">';

        return $html;
    })

      ->addColumn('created_at', function ($row) {


        if ($row->created_at) {
          return date('Y/m/d H:i:s', strtotime($row->created_at));
        } else {
          return '';
        }
      })

      ->addColumn('learning_status', function ($row) {

        if ($row->learning_status == '1') {
          $html = '<span class="badge badge-pill badge-success light">เปิดใช้งาน</span>';
        } elseif ($row->learning_status == '0') {
          $html = '<span class="badge badge-pill badge-danger light">ปิดใช้งาน</span>';
        } else {
          $html = '';
        }

        return  $html;
      })

      ->addColumn('action', function ($row) {

        $html = '<a href="#!" onclick="edit(' . $row->id . ')" class="p-2">
              <i class="lab la-whmcs font-25 text-warning"></i></a>';
        return $html;
      })


      ->rawColumns(['learning_image', 'learning_status', 'action'])

      ->make(true);
  }
}
