<?php

namespace App\Http\Controllers\Admin;

use App\Customers;
use App\Orders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\OrderExport;
use App\Imports\OrderImport;
use App\Shipping_type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Filesystem\Filesystem;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Matreials;
use App\Order_products_list;
use App\ProductMaterals;
use App\Stock;
use App\StockMovement;
use DB;
use Illuminate\Support\Facades\Auth;

use PDF;
use  Maatwebsite\Excel\Facades\Excel;

class Bonus3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bonus3()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();


        return view('backend/bonus3');
    }

    public function bonus3_detail($user_name)
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus3_detail',compact('user_name'));
    }


    public function product_list_view(Request $request)
    {

        $products_list = DB::table('db_order_products_list')
            ->where('code_order', '=', $request->code_order)
            ->get();
        $html = '';
        $i = 0;
        foreach ($products_list as $value) {
            $i++;

            $html .= "
            <tr>
            <td>$i</td>
            <td>$value->product_name</td>
            <td>$value->amt</td>
            <td>$value->amt_out_stock</td>
            <td>$value->product_unit_name</td>
            <td>$value->type</td>
        </tr>
            ";
        }
        return $html;
    }


    public function run_bonus3(Request $rs)
    {

        $date_start = $rs->date_start.' 00:00:00';
        $date_end = $rs->date_end.' 23:59:59';
        $route =  $rs->route;
        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;


        $report_bonus3_detail_delete =  DB::table('report_bonus3_detail')
        ->where('year',$year)
        ->where('month',$month)
        ->delete();


        $report_bonus3_delete =  DB::table('report_bonus3')
        ->where('year',$year)
        ->where('month',$month)
        ->delete();

       $db_orders =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
        ->selectRaw('db_orders.customers_user_name,code_order,count(code_order) as count_code')
        ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
        ->whereIn('db_orders.type',['other','promotion'])
        // ->wheredate('customers.expire_date','>=',$date_end)
        ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' = ''  THEN  date(db_orders.created_at) = '{$date_start}' else 1 END"))
        ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) >= '{$date_start}' and date(db_orders.created_at) <= '{$date_end}'else 1 END"))
        ->whereRaw(("case WHEN '{$date_start}' = '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) = '{$date_end}' else 1 END"))
        ->havingRaw('count(count_code) > 1 ')
        ->groupby('db_orders.code_order')
        ->get();


        if(count($db_orders)>0){
            DB::rollback();
            return redirect('admin/bonus3')->withError('มีเลขออเดอซ้ำในระบบ');
        }


        $pv_allsale_permouth =  DB::table('customers')
            ->where('pv_allsale_permouth', '>', 0)
            ->update(['pv_allsale_permouth' => '0']);

        $status_runbonus_allsale =  DB::table('customers')
            ->where('status_runbonus_allsale', '=', 'success')
            ->update(['status_runbonus_allsale' => 'pending']);


        $reth_bonus_3 =  DB::table('customers')
            ->where('reth_bonus_3', '>', 0)
            ->update(['reth_bonus_3' => 0]);


        $order =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
        ->selectRaw('db_orders.customers_user_name,customers.name,customers.last_name,customers.expire_date,customers.qualification_id,sum(db_orders.pv_total) sum_pv_total')
        ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
        ->whereIn('db_orders.type',['other','promotion'])

        ->whereBetween('db_orders.created_at',[$date_start, $date_end])
        ->wherein('order_status_id_fk',[4,5,6,7])
        ->groupby('db_orders.customers_user_name')
        ->get();


        if(count($order)== 0){
            DB::rollback();
            return redirect('admin/bonus3')->withError('ไม่มีสินค้าในวันที่เลือก');

        }

        try {
            DB::BeginTransaction();
        foreach ($order as $value) {

            $customer = DB::table('customers')->select('id', 'pv', 'user_name', 'introduce_id', 'status_runbonus_allsale')
                ->where('status_customer', '!=', 'cancel')
                ->where('user_name', '=', $value->customers_user_name)
                ->first();

            if ($customer->status_runbonus_allsale == 'pending') {
                $data = \App\Http\Controllers\Admin\Bonus3Controller::runbonus($value->customers_user_name, $value->sum_pv_total, $i = 0,$value->customers_user_name);
                // dd($this->arr,$data);
                // dd($data);
                if ($data['status'] == 'success') {

                    DB::table('customers')
                        ->where('user_name', '=', $value->customers_user_name)
                        ->update(['status_runbonus_allsale' => 'success']);
                    // $resule = ['status' => 'success', 'message' => 'ไม่มี User นี้ในระบบ'];
                    // return  $resule;

                } else {
                    dd($data, 'เกิดข้อผิดพลาด');
                }
            }
        }

        // $user = DB::table('customers') //อัพ Pv ของตัวเอง
        //     ->select('id', 'pv', 'user_name', 'introduce_id','pv_allsale_permouth')
        //     ->where('status_customer', '!=', 'cancel')
        //     ->where('status_runbonus_allsale', '=', 'success')
        //     ->get();
        // dd($user, 'success');


        $customers_bonus3 = DB::table('customers') //อัพ Pv ของตัวเอง
            ->select('id', 'pv', 'user_name', 'introduce_id','pv_allsale_permouth','qualification_id','reth_bonus_3')
            ->where('qualification_id', '>=', '2')
            ->where('pv_allsale_permouth', '>', '0')

            ->where('status_customer', '!=', 'cancel')
            // ->where('status_runbonus_allsale', '=', 'success')
            ->get();


            foreach($customers_bonus3 as $value){

                $dataset_casback_product = DB::table('dataset_casback_product')
                ->where('product_id', '=',8)
                ->where('amt', '<=', $value->pv_allsale_permouth)
                ->whereRaw('amt = (SELECT MAX(amt) FROM dataset_casback_product WHERE amt <= ?)',[$value->pv_allsale_permouth])
                ->first();


                if($dataset_casback_product){
                    $price_usd = $dataset_casback_product->price_usd;
                }else{
                    $price_usd = 0;
                }


                DB::table('customers')
                ->where('user_name', '=', $value->user_name)
                ->update(['reth_bonus_3' => $price_usd]);

            }

            $customers_bonus3_run = DB::table('customers') //อัพ Pv ของตัวเอง
            ->select('id', 'pv', 'user_name', 'introduce_id','pv_allsale_permouth','qualification_id','reth_bonus_3')
            ->where('qualification_id', '>=', '2')

            ->where('reth_bonus_3', '>', '0')
            ->where('status_customer', '!=', 'cancel')
            // ->where('status_runbonus_allsale', '=', 'success')
            ->get();


            foreach($customers_bonus3_run as $value){

                $customer = DB::table('customers')->select('customers.id', 'customers.pv','customers.user_name',
                'customers.name','customers.last_name','customers.introduce_id','dataset_qualification.business_qualifications', 'customers.status_runbonus_allsale','customers.pv_allsale_permouth','customers.reth_bonus_3')
                ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
                ->where('customers.status_customer', '!=', 'cancel')
                // ->where('customers.reth_bonus_3', '>', '0')
                ->where('customers.introduce_id', '=', $value->user_name)
                ->get();



                foreach($customer as $c_value){



                    $reth_total = $value->reth_bonus_3 - $c_value->reth_bonus_3;



                    if($reth_total < 0){
                        $dataPrepare = [
                            'user_name' => $c_value->user_name,
                            'name' => $c_value->name,
                            'last_name' => $c_value->last_name,
                            'qualification' =>  $c_value->business_qualifications,
                            'introduce_id' =>  $c_value->introduce_id,
                            'pv'=>$c_value->pv_allsale_permouth,
                            'pv_introduce'=>$value->pv_allsale_permouth,
                            'reth_head'=> $value->reth_bonus_3,
                            'reth_introduce'=> $c_value->reth_bonus_3,
                            'reth_total'=> $reth_total*-1,
                            'bonus_total_usd'=> $c_value->pv_allsale_permouth*($reth_total*-1),
                            'date_start' =>  $date_start,
                            'date_end' =>  $date_end,
                            'year' => $year,
                            'month' => $month,
                            'note' => $note,
                        ];

                        DB::table('report_bonus3_detail')
                        ->updateOrInsert(['user_name' => $c_value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);
                    }

                }

            }


            $report_bonus4_detail_all_to_bonus3 =  DB::table('report_bonus3_detail') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('introduce_id,sum(report_bonus3_detail.bonus_total_usd) as bonus_total')
            ->where('year',$year)
            ->where('month',$month)
            ->groupby('report_bonus3_detail.introduce_id')
            ->get();

            if(empty($report_bonus4_detail_all_to_bonus3)){
                return redirect('admin/bonus3')->withError('ไม่มีไครได้รับโบนัสในรอบนี้');
            }

            foreach($report_bonus4_detail_all_to_bonus3 as $value){
                $customers3 =  DB::table('customers')
                ->selectRaw('customers.user_name,customers.name,customers.last_name,customers.expire_date,dataset_qualification.business_qualifications,customers.qualification_id,dataset_qualification.bonus4_reth')
                ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
                ->where('customers.user_name',$value->introduce_id)
                ->first();
                $dataPrepare = [
                    'user_name' => $customers3->user_name,
                    'name' => $customers3->name,
                    'last_name' => $customers3->last_name,
                    'qualification' =>  $customers3->business_qualifications,
                    'bonus_total_usd' =>  $value->bonus_total,
                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'note' => $note,
                ];

                DB::table('report_bonus3')
                ->updateOrInsert(['user_name' => $customers3->user_name, 'year' => $year, 'month' => $month], $dataPrepare);
            }
            DB::commit();
            return redirect('admin/bonus3')->withSuccess('Success');

        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/bonus3')->withError('Fail');
        }


    }


    public function runbonus($customers_user_name, $pv, $i,$userbuy)
    {

        $user = DB::table('customers') //อัพ Pv ของตัวเอง
            ->select('id', 'pv', 'user_name', 'introduce_id', 'status_customer', 'pv_allsale_permouth')
            ->where('user_name', '=', $customers_user_name)
            // ->where('status_runbonus_allsale_1', '=', 'pending')
            ->first();

        // if (empty($user)) {
        //     DB::table('customers')
        //     ->where('user_name', '=', $customers_user_name)
        //     ->update(['status_runbonus_allsale_1' => 'success']);
        //     $resule = ['status' => 'success', 'message' => 'ไม่มี User นี้ในระบบ'];
        //     return  $resule;

        // }

        try {
            DB::BeginTransaction();

            if ($user) {
                // if ($user->status_customer != 'cancel') {
                    if ($user->pv_allsale_permouth) {
                        $pv_allsale_permouth = $user->pv_allsale_permouth + $pv;
                    } else {
                        $pv_allsale_permouth = 0 + $pv;
                    }

                    // if($user->user_name == '0857072'){
                    //     $this->arr['order'][] = $userbuy.' | '.$pv;
                    // }

                    DB::table('customers')
                        ->where('user_name', '=', $user->user_name)
                        ->update(['pv_allsale_permouth' => $pv_allsale_permouth]);
                // }
                //DB::rollback();
                if ($user->introduce_id and $user->introduce_id != 'AA') {

                    $i++;
                    // $this->arr[$i] = $user->introduce_id;
                    $data = \App\Http\Controllers\Admin\Bonus3Controller::runbonus($user->introduce_id, $pv, $i,$userbuy);
                    if ($data['status'] == 'success') {
                        DB::commit();
                        $resule = ['status' => 'success', 'message' => 'สิ้นสุด'];
                        return $resule;
                    } else {

                        \App\Http\Controllers\Admin\Bonus3Controller::runbonus($user->introduce_id, $pv, $i,$userbuy);
                    }
                } else {
                    DB::commit();
                    $resule = ['status' => 'success', 'message' => 'สิ้นสุด'];
                    return $resule;
                }
            } else {
                DB::commit();
                $resule = ['status' => 'success', 'message' => 'สิ้นสุด'];
                return $resule;
            }
        } catch (Exception $e) {
            //DB::rollback();

            $resule = [
                'status' => 'fail',
                'message' => 'Update PvPayment Fail',
            ];
            return $resule;
        }
    }

    public function datatable_bonus3(Request $request)
    {



        $report_cashback = DB::table('report_bonus3')

            ->whereRaw(("case WHEN  '{$request->username}' != ''  THEN  user_name = '{$request->username}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
            ->orderByDesc('id');



        $sQuery = Datatables::of($report_cashback);
        return $sQuery


            ->addColumn('user_name', function ($row) {
                return $row->user_name;
            })

            ->addColumn('name', function ($row) {
                return $row->name;
            })

            ->addColumn('last_name', function ($row) {
                return $row->last_name;
            })


            ->addColumn('qualification', function ($row) {
                return $row->qualification;
            })

            ->addColumn('month', function ($row) {
                return $row->month;
            })


            ->addColumn('year', function ($row) {
                return $row->year;
            })

            ->addColumn('bonus_total_usd', function ($row) {
                return $row->bonus_total_usd;
            })

            ->addColumn('status', function ($row) {
                return $row->status;
              })


            ->addColumn('note', function ($row) {
                return $row->note;
            })

            ->addColumn('detail', function ($row) {
                $url = route('admin/bonus3_detail',['user_name'=>$row->user_name]);
                $detail = '<a href="'.$url.'" target="_blank"> <i class="las la-search font-25 text-warning" ></i> </a>';
                return $detail;

              })
              ->rawColumns(['detail'])

            ->make(true);
    }


    public function datatable_bonus3_detail(Request $request)
    {



        $report_3 = DB::table('report_bonus3_detail')
            ->whereRaw(("case WHEN  '{$request->username}' != ''  THEN  introduce_id = '{$request->username}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
            ->orderByDesc('id');



        $sQuery = Datatables::of($report_3);
        return $sQuery


            ->addColumn('user_name', function ($row) {
                return $row->user_name;
            })

            ->addColumn('name', function ($row) {
                return $row->name;
            })

            ->addColumn('last_name', function ($row) {
                return $row->last_name;
            })


            ->addColumn('qualification', function ($row) {
                return $row->qualification;
            })

            ->addColumn('month', function ($row) {
                return $row->month;
            })


            ->addColumn('year', function ($row) {
                return $row->year;
            })



            ->make(true);
    }

}
