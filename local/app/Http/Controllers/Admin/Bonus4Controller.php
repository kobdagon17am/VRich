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

class Bonus4Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bonus4()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus4');
    }

    public function bonus4_detail($user_name)
    {

        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus4_detail',compact('user_name'));
    }



    public function run_bonus4(Request $rs)
    {
        $date_start = $rs->date_start . ' 00:00:00';
        $date_end = $rs->date_end . ' 23:59:59';
        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;


        $db_orders =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('db_orders.customers_user_name,code_order,count(code_order) as count_code')
            ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
            ->where('db_orders.type', '!=', 'send_stock')
            // ->wheredate('customers.expire_date', '>=', $date_end)
            ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' = ''  THEN  date(db_orders.created_at) = '{$date_start}' else 1 END"))
            ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) >= '{$date_start}' and date(db_orders.created_at) <= '{$date_end}'else 1 END"))
            ->whereRaw(("case WHEN '{$date_start}' = '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) = '{$date_end}' else 1 END"))
            ->havingRaw('count(count_code) > 1 ')

            ->groupby('db_orders.code_order')
            ->get();


        if (count($db_orders) > 0) {
            DB::rollback();
            return redirect('admin/bonus4')->withError('มีเลขออเดอซ้ำในระบบ');
        }
        $order =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('db_orders.customers_user_name,customers.reward,customers.name,customers.last_name,customers.expire_date,
            dataset_qualification.business_qualifications,customers.qualification_id,dataset_qualification.bonus4_reth,customers.introduce_id,sum(db_orders.pv_total) sum_pv_total')
            ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('db_orders.type', '!=', 'send_stock')
            ->where('customers.introduce_id', '!=','AA')

            ->where('customers.qualification_id', '>=', 2)
            ->whereBetween('db_orders.created_at', [$date_start, $date_end])
            ->wherein('order_status_id_fk', [4, 5, 6, 7])
            ->groupby('db_orders.customers_user_name')
            ->get();





        if (count($order) == 0) {
            DB::rollback();
            return redirect('admin/bonus4')->withError('ไม่มีสินค้าในวันที่เลือก');
        }

        try {
            DB::BeginTransaction();


            foreach ($order as $value) {

                $introduce_id =  DB::table('customers')
                ->selectRaw('dataset_qualification.business_qualifications,customers.qualification_id,dataset_qualification.bonus4_reth')
                ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
                ->where('customers.user_name',$value->introduce_id)
                ->first();



                $reth_resule = $introduce_id->bonus4_reth -  $value->bonus4_reth;
                if($reth_resule > 0){

                    $bonus_total = $value->sum_pv_total*$reth_resule;
                    $dataPrepare = [
                        'user_name' => $value->customers_user_name,
                        'name' => $value->name,
                        'last_name' => $value->last_name,
                        'qualification' =>  $value->business_qualifications,
                        'introduce_id' =>  $value->introduce_id,
                        'pv' =>  $value->sum_pv_total,
                        'reth' =>  $value->bonus4_reth,
                        'reth_introduce' =>$introduce_id->bonus4_reth,
                        'reth_resule' => $reth_resule,
                        'bonus_total' => $bonus_total,
                        'date_start' =>  $date_start,
                        'date_end' =>  $date_end,
                        'year' => $year,
                        'month' => $month,
                        'note' => $note,
                    ];

                    DB::table('report_bonus4_detail_all')
                        ->updateOrInsert(['user_name' => $value->customers_user_name, 'year' => $year, 'month' => $month], $dataPrepare);

                }

            }

            DB::commit();


            $report_bonus4_detail_all_to_bonus4 =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ

            ->where('year',$year)
            ->where('month',$month)
            ->groupby('report_bonus4_detail_all.introduce_id')
            ->get();




            // $report_bonus4_detail_all =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            // ->selectRaw('id,introduce_id,count(report_bonus4_detail_all.introduce_id) as count_introduce_id')
            // ->where('year',$year)
            // ->where('month',$month)
            // ->havingRaw('count(count_introduce_id) = 1')

            // ->groupby('report_bonus4_detail_all.introduce_id')
            // ->get();

            // $user_arr_id =array();

            // foreach($report_bonus4_detail_all as $value){
            //     $user_arr_id[] = $value->id;
            // }


            // if($user_arr_id){
            //     $report_bonus4_detail_all =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            //     ->where('year',$year)
            //     ->where('month',$month)
            //     ->wherein('id',$user_arr_id)
            //     ->delete();
            // }


            $report_bonus4_detail_all =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('id,introduce_id')
            ->where('year',$year)
            ->where('month',$month)
            ->groupby('report_bonus4_detail_all.introduce_id')
            ->get();


            $user_arr_id =array();

            foreach($report_bonus4_detail_all as $value){
                        $customers = DB::table('customers')
                        ->where('introduce_id', '=',  $value->introduce_id)
                        ->count();
                        if($customers<2){
                            $user_arr_id[] = $value->id;
                        }

            }

             if($user_arr_id){
                $report_bonus4_detail_all =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
                ->where('year',$year)
                ->where('month',$month)
                ->wherein('id',$user_arr_id)
                ->delete();
            }


            $report_bonus4_detail_all_to_bonus4 =  DB::table('report_bonus4_detail_all') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('introduce_id,sum(report_bonus4_detail_all.bonus_total) as bonus_total')
            ->where('year',$year)
            ->where('month',$month)
            ->groupby('report_bonus4_detail_all.introduce_id')
            ->get();

            if(empty($report_bonus4_detail_all_to_bonus4)){
                return redirect('admin/bonus4')->withError('ไม่มีไครได้รับโบนัสในรอบนี้');
            }


            foreach( $report_bonus4_detail_all_to_bonus4 as $value){
                $customers =  DB::table('customers')
                ->selectRaw('customers.user_name,customers.name,customers.last_name,customers.expire_date,dataset_qualification.business_qualifications,customers.qualification_id,dataset_qualification.bonus4_reth')
                ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
                ->where('customers.user_name',$value->introduce_id)
                ->first();
                $dataPrepare = [
                    'user_name' => $customers->user_name,
                    'name' => $customers->name,
                    'last_name' => $customers->last_name,
                    'qualification' =>  $customers->business_qualifications,
                    'reth' =>  $customers->bonus4_reth,
                    'bonus_total_usd' =>  $value->bonus_total,
                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'note' => $note,
                ];

                DB::table('report_bonus4')
                ->updateOrInsert(['user_name' => $customers->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


            }
            DB::commit();

            return redirect('admin/bonus4')->withSuccess('Success');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/bonus4')->withError($e);
        }
    }



    public function datatable_bonus4(Request $request)
    {



        $report_cashback = DB::table('report_bonus4')

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



            ->addColumn('reth', function ($row) {
                return $row->reth;
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
                $url = route('admin/bonus4_detail',['user_name'=>$row->user_name]);
                $detail = '<a href="'.$url.'" target="_blank"> <i class="las la-search font-25 text-warning" ></i> </a>';
                return $detail;

              })
              ->rawColumns(['detail'])

            ->make(true);
    }


    public function datatable_bonus4_detail(Request $request)
    {



        $report_4 = DB::table('report_bonus4_detail_all')
            ->whereRaw(("case WHEN  '{$request->username}' != ''  THEN  introduce_id = '{$request->username}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
            ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
            ->orderByDesc('id');



        $sQuery = Datatables::of($report_4);
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
