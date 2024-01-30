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

class Bonus7Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bonus7()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus7');
    }

    public function run_bonus7(Request $rs)
    {
        $date_start = $rs->date_start . ' 00:00:00';
        $date_end = $rs->date_end . ' 23:59:59';
        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;

        $report_bonus7_detail_delete =  DB::table('report_bonus7')
        ->where('year',$year)
        ->where('month',$month)
        ->delete();

        $pv_allsale_permouth =  DB::table('customers')
        ->where('pv_allsale_permouth', '>', 0)
        ->update(['pv_allsale_permouth' => '0']);

       $status_runbonus_allsale =  DB::table('customers')
        ->where('status_runbonus_allsale', '=', 'success')
        ->update(['status_runbonus_allsale' => 'pending']);


       $reth_bonus_3 =  DB::table('customers')
        ->where('reth_bonus_3', '>', 0)
        ->update(['reth_bonus_3' => 0]);

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
            return redirect('admin/bonus7')->withError('มีเลขออเดอซ้ำในระบบ');
        }

        $order =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
        ->selectRaw('db_orders.customers_user_name,customers.name,customers.last_name,customers.expire_date,customers.qualification_id,sum(db_orders.pv_total) sum_pv_total')
        ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
        ->whereIn('db_orders.type',['other','promotion'])

        ->whereBetween('db_orders.created_at',[$date_start, $date_end])
        ->wherein('order_status_id_fk',[4,5,6,7])
        ->groupby('db_orders.customers_user_name')
        ->get();


        if (count($order) == 0) {
            DB::rollback();
            return redirect('admin/bonus7')->withError('ไม่มีสินค้าในวันที่เลือก');
        }

        try {
            DB::BeginTransaction();

            foreach ($order as $value) {

                $customer = DB::table('customers')->select('id', 'pv', 'user_name', 'introduce_id', 'status_runbonus_allsale')
                    ->where('status_customer', '!=', 'cancel')
                    ->where('user_name', '=', $value->customers_user_name)
                    ->first();

                if ($customer->status_runbonus_allsale == 'pending') {
                    $data = \App\Http\Controllers\Admin\Bonus7Controller::runbonus($value->customers_user_name, $value->sum_pv_total, $i = 0,$value->customers_user_name);
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


            $customers_bonus7_check = DB::table('customers') //อัพ Pv ของตัวเอง
            ->select('customers.*','dataset_qualification.business_qualifications')
            ->where('customers.pv_allsale_permouth','>=',10000)
            ->where('customers.qualification_id','>=',6)
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->get();


            foreach ($customers_bonus7_check as $value) {



                $bonus_total_usd = $value->pv_allsale_permouth*0.07;

                $dataPrepare = [
                    'user_name' => $value->user_name,
                    'name' => $value->name,
                    'last_name' => $value->last_name,
                    'qualification' =>  $value->business_qualifications,
                    'pv' =>  $value->pv_allsale_permouth,
                    'reth' =>  0.07,
                    'bonus_total_usd' => $bonus_total_usd,
                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'note' => $note,
                ];

                DB::table('report_bonus7')
                    ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);

            }

            DB::commit();
            return redirect('admin/bonus7')->withSuccess('Success');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/bonus7')->withError($e);
        }
    }



    public function datatable_bonus7(Request $request)
    {



        $report_cashback = DB::table('report_bonus7')

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

            ->addColumn('pv', function ($row) {
                return $row->pv;
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

            ->make(true);
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
                    $data = \App\Http\Controllers\Admin\Bonus7Controller::runbonus($user->introduce_id, $pv, $i,$userbuy);
                    if ($data['status'] == 'success') {
                        DB::commit();
                        $resule = ['status' => 'success', 'message' => 'สิ้นสุด'];
                        return $resule;
                    } else {

                        \App\Http\Controllers\Admin\Bonus7Controller::runbonus($user->introduce_id, $pv, $i,$userbuy);
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

}
