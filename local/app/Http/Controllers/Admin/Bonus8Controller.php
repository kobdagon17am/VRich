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

class Bonus8Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bonus8()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus8');
    }

    public function run_bonus8(Request $rs)
    {

        $date_start = $rs->date_start . ' 00:00:00';
        $date_end = $rs->date_end . ' 23:59:59';
        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;

        $report_bonus8 =  DB::table('report_bonus8')
        ->where('year',$year)
        ->where('month',$month)
        ->delete();

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
            return redirect('admin/bonus8')->withError('มีเลขออเดอซ้ำในระบบ');
        }

        $total_price =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
            ->selectRaw('sum(db_orders.sum_price) sum_price')
            ->where('db_orders.type', '!=', 'send_stock')
            ->whereBetween('db_orders.created_at', [$date_start, $date_end])
            ->wherein('order_status_id_fk', [4, 5, 6, 7])
            ->first();

                 if($total_price){
                    $sum_price = $total_price->sum_price;
                }else{
                    $sum_price = 0;
                }


        if ($sum_price <= 0) {
            DB::rollback();
            return redirect('admin/bonus8')->withError('ไม่มีสินค้าในวันที่เลือก');
        }

        try {
            DB::BeginTransaction();

            $sum_bonus8_reth = DB::table('customers')
            ->selectRaw('sum(dataset_qualification.bonus8_reth) sum_bonus8_reth')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('customers.qualification_id', '>=', 7)
            // ->wheredate('customers.expire_date', '>=', $date_end)
            ->first();



            if($sum_bonus8_reth){
                $sum_bonus8_reth_all = $sum_bonus8_reth->sum_bonus8_reth;
                $sum_price_per_person = ($sum_price*0.01)/$sum_bonus8_reth->sum_bonus8_reth;
            }else{
                $sum_bonus8_reth_all = 0;
                $sum_price_per_person = 0;
            }

            $get_member_data = DB::table('customers')
            ->selectRaw('customers.user_name,customers.reward,customers.name,customers.last_name,customers.expire_date,
            dataset_qualification.business_qualifications,customers.qualification_id,dataset_qualification.bonus8_reth')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('customers.qualification_id', '>=', 7)
            // ->wheredate('customers.expire_date', '>=', $date_end)
            ->get();

            foreach($get_member_data as $value){
                $dataPrepare = [
                    'user_name' => $value->user_name,
                    'name' => $value->name,
                    'last_name' => $value->last_name,
                    'qualification' =>  $value->business_qualifications,
                    'order_price_total' =>$sum_price,
                    'order_price_total_onepercen' =>$sum_price*0.01,
                    'order_price_avg' =>$sum_price_per_person,
                    'reth_all' =>  $sum_bonus8_reth_all,
                    'reth' =>  $value->bonus8_reth,
                    'bonus_total_usd' => $sum_price_per_person*$value->bonus8_reth,
                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'note' => $note,
                ];


                DB::table('report_bonus8')
                    ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);
            }

            DB::commit();
            return redirect('admin/bonus8')->withSuccess('Success');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/bonus8')->withError($e);
        }
    }



    public function datatable_bonus8(Request $request)
    {



        $report_cashback = DB::table('report_bonus8')

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

            ->addColumn('order_price_total', function ($row) {
                return $row->order_price_total;
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
