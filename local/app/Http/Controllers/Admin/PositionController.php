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

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {


        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();

        //   $RunDealer_all = \App\Http\Controllers\Frontend\FC\RunDealerController::RunDealer_all();
        //    dd($RunDealer_all);
          //App\Http\Controllers\Frontend\FC\RunDealerController::RunDealer();

        return view('backend/Position');
    }


    public function run_position(Request $rs)
    {

        $month =  $rs->month;
        $year =  $rs->year;
        $note =  $rs->note;

        // $log_up_vl_delete =  DB::table('log_up_vl')
        // ->where('year',$year)
        // ->where('month',$month)
        // ->delete();

        $customers_all =  DB::table('customers')
        ->select('id', 'pv', 'user_name', 'introduce_id', 'qualification_id','dealer','pv_allsale_permouth')
        ->where('status_customer', '!=', 'cancel')
        ->orderby('id')
        ->get();

          $RunDealer_all = \App\Http\Controllers\Frontend\FC\RunDealerController::RunDealer_all($rs->year,$rs->month);
        //   dd($RunDealer_all);

        try {
            DB::BeginTransaction();
            //log_up_vl
            foreach ($customers_all as $value) {


                $pt_permouth_max = DB::table('customers')
                ->select('id', 'pv', 'user_name', 'introduce_id', 'qualification_id', 'dealer', 'pv_allsale_permouth')
                ->where('introduce_id', '=', $value->user_name)
                ->where('status_customer', '!=', 'cancel')
                ->orderByDesc('pv_allsale_permouth') // เรียงลำดับตาม 'pv_allsale_permouth' จากมากไปน้อย
                ->first();

                if($pt_permouth_max){
                    $pt_permouth_max_customers = $pt_permouth_max->pv_allsale_permouth;

                }else{
                    $pt_permouth_max_customers =  0;

                }

                $pt_permouth_sum_low = DB::table('customers')
                ->selectRaw('SUM(pv_allsale_permouth) as pv_allsale_permouth_sum')
                ->where('introduce_id', '=', $value->user_name)
                ->where('status_customer', '!=', 'cancel')
                ->where('pv_allsale_permouth', '<', function ($query) {
                    $query->select('pv_allsale_permouth')
                        ->from('customers')
                        ->where('status_customer', '!=', 'cancel')
                        ->orderByDesc('pv_allsale_permouth')
                        ->limit(1);
                })
                ->first();

            $pt_permouth_low = $pt_permouth_sum_low->pv_allsale_permouth_sum ?? 0;

            $pv_allsale_permouth = $value->pv_allsale_permouth ?? 0;



                if($value->qualification_id < 10  and $value->dealer >= 18 and $pt_permouth_max_customers >= 300000 and $pt_permouth_low >= 150000){  // CHAIRMAN

                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '10']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>10,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }elseif($value->qualification_id < 9  and $value->dealer >= 10 and $pt_permouth_max_customers >= 100000 and $pt_permouth_low >= 50000){ // ROYAL CROWN DIAMOND


                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '9']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>9,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }elseif($value->qualification_id < 8  and $value->dealer >= 8 and $pt_permouth_max_customers >= 60000 and $pt_permouth_low >= 30000){ // CROWN DIAMOND

                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '8']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>8,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }elseif($value->qualification_id < 7  and $value->dealer >= 6 and $pt_permouth_max_customers >= 30000 and $pt_permouth_low >= 15000){ // MASTER DEALER
                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '7']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>7,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);

                }elseif($value->qualification_id < 6  and $value->dealer >= 4 and $pt_permouth_max_customers >= 10000  and $pt_permouth_low >= 5000){ // PRO DEALER
                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '6']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>6,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);

                }elseif($value->qualification_id < 5  and $value->dealer >= 3 and $pt_permouth_max_customers >= 5000 and $pt_permouth_low >= 2500){ // ULTIMATE DEALER
                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '5']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>5,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }elseif($value->qualification_id < 4  and $value->dealer >= 2 and $pt_permouth_max_customers >= 3000 and $pt_permouth_low >= 1500){// EXCLUSIVE DEALER
                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '4']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>4,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);

                }elseif($value->qualification_id < 3  and $value->pv >= 1000 ){ // DEALER

                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '3']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>3,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);

                }elseif($value->qualification_id < 2  and $value->pv >= 100){// SUPERVISOR

                // $update_position = DB::table('customers')
                //     ->where('user_name', $value->user_name)
                //     ->update(['qualification_id' => '2']);

                $dataPrepare = [
                    'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                    'new_lavel' =>2,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                    'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                    'status' => 'pending'
                ];

                DB::table('log_up_vl')
                    ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }elseif($value->qualification_id < 1  and $value->pv >= 10){// DISTRIBUTOR
                    // $update_position = DB::table('customers')
                    // ->where('user_name', $value->user_name)
                    // ->update(['qualification_id' => '1']);

                    $dataPrepare = [
                        'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                        'new_lavel' =>1,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                        'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                        'status' => 'pending'
                    ];

                    DB::table('log_up_vl')
                        ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                }else{
                    if(($value->qualification_id == null || $value->qualification_id == 0) and $value->pv >= 10  ){
                        // $update_position = DB::table('customers')
                        // ->where('user_name', $value->user_name)
                        // ->update(['qualification_id' => '1']);

                        $dataPrepare = [
                            'user_name' => $value->user_name,'introduce_id' => $value->introduce_id, 'old_lavel' =>$value->qualification_id,
                            'new_lavel' =>1,'pt_customer' => $value->pv, 'pt_customer_group' => $pv_allsale_permouth,
                            'pt_permouth_max' => $pt_permouth_max_customers, 'pt_permouth_low' => $pt_permouth_low, 'dealer'=>$value->dealer,
                            'status' => 'pending'
                        ];

                        DB::table('log_up_vl')
                            ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);


                    }

                }


            }


            DB::commit();
            return redirect('admin/Position')->withSuccess('Success');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/Position')->withError($e);
        }
    }



    public function datatable_position_pending(Request $request)
    {




        $log_up_vl = DB::table('log_up_vl')
        ->select('log_up_vl.*', 'old_lavel.business_qualifications as old_lavel_name', 'new_lavel.business_qualifications as new_lavel_name', 'customers.name', 'customers.last_name')
        ->leftJoin('dataset_qualification as old_lavel', 'old_lavel.code', '=', 'log_up_vl.old_lavel')
        ->leftJoin('dataset_qualification as new_lavel', 'new_lavel.code', '=', 'log_up_vl.new_lavel')
        ->leftJoin('customers', 'customers.user_name', '=', 'log_up_vl.user_name')
        ->where('log_up_vl.status', 'pending')
        ->when($request->username, fn ($query) => $query->where('log_up_vl.user_name', $request->username))
        // ->when($request->month, fn ($query) => $query->where('log_up_vl.month', $request->month))
        // ->when($request->year, fn ($query) => $query->where('log_up_vl.year', $request->year))
        ->orderByDesc('id');



        $sQuery = Datatables::of($log_up_vl);
        return $sQuery


            // ->addColumn('user_name', function ($row) {
            //     return $row->user_name;
            // })

            // ->addColumn('name', function ($row) {
            //     return $row->name;
            // })

            ->addColumn('name', function ($row) {
                return $row->name;
            })

            ->addColumn('last_name', function ($row) {
                return $row->last_name;
            })



            ->make(true);
    }





}
