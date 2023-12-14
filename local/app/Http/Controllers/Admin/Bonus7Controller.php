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


        $db_orders =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('db_orders.customers_user_name,code_order,count(code_order) as count_code')
            ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
            ->where('db_orders.type', '=', 'other')
            ->wheredate('customers.expire_date', '>=', $date_end)
            ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' = ''  THEN  date(db_orders.created_at) = '{$date_start}' else 1 END"))
            ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) >= '{$date_start}' and date(db_orders.created_at) <= '{$date_end}'else 1 END"))
            ->whereRaw(("case WHEN '{$date_start}' = '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) = '{$date_end}' else 1 END"))
            ->havingRaw('count(count_code) > 1 ')

            ->groupby('db_orders.code_order')
            ->get();


        if (count($db_orders) > 0) {
            DB::rollback();
            return redirect('admin/pv_per_month')->withError('มีเลขออเดอซ้ำในระบบ');
        }
        $order =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('db_orders.customers_user_name,customers.reward,customers.name,customers.last_name,customers.expire_date,
            dataset_qualification.business_qualifications,customers.qualification_id,sum(db_orders.pv_total) sum_pv_total')
            ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('db_orders.type', '=', 'other')
            ->where('customers.qualification_id', '>=', 3)
            ->havingRaw('sum_pv_total >= 10000')
            ->whereBetween('db_orders.created_at', [$date_start, $date_end])
            ->wherein('order_status_id_fk', [4, 5, 6, 7])
            ->groupby('db_orders.customers_user_name')
            ->get();




        if (count($order) == 0) {
            DB::rollback();
            return redirect('admin/bonus7')->withError('ไม่มีสินค้าในวันที่เลือก');
        }

        try {
            DB::BeginTransaction();


            foreach ($order as $value) {
                if ($value->qualification_id >= 3) {
                    if ($value->sum_pv_total >= 10000) {
                        $bonus_total_usd = $value->sum_pv_total * 0.07;
                    } else {
                        $bonus_total_usd = 0;
                    }
                } else {
                    $bonus_total_usd = 0;
                }

                $dataPrepare = [
                    'user_name' => $value->customers_user_name,
                    'name' => $value->name,
                    'last_name' => $value->last_name,
                    'qualification' =>  $value->business_qualifications,
                    'pv' =>  $value->sum_pv_total,
                    'reth' =>  0.07,
                    'bonus_total_usd' =>   $bonus_total_usd,

                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'note' => $note,
                ];


                DB::table('report_bonus7')
                    ->updateOrInsert(['user_name' => $value->customers_user_name, 'year' => $year, 'month' => $month], $dataPrepare);
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

}
