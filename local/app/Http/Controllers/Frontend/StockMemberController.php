<?php

namespace App\Http\Controllers\Frontend;

use App\Customers;
use App\CustomersBank;
use App\eWallet;
use App\eWallet_tranfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Expr\FuncCall;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use DB;

class StockMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function index()
    {
        $stock = DB::table('db_stock_members')
            ->select(
                'db_stock_members.id',
                'product_images.product_image_url',
                'product_images.product_image_name',
                'db_stock_members.product_name',
                'db_stock_members.pack_amt',
                'db_stock_members.price',
                'db_stock_members.price_total',
                'db_stock_members.pv',
                'db_stock_members.amt'
            )
            ->leftjoin('product_images', 'product_images.product_id_fk', '=', 'db_stock_members.product_id')
            ->where('db_stock_members.user_name', '=', Auth::guard('c_user')->user()->user_name)
            ->where('product_image_orderby', '=', 1)
            ->get();


        // $stock_pv = DB::table('db_stock_members')
        //     ->select(DB::raw('sum(pv_total) as pv_total'))
        //     ->where('pv_total', '>', 0)
        //     ->where('db_stock_members.user_name', '=', Auth::guard('c_user')->user()->user_name)
        //     ->first();



        // if ($sql_reservations) {
        //   $poin = $sql_reservations->point;
        // } else {
        //   $poin = 0;
        // }

        // if ($stock_pv) {
        //     $point = $stock_pv->pv_total;
        // } else {
        //     $point = 0;
        // }


        return view('frontend/StockMember', compact('stock'));
    }

    public function Stock_history()
    {


        return view('frontend/Stock-history');
    }

    public function stock_tranfer(Request $rs)
    {
        $stock = DB::table('db_stock_members')
            ->select(
                'db_stock_members.product_id',
                'db_stock_members.id',
                'db_stock_members.product_name',
                'db_stock_members.pack_amt',
                'db_stock_members.price',
                'db_stock_members.price_total',
                'db_stock_members.pv',
                'db_stock_members.amt',
                'db_stock_members.product_unit_id_fk'
            )
            ->where('db_stock_members.customers_id_fk', '=', Auth::guard('c_user')->user()->id)
            ->where('id', $rs->stock_id)
            ->where('pack_amt','>',0)
            ->first();

        // dd($rs->all());

        if ($stock) {
            if ($stock->pack_amt < $rs->amt) {
                return redirect('StockMember')->withError('There is not enough product for transfer.');
            } else {
                // dd($stock->pack_amt,$rs->amt);

                $db_stock_members = DB::table('db_stock_members')
                    ->where('product_id', '=', $stock->product_id)
                    ->where('user_name', '=', $rs->username_receive)
                    ->first();

                if ($db_stock_members) {
                    $amt = $db_stock_members->pack_amt;
                } else {
                    $amt = 0;
                }
                $code_stock = \App\Http\Controllers\Frontend\FC\RunCodeController::db_code_stock();


                try {
                    DB::BeginTransaction();

                    if ($db_stock_members) {

                        DB::table('db_log_stock_members')->insert([
                            'code_order' => $code_stock,

                            'product_id' => $stock->product_id,
                            'user_name' => Auth::guard('c_user')->user()->user_name,
                            'customers_id_fk' => Auth::guard('c_user')->user()->id,
                            'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                            'user_name_recive' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'amt_old' => $stock->pack_amt,
                            'amt' => $rs->amt,
                            'amt_new' => $stock->pack_amt - $rs->amt,
                            'pv' =>  $stock->pv,
                            'price' =>  $stock->pv,
                            'product_unit_id_fk' => $stock->product_unit_id_fk,
                            'type' => 'remove',
                            'type_action' => 'tranfer',
                            'status' => 'success',
                            'note' => 'tranfer',

                        ]);

                        DB::table('db_log_stock_members')->insert([
                            'code_order' => $code_stock,

                            'product_id' => $stock->product_id,
                            'user_name' => $rs->username_receive,
                            // 'customers_id_fk' => $rs->username_receive_id_fk,
                            'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                            'user_name_recive' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'amt_old' => $db_stock_members->pack_amt,
                            'amt' => $rs->amt,
                            'amt_new' => $db_stock_members->pack_amt + $rs->amt,
                            'pv' =>  $stock->pv,
                            'price' =>  $stock->pv,
                            'product_unit_id_fk' => $stock->product_unit_id_fk,
                            'type' => 'add',
                            'type_action' => 'tranfer',
                            'status' => 'success',
                            'note' => 'tranfer',

                        ]);

                        $update_tranfer = DB::table('db_stock_members')
                            ->where('id', $stock->id)
                            ->update([
                                'pack_amt' => $stock->pack_amt - $rs->amt
                            ]);

                        $update_recive = DB::table('db_stock_members')
                            ->where('id', $db_stock_members->id)
                            ->update([
                                'pack_amt' => $db_stock_members->pack_amt + $rs->amt
                            ]);
                            DB::commit();
                        return redirect('StockMember')->withSuccess('Tranfer Success');
                    } else {

                        DB::table('db_log_stock_members')->insert([
                            'code_order' => $code_stock,

                            'product_id' => $stock->product_id,
                            'user_name' => Auth::guard('c_user')->user()->user_name,
                            'customers_id_fk' => Auth::guard('c_user')->user()->id,
                            'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                            'user_name_recive' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'amt_old' => $stock->pack_amt,
                            'amt' => $rs->amt,
                            'amt_new' => $stock->pack_amt - $rs->amt,
                            'pv' =>  $stock->pv,
                            'price' =>  $stock->pv,
                            'product_unit_id_fk' => $stock->product_unit_id_fk,
                            'type' => 'remove',
                            'type_action' => 'tranfer',
                            'status' => 'success',
                            'note' => 'tranfer',

                        ]);

                        DB::table('db_log_stock_members')->insert([
                            'code_order' => $code_stock,

                            'product_id' => $stock->product_id,
                            'user_name' => $rs->username_receive,
                            'product_name' => $stock->product_name,
                            // 'customers_id_fk' => $rs->username_receive_id_fk,
                            'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                            'user_name_recive' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'amt_old' => 0,
                            'amt' => $rs->amt,
                            'amt_new' => $rs->amt,
                            'pv' =>  $stock->pv,
                            'price' =>  $stock->pv,
                            'product_unit_id_fk' => $stock->product_unit_id_fk,
                            'type' => 'add',
                            'type_action' => 'tranfer',
                            'status' => 'success',
                            'note' => 'tranfer',

                        ]);


                        $tranfer = DB::table('db_stock_members')
                        ->where('id',  $stock->id)
                        ->update([
                            'pack_amt' => $stock->pack_amt - $rs->amt,
                        ]);

                        $recive = DB::table('db_stock_members')->insert([
                            'product_id' => $stock->product_id,
                            'user_name' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'product_name' => $stock->product_name,
                            'pack_amt' => $rs->amt,
                            'pv' =>  $stock->pv,
                            'price' =>  $stock->price,
                            'product_unit_id_fk' => $stock->product_unit_id_fk,

                        ]);
                        DB::commit();

                        return redirect('StockMember')->withSuccess('Tranfer Success');
                    }

                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect('StockMember')->withError('Tranfer stock Fail ');
                }


            }
        } else {
            return redirect('StockMember')->withError('Fail Stock is Null.');
        }
    }


    public function datatable(Request $rs)
    {
        $s_date = !empty($rs->s_date) ? date('Y-m-d', strtotime($rs->s_date)) : date('Y-01-01');
        $e_date = !empty($rs->e_date) ? date('Y-m-d', strtotime($rs->e_date)) : date('Y-12-t');

        $date_between = [$s_date, $e_date];
        if($rs->user_name){
            $user_name = $rs->user_name;
        }else{
            $user_name = Auth::guard('c_user')->user()->user_name;
        }


        $introduce = DB::table('db_log_stock_members')

            ->where('db_log_stock_members.introduce_id', '=',$user_name)


            // ->when($date_between, function ($query, $date_between) {
            //     return $query->whereBetween('created_at', $date_between);
            // });

        $sQuery = Datatables::of($introduce);
        return $sQuery

            ->addColumn('status_active', function ($row) { //การรักษาสภำพ
                if(empty($row->qualification_id)){
                    $resule ='<i class="fas fa-circle text-warning"></i>';
                    return $resule;
                }

                if(empty($row->expire_date) || (strtotime($row->expire_date) < strtotime(date('Ymd')))){

                    $date_tv_active= date('d/m/Y',strtotime($row->expire_date));
                    $resule ='<i class="fas fa-circle text-danger"></i>';
                    return $resule;
                }else{
                    $date_tv_active= date('d/m/Y',strtotime($row->expire_date));
                    $resule ='<i class="fas fa-circle text-success"></i>';
                    return $resule;

                }
            })
            ->addColumn('created_at', function ($row) { //วันที่สมัคร
                if($row->created_at == '0000-00-00 00:00:00'){
                    return '-';
                }else{
                    return date('Y/m/d', strtotime($row->created_at));
                }

            })

            ->addColumn('introduce_name', function ($row) {
                $upline = \App\Http\Controllers\Frontend\FC\AllFunctionController::get_upline($row->introduce_id);
                if($upline){
                    $html = @$upline->name.' '.@$upline->last_name;

                }else{
                    $html = '-';

                }

                return $html;
            })

            ->addColumn('expire_date', function ($row) {
                if(empty($row->expire_date)) {
                    return  0;
                }

                if(strtotime($row->expire_date) < strtotime(date('Ymd')) ){
                    //$html= Carbon::now()->diffInDays($row->expire_date);
                    return  0;
                }else{

                    $html= Carbon::now()->diffInDays($row->expire_date);
                    return $html;

                }

                if($row->expire_date){
                    $html= Carbon::now()->diffInDays($row->expire_date.' 00:00:00' );
                    return  $html;
                }else{
                    return  '-';
                }

            })


            ->addColumn('sponsor_lv', function ($row) use ($rs) {
                $html = "ชั้น $rs->lv";
                return  $html;
            })


            ->addColumn('view',function($row) use ($rs)  {


                $count = DB::table('customers')
                    ->select('customers.*')
                    ->where('introduce_id', '=',$row->user_name)
                    ->where('name', '!=','')
                    ->count();
                    $lv = $rs->lv+1;
                if($count > 0 and $rs->lv < 3){  $html = $count.' <a type="button" target="_blank" class="btn btn-info btn-sm" href="'.route('Workline',['user_name'=>$row->user_name,'lv'=>$lv]).'">
                    <i class="fa fa-sitemap"></i></a>';
                    return $html;
                }else{
                    return '-';
                }

            })

            ->addColumn('action', function ($row) {
            //     $html = '<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#discountModal">
            //     <i class="bx bx-link-external"></i>
            // </button>';
            $html = '<div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-link-external"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" data-bs-toggle="modal" href="#addTransferJPModal" role="button">โอน</a></li>
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmModal">ยืนยันสิทธิ์</a></li>
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#discountModal">รับส่วนลด</a></li>


            </ul>
          </div>';

                return '-';
            })


            ->rawColumns(['status_active','view','action'])
            ->make(true);
    }
}
