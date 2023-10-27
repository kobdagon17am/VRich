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
use App\Orders;
use App\Order_products_list;
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

            )
            ->leftjoin('product_images', 'product_images.product_id_fk', '=', 'db_stock_members.product_id')
            ->where('db_stock_members.user_name', '=', Auth::guard('c_user')->user()->user_name)
            ->where('product_image_orderby', '=', 1)
            ->where('db_stock_members.pack_amt', '>', 0)
            ->get();

            $address = DB::table('customers_address_delivery')
            ->select('customers_address_delivery.*', 'dataset_provinces.id as province_id', 'dataset_provinces.name_en as province_name', 'dataset_amphures.name_en as tambon_name', 'dataset_amphures.id as tambon_id', 'dataset_districts.id as district_id', 'dataset_districts.name_en as district_name')
            ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'customers_address_delivery.province')
            ->leftJoin('dataset_districts', 'customers_address_delivery.tambon', '=', 'dataset_districts.id')
            ->leftJoin('dataset_amphures', 'customers_address_delivery.district', '=', 'dataset_amphures.id')


            ->where('user_name', '=',  Auth::guard('c_user')->user()->user_name)
            ->first();





            if (Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id)) {

                $business_location_id = 1;

            } else {

                $business_location_id = Auth::guard('c_user')->user()->business_location_id;

            }

            $province = DB::table('dataset_provinces')
            ->select('*')
            ->where('business_location_id', $business_location_id)
            ->get();

            $customer = DB::table('customers')
            ->where('id', '=', Auth::guard('c_user')->user()->id)
            ->first();

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


        return view('frontend/StockMember', compact('stock','address','province','customer'));
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

                'db_stock_members.product_unit_id_fk'
            )
            ->where('db_stock_members.customers_id_fk', '=', Auth::guard('c_user')->user()->id)
            ->where('id', $rs->stock_id)
            ->where('pack_amt','>',0)
            ->first();


            $username_receive = DB::table('customers')
            ->where('user_name', '=', $rs->username_receive)
            ->first();

            if(empty($username_receive)){
                return redirect('StockMember')->withError('Invalid recipient username receive');

            }


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
                            'product_name' => $stock->product_name,
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
                            'product_name' => $stock->product_name,
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
                        return redirect('Stock-history')->withSuccess('Tranfer Success');
                    } else {

                        DB::table('db_log_stock_members')->insert([
                            'code_order' => $code_stock,

                            'product_id' => $stock->product_id,
                            'user_name' => Auth::guard('c_user')->user()->user_name,
                            'customers_id_fk' => Auth::guard('c_user')->user()->id,
                            'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                            'user_name_recive' => $rs->username_receive,
                            'distribution_channel_id_fk' => 3,
                            'product_name' => $stock->product_name,
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

                        return redirect('Stock-history')->withSuccess('Tranfer Success');
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
        // $s_date = !empty($rs->s_date) ? date('Y-m-d', strtotime($rs->s_date)) : date('Y-01-01');
        // $e_date = !empty($rs->e_date) ? date('Y-m-d', strtotime($rs->e_date)) : date('Y-12-t');

        // $date_between = [$s_date, $e_date];
        // if($rs->user_name){
        //     $user_name = $rs->user_name;
        // }else{
        //     $user_name = Auth::guard('c_user')->user()->user_name;
        // }


        $introduce = DB::table('db_log_stock_members')
            ->where('db_log_stock_members.user_name', '=',Auth::guard('c_user')->user()->user_name)
            ->orderby('id','DESC');
            // ->when($date_between, function ($query, $date_between) {
            //     return $query->whereBetween('created_at', $date_between);
            // });

        $sQuery = Datatables::of($introduce);
        return $sQuery
        ->addColumn('created_at', function ($row) { //วันที่สมัคร
            if($row->created_at == '0000-00-00 00:00:00'){
                return '-';
            }else{
                return date('Y/m/d H:i:s', strtotime($row->created_at));
            }

        })

        ->addColumn('code_order', function ($row) {
            if ($row->code_order) {
            $data = '<a href="' . route('order_detail', ['code_order' => $row->code_order]) . '" class="btn btn-outline-primary">' . $row->code_order . '</a>';

                return  $data ;
            } else {
                return '-';
            }
        })

        ->addColumn('type_action', function ($row) { //การรักษาสภำพ
                if($row->type_action == 'tranfer'){

                    $resule ='<span class="badge bg-success">'.$row->type_action.'</span>';
                    return $resule;
                }else{
                    $resule ='<span class="badge bg-primary">'.$row->type_action.'</span>';
                    return $resule;

                }
            })

            ->addColumn('amt', function ($row) { //การรักษาสภำพ
                if($row->type == 'remove'){

                    $resule ='-'.$row->amt;
                    return $resule;
                }else{
                    $resule =$row->amt;
                    return $resule;

                }
            })



        //     ->addColumn('introduce_name', function ($row) {
        //         $upline = \App\Http\Controllers\Frontend\FC\AllFunctionController::get_upline($row->introduce_id);
        //         if($upline){
        //             $html = @$upline->name.' '.@$upline->last_name;

        //         }else{
        //             $html = '-';

        //         }

        //         return $html;
        //     })



            ->rawColumns(['type_action','code_order'])
            ->make(true);
    }

    public function stock_delivery(Request $rs)
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

            $code_stock = \App\Http\Controllers\Frontend\FC\RunCodeController::db_code_order();

            try {
                DB::BeginTransaction();


                $insert_db_orders = new Orders();
                $insert_order_products_list = new Order_products_list();
                $insert_db_orders->quantity = $rs->amt;
                $insert_db_orders->customers_id_fk = Auth::guard('c_user')->user()->id;
                $insert_db_orders->customers_user_name =  Auth::guard('c_user')->user()->user_name;
                if (Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id)) {
                    $dataset_currency =  1;
                    $business_location_id = 1;
                } else {
                    $dataset_currency =  2;
                    $business_location_id = Auth::guard('c_user')->user()->business_location_id;
                }

                $insert_db_orders->business_location_id_fk =  $business_location_id;
                $insert_db_orders->status_payment_sent_other = 0;
                $insert_db_orders->pay_type = 'StockMember';

        if ($rs->receive == 'sent_address') {
            $insert_db_orders->address_sent = 'system';

            if (empty($rs->province_id) ) {
                return redirect('StockMember')->withError('Please enter your address before purchasing.');
            }
            $insert_db_orders->delivery_province_id = $rs->province_id;
            $insert_db_orders->house_no = $rs->house_no;
            // $insert_db_orders->house_name = 'system';
            $insert_db_orders->moo = $rs->moo;
            $insert_db_orders->soi = $rs->soi;
            $insert_db_orders->road = $rs->road;
            $insert_db_orders->tambon_id = $rs->tambon_id;
            $insert_db_orders->district_id = $rs->district_id;
            $insert_db_orders->province_id = $rs->province_id;
            $insert_db_orders->zipcode = $rs->zipcode;

            $insert_db_orders->tel = $rs->phone;
            $insert_db_orders->name = $rs->name;
        } else {
            if (empty($rs->same_province) ) {
                return redirect('StockMember')->withError('Please enter your address before purchasing.');
            }

            $insert_db_orders->address_sent = 'other';
            $insert_db_orders->delivery_province_id = $rs->same_province;
            $insert_db_orders->house_no = $rs->same_address;
            // $insert_db_orders->house_name = 'system';
            $insert_db_orders->moo = $rs->same_moo;
            $insert_db_orders->soi = $rs->same_soi;
            $insert_db_orders->road = $rs->same_road;
            $insert_db_orders->tambon_id = $rs->same_tambon;
            $insert_db_orders->district_id = $rs->same_district;
            $insert_db_orders->province_id = $rs->same_province;
            $insert_db_orders->zipcode = $rs->same_zipcode;
            $insert_db_orders->tel = $rs->same_phone;
            $insert_db_orders->name = $rs->sam_name;
        }

            $insert_db_orders->order_status_id_fk = 5;
            $insert_db_orders->code_order = $code_stock;
            $insert_db_orders->type = 'send_stock';


            $insert_db_products_list[] = [
                'code_order' => $code_stock,
                'product_id_fk' => $stock->product_id,
                'product_unit_id_fk' => $stock->product_unit_id_fk,
                'customers_username' => Auth::guard('c_user')->user()->user_name,
                'selling_price' => 0,
                'product_name' => $stock->product_name,
                'amt' =>   $rs->amt,
                'pv' =>  0,
                'total_pv' => 0,
                'total_price' => 0,
            ];

                // $insert_db_orders->tracking_type = $rs->tracking_type;;
                ///// ---------- stock -------------///

                    DB::table('db_log_stock_members')->insert([
                        'code_order' => $code_stock,
                        'product_id' => $stock->product_id,
                        'user_name' => Auth::guard('c_user')->user()->user_name,
                        'customers_id_fk' => Auth::guard('c_user')->user()->id,
                        'user_name_tranfer' => Auth::guard('c_user')->user()->user_name,
                        'distribution_channel_id_fk' => 3,
                        'amt_old' => $stock->pack_amt,
                        'product_name' => $stock->product_name,
                        'amt' => $rs->amt,
                        'amt_new' => $stock->pack_amt - $rs->amt,
                        'pv' =>  $stock->pv,
                        'price' =>  $stock->pv,
                        'product_unit_id_fk' => $stock->product_unit_id_fk,
                        'type' => 'remove',
                        'type_action' => 'delivery',
                        'status' => 'success',
                        'note' => 'Delivery',

                    ]);

                    $update_tranfer = DB::table('db_stock_members')
                        ->where('id', $stock->id)
                        ->update([
                            'pack_amt' => $stock->pack_amt - $rs->amt
                        ]);

                        $insert_db_orders->save();
                        $insert_order_products_list::insert($insert_db_products_list);
                        DB::commit();
                    return redirect('order_history')->withSuccess('Tranfer Success');


            } catch (\Exception $e) {
                DB::rollback();
                return redirect('StockMember')->withError('Tranfer stock Fail ');
            }

        }
    } else {
        return redirect('StockMember')->withError('Fail Stock is Null.');
    }

    }



}
