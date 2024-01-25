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

class BonusController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bonus2()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus2');
    }

    public function bonus2_detail($user_name)
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        return view('backend/bonus2_detail',compact('user_name'));
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


    public function run_bonus2(Request $rs)
    {
        $date_start = $rs->date_start.' 00:00:00';
        $date_end = $rs->date_end.' 23:59:59';
        $route =  $rs->route;
        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;

        $report_cashback_orderlist_rs_delete =  DB::table('report_cashback_orderlist')
        ->where('year',$year)
        ->where('month',$month)
        ->where('route',$route)
        ->delete();


        $report_cashback_delete =  DB::table('report_cashback')
        ->where('year',$year)
        ->where('month',$month)
        ->where('route',$route)
        ->delete();

       $db_orders =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
        ->selectRaw('db_orders.customers_user_name,code_order,count(code_order) as count_code')
        ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
        ->wherein('db_orders.type',['other','promotion'])
        // ->wheredate('customers.expire_date','>=',$date_end)
        ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' = ''  THEN  date(db_orders.created_at) = '{$date_start}' else 1 END"))
        ->whereRaw(("case WHEN '{$date_start}' != '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) >= '{$date_start}' and date(db_orders.created_at) <= '{$date_end}'else 1 END"))
        ->whereRaw(("case WHEN '{$date_start}' = '' and '{$date_end}' != ''  THEN  date(db_orders.created_at) = '{$date_end}' else 1 END"))
        ->havingRaw('count(count_code) > 1 ')
        ->groupby('db_orders.code_order')
        ->get();


        if(count($db_orders)>0){
            DB::rollback();
            return redirect('admin/bonus2')->withError('มีเลขออเดอซ้ำในระบบ');

        }

        $order =  DB::table('db_orders') //รายชื่อคนที่มีรายการแจงโบนัสข้อ
        ->selectRaw('db_orders.code_order,db_orders.customers_user_name,customers.name,customers.last_name,customers.expire_date,customers.qualification_id')
        ->leftjoin('customers', 'db_orders.customers_user_name', '=', 'customers.user_name')
        ->whereIn('db_orders.type',['other','promotion'])
        // ->where('db_orders.customers_user_name','=','VR2400008')
        ->whereBetween('db_orders.created_at', [$date_start, $date_end])
        ->get();


        if(count($order)== 0){
            DB::rollback();
            return redirect('admin/bonus2')->withError('ไม่มีสินค้าในวันที่เลือก');

        }
        $code_order = array();
        foreach($order as $value){
            $code_order[] = $value->code_order;
        }


        $db_order_products_list =  DB::table('db_order_products_list')
        ->selectRaw('
            db_order_products_list.customers_username,
            customers.expire_date,
            customers.qualification_id,
            dataset_qualification.business_qualifications,
            customers.name,
            customers.last_name,
            db_order_products_list.product_id_fk,
            db_order_products_list.product_name,
            db_order_products_list.type,
            SUM(
                CASE
                    WHEN db_order_products_list.type = "other" THEN db_order_products_list.amt
                    WHEN db_order_products_list.type = "promotion" THEN db_order_products_list.amt_pro
                    ELSE 0
                END
            ) as total_amt,
            CASE
            WHEN db_order_products_list.type = "other" THEN db_order_products_list.product_id_fk
            WHEN db_order_products_list.type = "promotion" THEN db_order_products_list.product_id_fk_promotion
            ELSE 0
        END as product_id_fk'
        )
        ->leftJoin('customers', 'db_order_products_list.customers_username', '=', 'customers.user_name')
        ->leftJoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
        ->whereIn('db_order_products_list.code_order', $code_order)
        ->whereIn('db_order_products_list.type',['other', 'promotion'])
        ->groupBy('db_order_products_list.product_id_fk', 'db_order_products_list.customers_username','db_order_products_list.type')
        ->get();


        try {
            DB::BeginTransaction();
            foreach($db_order_products_list as $value){
                if($value->type == 'promotion'){
                    if($value->total_amt >= 2500){
                        $dataset_casback_product = DB::table('dataset_casback_product')
                        ->where('product_id', '=', $value->product_id_fk)
                        ->where('amt', '<=', $value->total_amt)
                        ->whereRaw('amt = (SELECT MAX(amt) FROM dataset_casback_product WHERE amt <= ?)', [$value->total_amt])
                        ->first();

                        $dataset_casback_product_pro = DB::table('dataset_casback_product')
                        ->where('product_id', '=', $value->product_id_fk)
                        ->where('amt', '<=', 1000)
                        ->whereRaw('amt = (SELECT MAX(amt) FROM dataset_casback_product WHERE amt <= ?)', 1000)
                        ->first();


                        if($dataset_casback_product){
                            $profit_usd = $dataset_casback_product_pro->price_usd - $dataset_casback_product->price_usd;
                        }else{
                            $profit_usd = 0;
                        }


                        $dataPrepare = [
                            'user_name' => $value->customers_username,
                            'name'=>$value->name,
                            'last_name' =>$value->last_name,
                            'qualification' =>  $value->business_qualifications,
                            'product_name' =>  $value->product_name,
                            'product_id' =>  $value->product_id_fk,
                            'amt' =>  $value->total_amt,
                            'profit_usd' =>  $profit_usd,
                            'bonus_total_usd' =>  $value->total_amt*$profit_usd,
                            'date_start' =>  $date_start,
                            'date_end' =>  $date_end,
                            'year' => $year,
                            'month' => $month,
                            'route'=>$route,
                            'type'=>$value->type,
                            'note'=>$note,
                        ];

                            DB::table('report_cashback_orderlist')
                                ->updateOrInsert(['user_name' => $value->customers_username,'product_id'=>$value->product_id_fk,'type'=>$value->type, 'year' => $year,'month'=>$month,'route'=>$route],$dataPrepare);

                    }

                }else{
                    $dataset_casback_product = DB::table('dataset_casback_product')
                    ->where('product_id', '=', $value->product_id_fk)
                    ->where('amt', '<=', $value->total_amt)
                    ->whereRaw('amt = (SELECT MAX(amt) FROM dataset_casback_product WHERE amt <= ?)', [$value->total_amt])
                    ->first();

                    if($dataset_casback_product){
                        $profit_usd = $dataset_casback_product->profit_usd;
                    }else{
                        $profit_usd = 0;
                    }


                    $dataPrepare = [
                        'user_name' => $value->customers_username,
                        'name'=>$value->name,
                        'last_name' =>$value->last_name,
                        'qualification' =>  $value->business_qualifications,
                        'product_name' =>  $value->product_name,
                        'product_id' =>  $value->product_id_fk,
                        'amt' =>  $value->total_amt,
                        'profit_usd' =>  $profit_usd,
                        'bonus_total_usd' =>  $value->total_amt*$profit_usd,
                        'date_start' =>  $date_start,
                        'date_end' =>  $date_end,
                        'year' => $year,
                        'month' => $month,
                        'route'=>$route,
                        'type'=>$value->type,
                        'note'=>$note,
                    ];


                        DB::table('report_cashback_orderlist')
                            ->updateOrInsert(['user_name' => $value->customers_username,'product_id'=>$value->product_id_fk,'type'=>$value->type, 'year' => $year,'month'=>$month,'route'=>$route],$dataPrepare);

                }


            }

            $report_cashback_orderlist_rs =  DB::table('report_cashback_orderlist')
            ->selectRaw('report_cashback_orderlist.user_name,name,last_name,qualification,sum(bonus_total_usd) as bonus_total_usd')
            ->where('year',$year)
            ->where('month',$month)
            ->where('route',$route)
            ->where('bonus_total_usd','>',0)
            ->groupby('user_name')
            ->get();

            if(count($report_cashback_orderlist_rs)== 0){
                DB::rollback();
                return redirect('admin/bonus2')->withError('ไม่มีไครได้รับยอดเงินในรอบนี้');
            }
            foreach($report_cashback_orderlist_rs as $value){

                $dataPrepare = [
                    'user_name' => $value->user_name,
                    'name'=>$value->name,
                    'last_name' =>$value->last_name,
                    'qualification' =>  $value->qualification,
                    'bonus_total_usd' =>  $value->bonus_total_usd,
                    'date_start' =>  $date_start,
                    'date_end' =>  $date_end,
                    'year' => $year,
                    'month' => $month,
                    'route'=>$route,
                    'note'=>$note,
                ];

                DB::table('report_cashback')
                ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year,'month'=>$month,'route'=>$route],$dataPrepare);

            }
            DB::commit();
                return redirect('admin/bonus2')->withSuccess('Success');
        }catch (Exception $e) {
            DB::rollback();
            return redirect('admin/bonus2')->withError($e);
        }



    }




    public function datatable_casback(Request $request)
    {



        $report_cashback = DB::table('report_cashback')

        ->whereRaw(("case WHEN  '{$request->username}' != ''  THEN  user_name = '{$request->username}' else 1 END"))
        ->whereRaw(("case WHEN  '{$request->route}' != ''  THEN  route = '{$request->route}' else 1 END"))
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

          ->addColumn('date_start', function ($row) {
            return $row->date_start;
          })

          ->addColumn('date_end', function ($row) {
            return $row->date_end;
          })

          ->addColumn('year', function ($row) {
            return $row->year;
          })

          ->addColumn('route', function ($row) {
            return $row->route;
          })

          ->addColumn('status', function ($row) {
            return $row->status;
          })


          ->addColumn('note', function ($row) {
            return $row->note;
          })
          ->addColumn('detail', function ($row) {
            $url = route('admin/bonus2_detail',['user_name'=>$row->user_name]);
            $detail = '<a href="'.$url.'" target="_blank"> <i class="las la-search font-25 text-warning" ></i> </a>';
            return $detail;
          })



          ->rawColumns(['detail'])

          ->make(true);
      }

      public function datatable_casback_detail(Request $request)
      {



          $report_cashback = DB::table('report_cashback_orderlist')

          ->whereRaw(("case WHEN  '{$request->username}' != ''  THEN  user_name = '{$request->username}' else 1 END"))
          ->whereRaw(("case WHEN  '{$request->route}' != ''  THEN  route = '{$request->route}' else 1 END"))
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

            ->addColumn('date_start', function ($row) {
              return $row->date_start;
            })

            ->addColumn('date_end', function ($row) {
              return $row->date_end;
            })

            ->addColumn('year', function ($row) {
              return $row->year;
            })




            ->addColumn('route', function ($row) {
              return $row->route;
            })



            ->addColumn('note', function ($row) {
              return $row->note;
            })
            ->addColumn('detail', function ($row) {
              $url = route('admin/bonus2_detail',['user_name'=>$row->user_name]);
              $detail = '<a href="'.$url.'" target="_blank"> <i class="las la-search font-25 text-warning" ></i> </a>';
              return $detail;
            })



            ->rawColumns(['detail'])

            ->make(true);
        }









}
