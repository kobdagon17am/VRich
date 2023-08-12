<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

  public function index()
  {
    // dd('111');

    $get_category = DB::table('categories')
      // ->where('username','=',Auth::guard('c_user')->user()->username)
      // ->where('password','=',md5($req->password))
      // ->first();
      ->get();
    return view('backend/category', compact('get_category'));
  }
  public function insert(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'category_name' => $rs->category_name,
      'category_en_name' => $rs->category_en_name,
      'status' => $rs->category_status,
    ];

    try {
      DB::BeginTransaction();
      $get_category = DB::table('categories')
        ->insert($dataPrepare);
      DB::commit();
      return redirect('admin/Category')->withSuccess('เพิ่มหมวดสินค้าสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Category')->withError('เพิ่มหมวดสินค้าไม่สำเร็จ');

    }



  }


  public function edit_category(Request $rs)
  {
    // dd($rs->all());

    $dataPrepare = [
      'category_name' => $rs->category_name,
      'category_en_name' => $rs->category_en_name,
      'status' => $rs->category_status,
    ];

    try {
      DB::BeginTransaction();
      $get_category = DB::table('categories')
      ->where('id','=',$rs->id)
        ->update($dataPrepare);
      DB::commit();
      return redirect('admin/Category')->withSuccess('แก้ไขข้อมูลหมวดสินค้าสำเร็จ');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('admin/Category')->withError('แก้ไขข้อมูลหมวดสินค้าไม่สำเร็จ');

    }



  }

  public function view_category(Request $rs)
  {

     $categories = DB::table('categories')
     ->where('id','=',$rs->id)
     ->first();

     $data = ['status' => 'success', 'data' => $categories];


     return $data;

  }
}
