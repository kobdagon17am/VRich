<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class NewsController extends Controller
{
  public function __construct()
  {
    $this->middleware('admin');
  }

  public function index()
  {
    // dd('111');

    $get_news = DB::table('news')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->orderByDesc('id')
      ->get();

    return view('backend/news', compact('get_news'));
  }

  public function insert(Request $rs)
  {

    $dataPrepare = [
      'news_title' => $rs->news_title,
      'news_name' => $rs->news_name,
      'news_detail' => $rs->news_detail,
      'news_url' => $rs->news_url,
      'news_status' => $rs->news_status,
    ];

    // dd($dataPrepare);

    try {
      DB::BeginTransaction();
      $get_news = DB::table('news')
        ->insertGetId($dataPrepare);


        if (isset($rs->news_image1)) {
          $file_1 = $rs->news_image1;
          $url = 'local/public/news/';

          $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
          if ($file_1->move($url, $f_name)) {
            $dataPrepare = [
              'news_id_fk' => $get_news,
              'news_image_url' => $url,
              'news_image_name' => $f_name,
              'news_image_orderby' => '1',

            ];
            DB::table('news_images')
              ->insert($dataPrepare);
          }
        }



      DB::commit();
      return redirect('admin/News')->withSuccess('เพิ่มข่าวสารสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/News')->withError('เพิ่มข่าวสารไม่สำเร็จ');
    }

    // dd('success');

  }

  public function edit_news(Request $rs)
  {

    $dataPrepare = [
      'news_title' => $rs->news_title,
      'news_name' => $rs->news_name,
      'news_detail' => $rs->news_detail,
      'news_url' => $rs->news_url,
      'news_status' => $rs->news_status,
    ];

    try {
      DB::BeginTransaction();

      $get_news = DB::table('news')
        ->where('id', '=', $rs->id)
        ->update($dataPrepare);

        if (isset($rs->news_image1)) {
          $file_1 = $rs->news_image1;
          $url = 'local/public/news/';

          $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
          if ($file_1->move($url, $f_name)) {
            $dataPrepare = [
              'news_id_fk' => $rs->id,
              'news_image_url' => $url,
              'news_image_name' => $f_name,
              'news_image_orderby' => '1',

            ];

            DB::table('news_images')
              ->updateOrInsert(
                ['news_id_fk' => $rs->id, 'news_image_orderby' =>  1],
                $dataPrepare
              );
          }
        }

      DB::commit();
      return redirect('admin/News')->withSuccess('แก้ไขข่าวสารสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/News')->withError('แก้ไขข่าวสารไม่สำเร็จ');
    }
  }


  public function view_news(Request $rs)
  {
    $news = DB::table('news')
      ->where('id', '=', $rs->id)
      ->first();

    $data = ['status' => 'success', 'data' => $news];


    return $data;
  }

  public function news_datatable(Request $rs)
  {

    $get_news = DB::table('news')
    ->select('news.*', 'news_images.news_image_url', 'news_images.news_image_name')
    ->leftJoin('news_images', 'news_images.news_id_fk', '=', 'news.id')
    ->where('news_images.news_image_orderby', '=', '1')
    ->orderByDesc('learning.id')
    ->get();

    $sQuery = Datatables::of($get_news);
    return $sQuery


    ->addColumn('news_title', function ($row) {
      return $row->news_title;
    })

      ->addColumn('news_name', function ($row) {
        return $row->news_name;
      })

      ->addColumn('news_detail', function ($row) {
        return $row->news_detail;
      })

      ->addColumn('news_image', function ($row) {
        $html = '<img src="' . asset($row->news_image_url . '' . $row->news_image_name) . '"
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

      ->addColumn('news_status', function ($row) {

        if ($row->news_status == '1') {
          $html = '<span class="badge badge-pill badge-success light">เปิดใช้งาน</span>';
        } elseif ($row->news_status == '0') {
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


      ->rawColumns(['news_image', 'news_status', 'action'])

      ->make(true);
  }
}
