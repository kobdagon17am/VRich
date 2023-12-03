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


    public function orders_success(Request $request)
    {
        $Shipping_type = Shipping_type::get();

        return view('backend/orders_list_success')
            ->with('Shipping_type', $Shipping_type);
    }


    public function list_stock(Request $request)
    {
        $Shipping_type = Shipping_type::get();

        return view('backend/orders_list_stock')
            ->with('Shipping_type', $Shipping_type);
    }


    public function get_data_order_list(Request $request)
    {
        $code_order = @$request['Custom']['code_order'];

        // $type = @$request['Custom']['type'];

        // dd( $type);

        $date_start = null;

        if (@request('Custom')['date_start']) {
            $date_start = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_start']));
        }
        $date_end = null;
        if (@request('Custom')['date_end']) {
            $date_end = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_end']));
        }
        DB::enableQueryLog();
        $orders = DB::table('db_orders')
            ->select(
                'db_orders.*',
                'dataset_order_status.detail',
                'dataset_order_status.css_class',
            )
            ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', '=', 'db_orders.order_status_id_fk')
            ->leftjoin('customers', 'customers.id', '=', 'db_orders.customers_id_fk')
            ->where('dataset_order_status.lang_id', '=', 1)

            ->where('db_orders.order_status_id_fk', '=', '5')
            ->where('db_orders.sent_stock_type', '=', 'send')
            ->whereRaw(("case WHEN '{$code_order}' != '' THEN  db_orders.code_order = '{$code_order}' else 1 END"))
            //->whereRaw(("case WHEN '{$type}' != '' THEN  db_orders.type = '{$type}' else 1 END"))
            ->where(function ($query) use ($date_start, $date_end) {
                if ($date_start != null && $date_end != null) {
                    $query->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)));
                    $query->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)));
                }
            })

            ->where(function ($query) use ($request) {
                if ($request->has('Where')) {
                    foreach (request('Where') as $key => $val) {
                        if ($val) {
                            if (strpos($val, ',')) {
                                $query->whereIn($key, explode(',', $val));
                            } else {
                                $query->where($key, $val);
                            }
                        }
                    }
                }
                if ($request->has('Like')) {
                    foreach (request('Like') as $key => $val) {
                        if ($val) {
                            $query->where($key, 'like', '%' . $val . '%');
                        }
                    }
                }
            })
            // ->where('db_orders.order_status_id_fk', ['2',])

            // ->whereRaw(("case WHEN '{$request->s_date}' != '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) >= '{$request->s_date}' and date(db_orders.created_at) <= '{$request->e_date}'else 1 END"))
            // ->whereRaw(("case WHEN '{$request->s_date}' = '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) = '{$request->e_date}' else 1 END"))
            ->orderby('db_orders.updated_at', 'DESC');


        // dd($date_start, $date_end);
        return DataTables::of($orders)
            ->setRowClass('intro-x py-4 h-20 zoom-in box ')

            ->editColumn('total_price', function ($query) {
                $price = $query->total_price;
                return  number_format($price, 2) . ' USD';
            })

            // รวม รหัสกับชื่อสมาชิก
            // ->editColumn('customers_user_name', function ($query) {

            //     return   $customers;
            // })
            // ->editColumn('created_at', function ($query) {
            //     $time =  date('d-m-Y h:i', strtotime($query->created_at));
            //     return   $time . ' น';
            // })
            ->make(true);
    }



    public function get_data_order_list_success(Request $request)
    {
        $code_order = @$request['Custom']['code_order'];

        $date_start = null;

        if (@request('Custom')['date_start']) {
            $date_start = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_start']));
        }
        $date_end = null;
        if (@request('Custom')['date_end']) {
            $date_end = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_end']));
        }
        DB::enableQueryLog();
        $orders = DB::table('db_orders')
            ->select(
                'db_orders.*',
                'dataset_order_status.detail',
                'dataset_order_status.css_class',
            )
            ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', '=', 'db_orders.order_status_id_fk')
            ->leftjoin('customers', 'customers.id', '=', 'db_orders.customers_id_fk')
            ->where('dataset_order_status.lang_id', '=', 1)
            ->where('db_orders.order_status_id_fk', '=', '7')

            ->where('db_orders.sent_stock_type', '=', 'send')
            ->whereRaw(("case WHEN '{$code_order}' != '' THEN  date(db_orders.code_order) = '{$code_order}' else 1 END"))
            ->where(function ($query) use ($date_start, $date_end) {
                if ($date_start != null && $date_end != null) {
                    $query->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)));
                    $query->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)));
                }
            })

            ->where(function ($query) use ($request) {
                if ($request->has('Where')) {
                    foreach (request('Where') as $key => $val) {
                        if ($val) {
                            if (strpos($val, ',')) {
                                $query->whereIn($key, explode(',', $val));
                            } else {
                                $query->where($key, $val);
                            }
                        }
                    }
                }
                if ($request->has('Like')) {
                    foreach (request('Like') as $key => $val) {
                        if ($val) {
                            $query->where($key, 'like', '%' . $val . '%');
                        }
                    }
                }
            })
            // ->where('db_orders.order_status_id_fk', ['2',])

            // ->whereRaw(("case WHEN '{$request->s_date}' != '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) >= '{$request->s_date}' and date(db_orders.created_at) <= '{$request->e_date}'else 1 END"))
            // ->whereRaw(("case WHEN '{$request->s_date}' = '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) = '{$request->e_date}' else 1 END"))
            ->orderby('db_orders.updated_at', 'DESC');


        // dd($date_start, $date_end);
        return DataTables::of($orders)
            ->setRowClass('intro-x py-4 h-20 zoom-in box ')

            ->editColumn('total_price', function ($query) {
                $price = $query->total_price;
                return  number_format($price, 2) . ' USD';
            })

            // รวม รหัสกับชื่อสมาชิก
            // ->editColumn('customers_user_name', function ($query) {

            //     return   $customers;
            // })
            // ->editColumn('created_at', function ($query) {
            //     $time =  date('d-m-Y h:i', strtotime($query->created_at));
            //     return   $time . ' น';
            // })
            ->make(true);
    }


    public function get_data_order_list_stock(Request $request)
    {
        $code_order = @$request['Custom']['code_order'];

        $date_start = null;

        if (@request('Custom')['date_start']) {
            $date_start = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_start']));
        }
        $date_end = null;
        if (@request('Custom')['date_end']) {
            $date_end = date('Y-m-d H:i:s', strtotime(@request('Custom')['date_end']));
        }
        DB::enableQueryLog();
        $orders = DB::table('db_orders')
            ->select(
                'db_orders.*',
                'dataset_order_status.detail',
                'dataset_order_status.css_class',
            )
            ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', '=', 'db_orders.order_status_id_fk')
            ->leftjoin('customers', 'customers.id', '=', 'db_orders.customers_id_fk')
            ->where('dataset_order_status.lang_id', '=', 1)
            // ->where('db_orders.order_status_id_fk', '=', '7')

            ->where('db_orders.sent_stock_type', '=', 'add')
            ->whereRaw(("case WHEN '{$code_order}' != '' THEN  date(db_orders.code_order) = '{$code_order}' else 1 END"))
            ->where(function ($query) use ($date_start, $date_end) {
                if ($date_start != null && $date_end != null) {
                    $query->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)));
                    $query->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)));
                }
            })

            ->where(function ($query) use ($request) {
                if ($request->has('Where')) {
                    foreach (request('Where') as $key => $val) {
                        if ($val) {
                            if (strpos($val, ',')) {
                                $query->whereIn($key, explode(',', $val));
                            } else {
                                $query->where($key, $val);
                            }
                        }
                    }
                }
                if ($request->has('Like')) {
                    foreach (request('Like') as $key => $val) {
                        if ($val) {
                            $query->where($key, 'like', '%' . $val . '%');
                        }
                    }
                }
            })
            // ->where('db_orders.order_status_id_fk', ['2',])

            // ->whereRaw(("case WHEN '{$request->s_date}' != '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) >= '{$request->s_date}' and date(db_orders.created_at) <= '{$request->e_date}'else 1 END"))
            // ->whereRaw(("case WHEN '{$request->s_date}' = '' and '{$request->e_date}' != ''  THEN  date(db_orders.created_at) = '{$request->e_date}' else 1 END"))
            ->orderby('db_orders.updated_at', 'DESC');


        // dd($date_start, $date_end);
        return DataTables::of($orders)
            ->setRowClass('intro-x py-4 h-20 zoom-in box ')

            ->editColumn('total_price', function ($query) {
                $price = $query->total_price;
                return  number_format($price, 2) . ' USD';
            })

            // รวม รหัสกับชื่อสมาชิก
            // ->editColumn('customers_user_name', function ($query) {

            //     return   $customers;
            // })
            // ->editColumn('created_at', function ($query) {
            //     $time =  date('d-m-Y h:i', strtotime($query->created_at));
            //     return   $time . ' น';
            // })
            ->make(true);
    }




    public function view_detail_oeder($code_order)
    {
        $orders_detail = DB::table('db_orders')
            ->select(
                'customers.name as customers_name',
                'customers.last_name',
                'dataset_order_status.detail',
                'dataset_order_status.css_class',
                'db_orders.*',
            )
            ->leftjoin('customers', 'customers.id', 'db_orders.customers_id_fk')
            ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', 'db_orders.order_status_id_fk')
            ->where('code_order', $code_order)
            ->get()

            ->map(function ($item) use ($code_order) {
                $item->address = DB::table('db_orders')
                    ->select(
                        'house_no',
                        'house_name',
                        'moo',
                        'soi',
                        'road',
                        'district_name as district',
                        'province_name as province',
                        'tambon_name as tambon',
                        'db_orders.zipcode',
                        'email',
                        'tel',
                    )
                    ->leftjoin('address_districts', 'address_districts.district_id', 'db_orders.district_id')
                    ->leftjoin('address_provinces', 'address_provinces.province_id', 'db_orders.province_id')
                    ->leftjoin('address_tambons', 'address_tambons.tambon_id', 'db_orders.tambon_id')
                    ->GroupBy('house_no')
                    ->where('code_order', $code_order)
                    ->get();
                return $item;
            })

            // เอาข้อมูลสินค้าที่อยู่ในรายการ order
            ->map(function ($item) use ($code_order) {
                $item->product_detail = DB::table('db_order_products_list')
                    ->leftjoin('products_details', 'products_details.product_id_fk', 'db_order_products_list.product_id_fk')
                    ->leftjoin('products_images', 'products_images.product_id_fk', 'db_order_products_list.product_id_fk')
                    ->where('products_details.lang_id', 1)
                    ->where('code_order', $code_order)
                    ->GroupBy('products_details.product_name')
                    ->get();
                return $item;
            })
            // sum total
            ->map(function ($item) use ($code_order) {
                $item->sum_total = DB::table('db_order_products_list')
                    ->where('code_order', $code_order)
                    ->get();
                return $item;
            });




        // return $orders_detail;
        return view('backend/orders_list/view_detail_oeder')
            ->with('orders_detail', $orders_detail);
    }


    public function report_order_pdf($type, $date_start, $date_end)
    {
        $orders_detail = DB::table('db_orders')
            ->select(
                'db_orders.*',
                'dataset_districts.name_th as district',
                'dataset_provinces.name_en as province',
                'dataset_amphures.name_en as tambon',
                'customers.name as customers_name',
                'customers.last_name as customers_last_name',
            )
            ->leftjoin('customers', 'customers.id', 'db_orders.customers_id_fk')


            ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'db_orders.province_id')
            ->leftjoin('dataset_amphures', 'dataset_amphures.id', '=', 'db_orders.tambon_id')
            ->leftjoin('dataset_districts', 'dataset_districts.id', '=', 'db_orders.district_id')


            ->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)))
            ->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)))
            ->where('db_orders.order_status_id_fk', '=', '5')
            ->OrderBy('tracking_no_sort', 'asc')
            ->where(function ($query) use ($type) {
                if ($type != 'all') {
                    $query->where('tracking_type', $type);
                }
            })
            ->get();

        // dd($orders_detail);

        $data = [
            'orders_detail' => $orders_detail,
        ];





        if ($orders_detail->count() > 0) {

            $pdf = PDF::loadView('backend/PDF/report_order_pdf', $data);
            return $pdf->stream('document.pdf');
        } else {
            $status = 'ยังไม่มีรายการสั่งซ์้อ';
            return redirect('admin/orders/list')->withSuccess('Deleted Success');
        }
    }

    public function tracking_no(Request $request)
    {
        $order = Orders::where('code_order', $request->code_order)->first();
        if ($order) {
            $order->tracking_type = $request->tracking_type;
            $order->tracking_no = $request->tracking_no;
            $order->order_status_id_fk = "7";

            $data =  OrderController::order_out_stock($request->order_id, $request->code_order, $request->branch_out_id_fk, $request->warehouse_out_id_fk);

            if ($data['status'] == 'fail') {
                return redirect('admin/orders/list')->withError($data['ms']);
            } else {
                try {
                    DB::beginTransaction();
                    $order->save();
                    DB::commit();
                    return redirect('admin/orders/list')->withSuccess('Update Tracking no Success');
                } catch (Exception $e) {
                    DB::rollback();
                    return redirect('admin/orders/list')->withError('Update Tracking no Success');
                }
            }



            if ($request->page_type == 'success') {
                return redirect('admin/orders/list')->withSuccess('Update Tracking no Success');
            } else {
                return redirect('admin/orders/list')->withSuccess('Update Tracking no Success');
            }
        }
    }

    public function order_out_stock($order_id, $code_order, $branch_id, $warehouse_id, $i = 0)
    {
        $products_list = DB::table('db_order_products_list')
            ->where('code_order', $code_order)
            ->where('stock_status', 'pending')
            ->get();



        if (count($products_list) <= 0) {
            $data = ['status' => 'fail', 'ms' => 'ไม่พบสินค้าในบิล'];
            return $data;
        }



        //check ว่ามีสินค้าให้ตัดไหม
        foreach ($products_list as $value) {

            if ($value->type == 'promotion') {

                $db_stocks = DB::table('db_stocks')
                    ->where('product_id_fk', $value->product_id_fk_promotion)
                    ->where('branch_id_fk', $branch_id)
                    ->where('warehouse_id_fk', $warehouse_id)
                    ->where('stock_balance', '>=', $value->amt_out_stock)
                    ->first();
            } else {


                $db_stocks = DB::table('db_stocks')
                    ->where('product_id_fk', $value->product_id_fk)
                    ->where('branch_id_fk', $branch_id)
                    ->where('warehouse_id_fk', $warehouse_id)
                    ->where('stock_balance', '>=', $value->amt_out_stock)
                    ->first();
            }


            if (empty($db_stocks)) {

                $data = ['status' => 'fail', 'ms' => $value->product_name . ' มีสินค้าไม่พอตัดจ่าย'];
                return $data;
            }
        }


        //สามารถตัดจ่ายสินค้าได้
        try {
            DB::BeginTransaction();


            foreach ($products_list as $value) {


                if ($value->type == 'promotion') {
                    $product_id_fk =  $value->product_id_fk_promotion;
                } else {

                    $product_id_fk =  $value->product_id_fk;
                }


                $db_stocks = DB::table('db_stocks')
                    ->where('product_id_fk', $product_id_fk)
                    ->where('branch_id_fk', $branch_id)
                    ->where('warehouse_id_fk', $warehouse_id)
                    ->where('stock_balance', '>=', $value->amt_out_stock)
                    ->first();




                if (empty($db_stocks)) {
                    $data = ['status' => 'fail', 'ms' => $value->product_name . ' มีสินค้าไม่พอตัดจ่าย'];
                    return $data;
                }

                $db_stock_lot = DB::table('db_stock_lot')
                    ->where('product_id_fk', $product_id_fk)
                    ->where('branch_id_fk', $branch_id)
                    ->where('warehouse_id_fk', $warehouse_id)
                    ->where('lot_balance', '>', 0)
                    ->where('stock_type', 'in')
                    ->where('stock_status', 'confirm')
                    ->orderBy('lot_expired_date')
                    ->get();




                if (count($db_stock_lot) <= 0) {
                    $data = ['status' => 'fail', 'ms' => 'ไม่มี lot สินค้าให้ตัดสินค้า'];
                    return $data;
                }



                //$price_log = $price_total - $gv_price;

                foreach ($db_stock_lot as $value_stock_lot) {

                    $lot_balance =  $value_stock_lot->lot_balance - $value->amt_out_stock;

                    if ($lot_balance >= 0) {
                        $balance = $lot_balance;
                        $updateMovement = [
                            'branch_id_fk' => $branch_id,
                            'warehouse_id_fk' => $warehouse_id,
                            'code_order' => $code_order,

                            'product_id_fk' => $product_id_fk,
                            'stock_lot_id_fk' => $value_stock_lot->id,
                            'lot_number' => $value_stock_lot->lot_number,

                            'lot_balance' => $balance,
                            'amt_balance' => $db_stocks->stock_balance - $value->amt_out_stock,
                            'amt' => $value->amt_out_stock,
                            'in_out' => 'order',
                            'product_unit_id_fk' => $value_stock_lot->product_unit_id_fk,
                            'stock_status' => 'confirm',
                            'create_id_fk' => Auth::guard('admin')->user()->id,
                            'create_name' => Auth::guard('admin')->user()->first_name,
                            'approve_id_fk' => Auth::guard('admin')->user()->id,
                            'approve_name' => Auth::guard('admin')->user()->first_name,
                            'approve_date' => now(),
                        ];



                        DB::table('db_stock_movement')
                            ->insert($updateMovement);

                        $db_stock_lot_update = DB::table('db_stock_lot')
                            ->where('id', $value_stock_lot->id)
                            ->where('stock_type', 'in')
                            ->where('stock_status', 'confirm')
                            ->update(['lot_balance' => $balance]);


                        $db_order_products_list_update = DB::table('db_order_products_list') //จ่ายสินค้าเเล้ว
                            ->where('id', $value->id)
                            ->update(['stock_status' => 'success', 'amt_out_stock' => 0]);


                        $data = ['status' => 'success', 'ms' =>  'success'];


                    } else {

                        //ต้องไปตัด lot อื่นเพิ่ม


                        $balance =  $value->amt_out_stock - $value_stock_lot->lot_balance;
                        $updateMovement = [
                            'branch_id_fk' => $branch_id,
                            'warehouse_id_fk' => $warehouse_id,
                            'code_order' => $code_order,

                            'product_id_fk' => $product_id_fk,
                            'stock_lot_id_fk' => $value_stock_lot->id,
                            'lot_number' => $value_stock_lot->lot_number,

                            'lot_balance' => 0,
                            'amt_balance' => $db_stocks->stock_balance - $value->amt_out_stock,
                            'amt' => $value_stock_lot->lot_balance,
                            'in_out' => 'order',
                            'product_unit_id_fk' => $value_stock_lot->product_unit_id_fk,
                            'product_unit_name' => $value_stock_lot->product_unit_id_fk,
                            'stock_status' => 'confirm',
                            'create_id_fk' => Auth::guard('admin')->user()->id,
                            'create_name' => Auth::guard('admin')->user()->first_name,
                            'approve_id_fk' => Auth::guard('admin')->user()->id,
                            'approve_name' => Auth::guard('admin')->user()->first_name,
                            'approve_date' => now(),
                        ];

                        DB::table('db_stock_movement')
                            ->insert($updateMovement);

                        $db_stock_lot_update = DB::table('db_stock_lot')
                            ->where('id', $value_stock_lot->id)
                            ->where('stock_type', 'in')
                            ->where('stock_status', 'confirm')
                            ->update(['lot_balance' => 0]);

                        $db_order_products_list_update = DB::table('db_order_products_list') //จ่ายสินค้าเเล้ว
                            ->where('id', $value->id)
                            ->update(['amt_out_stock' => $balance]);

                        $rs_data = OrderController::order_out_stock($order_id, $code_order, $branch_id, $warehouse_id, 2);
                        if ($rs_data['status'] == 'success') {
                            $data = ['status' => 'success', 'ms' =>  'success'];



                        } elseif ($rs_data['status'] == 'fail') {

                            $data = ['status' => 'fail', 'message' => $rs_data['ms']];


                        } else {
                            $rs_data = OrderController::order_out_stock($order_id, $code_order, $branch_id, $warehouse_id, 3);
                        }
                    }
                }
            }
            if($data['status'] == 'success'){
                DB::commit();
                return $data;
            }else{
                DB::rollback();
                return $data;
            }


        } catch (Exception $e) {
            DB::rollback();
            $data = ['status' => 'fail', 'message' => $e];
            return $data;
        }
    }


    public function tracking_no_sort(Request $reques)
    {

        $date_start = null;
        $date_end  = null;
        $date_start = $reques->date_start;
        $date_end = $reques->date_end;

        $orders =  DB::table('db_orders')
            ->select('id', 'code_order', 'tracking_type')
            ->whereDate('db_orders.created_at', '>=', date('Y-m-d', strtotime($date_start)))
            ->whereDate('db_orders.created_at', '<=', date('Y-m-d', strtotime($date_end)))
            ->where('db_orders.order_status_id_fk', '=', '5')
            // ->where('tracking_no_sort', null)
            ->OrderBy('id', 'asc')
            ->get();

        $data_orders =   collect($orders)->groupBy('tracking_type');




        foreach ($data_orders as $val_order) {
            foreach ($val_order as $key => $val) {
                $dataPrepare = [
                    'tracking_no_sort' => $key + 1
                ];
                DB::table('db_orders')->where('code_order', $val->code_order)->update($dataPrepare);
            }
        }
    }

    public function orderexport($date_start, $date_end)
    {

        $data = [
            'date_start' => $date_start,
            'date_end' => $date_end,
        ];
        return  Excel::download(new OrderExport($data), 'OrderExport-' . date("d-m-Y") . '.xlsx');
        return redirect('admin/orders/list')->with('success', 'All good!');
    }

    public function importorder(Request $request)
    {
        // Excel::import(new OrderImport, request()->file('excel'));
        // return redirect('admin/orders/list')->with('success', 'All good!');

        $date_validator = [
            'excel' => 'required',


        ];
        $err_validator =            [
            'excel.required' => 'กรุณาแบบไฟล์ excel',

        ];
        $validator = Validator::make(
            $request->all(),
            $date_validator,
            $err_validator
        );

        if (!$validator->fails()) {
            $file = $request->file('excel');
            $import = new OrderImport();
            $import->import($file);

            return $this->checkErrorImport($import);
        }
        return response()->json(['error' => $validator->errors()]);
    }


    public function checkErrorImport($import)
    {
        $checkError = $this->showErrorImport($import);

        if (count($checkError) > 0) {

            return response()->json(['error_excel' => $checkError], 200);
        } else {
            $get_data = $import->getdata();

            foreach ($get_data as $val) {


                $dataPrepare = [
                    'tracking_no' => $val['tracking_no'],
                    'order_status_id_fk' => 7
                ];
                $query  = Orders::where('code_order', $val['code_order'])->update($dataPrepare);
            }


            $res_code_order = [];
            foreach ($get_data as $val) {
                $item = [
                    'code_order' => $val['code_order']
                ];
                array_push($res_code_order, $item);
            }


            $this->get_material($res_code_order);
            return response()->json(['status' => 'success'], 200);
        }
    }

    public function showErrorImport($import)
    {
        $data = $import->failures();
        // dd($data);

        $res = [];
        foreach ($data as $key => $val) {

            $item = [
                'row' => $val->row(),
                'error' => $val->errors()[0],
            ];
            array_push($res, $item);
        }
        return $res;
    }



    public function view_detail_oeder_pdf(Request $reques)
    {



        // ลบไฟล์ PDF ออกทั้งหมดแล้ววาดใหม่
        $file = new Filesystem;
        $file->cleanDirectory(public_path('pdf/'));

        $date_start = null;
        if ($reques->date_start) {
            $date_start = date('Y-m-d', strtotime($reques->date_start));
        }
        $date_end = null;
        if ($reques->date_end) {
            $date_end = date('Y-m-d', strtotime($reques->date_end));
        }

        $arr_code_order = [];
        if ($date_start != null && $date_end != null) {

            $orders_date =  DB::table('db_orders')
                ->select('id', 'code_order', 'tracking_type')
                ->whereDate('db_orders.created_at', '>=', $date_start)
                ->whereDate('db_orders.created_at', '<=', $date_end)
                ->where('db_orders.order_status_id_fk', '=', '5')
                ->OrderBy('tracking_type', 'asc')
                ->get();

            foreach ($orders_date as $val) {
                $dataPrepare = [
                    'code_order' => $val->code_order,
                    'tracking_type' => $val->tracking_type
                ];
                array_push($arr_code_order,  $dataPrepare);
            }
        } else {
            $dataPrepare = [
                'code_order' => $reques->code_order,
                'tracking_type' => 0,
            ];
            array_push($arr_code_order, $dataPrepare);
        }


        // $this->count_print_detail($arr_code_order);


        // $res_orders_detail = [];
        foreach ($arr_code_order as $key => $val) {

            $orders_detail = DB::table('db_orders')
                ->select(
                    'db_orders.name as customers_name',
                    'db_orders.customers_id_fk',
                    'db_orders.code_order',
                    'db_orders.tracking_type',
                    'db_orders.tracking_no_sort',
                    'db_orders.created_at',
                    'db_orders.position',
                    'db_orders.bonus_percent',
                    'db_orders.sum_price',
                    'db_orders.pv_total',
                    'db_orders.shipping_price',
                    'db_orders.discount',
                    'db_orders.ewallet_price',

                )
                ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', 'db_orders.order_status_id_fk')
                ->where('db_orders.code_order', $val['code_order'])
                // ->where('db_orders.order_status_id_fk', '=', '5')
                ->OrderBy('tracking_type', 'asc')

                ->get()

                ->map(function ($item) {
                    $item->address = DB::table('db_orders')
                        ->select(
                            'house_no',
                            'house_name',
                            'moo',
                            'soi',
                            'road',

                            'dataset_districts.name_th as district',
                            'dataset_provinces.name_en as province',
                            'dataset_amphures.name_en as tambon',
                            'db_orders.zipcode',
                            'db_orders.zipcode',
                            'tel',
                        )
                        ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'db_orders.province_id')
                        ->leftjoin('dataset_amphures', 'dataset_amphures.id', '=', 'db_orders.tambon_id')
                        ->leftjoin('dataset_districts', 'dataset_districts.id', '=', 'db_orders.district_id')

                        ->where('code_order', $item->code_order)
                        ->get();


                    return $item;
                })

                // เอาข้อมูลสินค้าที่อยู่ในรายการ order
                ->map(function ($item) {
                    // $item->product_detail = DB::table('db_order_products_list')
                    //     ->select('products_details.product_name', 'amt', 'product_unit')
                    //     ->leftjoin('products_details', 'products_details.product_id_fk', 'db_order_products_list.product_id_fk')
                    //     ->leftjoin('products_images', 'products_images.product_id_fk', 'db_order_products_list.product_id_fk')
                    //     ->leftjoin('products', 'products.id', 'db_order_products_list.product_id_fk')
                    //     ->leftjoin('dataset_product_unit', 'dataset_product_unit.product_unit_id', 'products.unit_id')
                    //     ->where('dataset_product_unit.lang_id', 1)
                    //     ->where('products_details.lang_id', 1)
                    //     ->where('db_order_products_list.code_order', $item->code_order)
                    //     ->GroupBy('products_details.product_name')
                    //     ->get();

                    $item->product_detail = DB::table('db_order_products_list')
                        ->select('db_order_products_list.*', 'dataset_product_unit.product_unit_en as product_unit')
                        ->leftjoin('dataset_product_unit', 'dataset_product_unit.id', 'db_order_products_list.product_unit_id_fk')
                        ->where('code_order', $item->code_order)
                        // ->GroupBy('product_images.product_id_fk')
                        ->get();




                    return $item;
                });



            $data = [
                'orders_detail' => $orders_detail,
            ];

            // return $data;
            // dd($data);

            $number_file = '';
            if ($key <= 9) {
                $number_file  = '00' . $key;
            } else if ($key <= 99) {
                $number_file  = '0' . $key;
            } else {
                $number_file  = $key;
            }



            $pdf = PDF::loadView('backend/PDF/view_detail_oeder_pdf', $data);
            $pathfile = public_path('pdf/' . 'detailproduct_' . $val['tracking_type'] . '_' . $number_file . '.pdf');
            $pdf->save($pathfile);
        }



        $this->merger_pdf();



        return  'result.pdf';

        // $pdf = PDF::loadView('backend/PDF/view_detail_oeder_pdf', $data);
        // return $pdf->stream('document.pdf');
    }

    public function view_detail_oeder_pdf_success(Request $reques)
    {



        // ลบไฟล์ PDF ออกทั้งหมดแล้ววาดใหม่
        $file = new Filesystem;
        $file->cleanDirectory(public_path('pdf/'));

        $date_start = null;
        if ($reques->date_start) {
            $date_start = date('Y-m-d', strtotime($reques->date_start));
        }
        $date_end = null;
        if ($reques->date_end) {
            $date_end = date('Y-m-d', strtotime($reques->date_end));
        }

        $arr_code_order = [];
        if ($date_start != null && $date_end != null) {

            $orders_date =  DB::table('db_orders')
                ->select('id', 'code_order', 'tracking_type')
                ->whereDate('db_orders.created_at', '>=', $date_start)
                ->whereDate('db_orders.created_at', '<=', $date_end)
                // ->where('db_orders.order_status_id_fk', '=', '7')
                ->OrderBy('tracking_type', 'asc')
                ->get();

            foreach ($orders_date as $val) {
                $dataPrepare = [
                    'code_order' => $val->code_order,
                    'tracking_type' => $val->tracking_type
                ];
                array_push($arr_code_order,  $dataPrepare);
            }
        } else {
            $dataPrepare = [
                'code_order' => $reques->code_order,
                'tracking_type' => 0,
            ];
            array_push($arr_code_order, $dataPrepare);
        }

        // dd($arr_code_order);


        // $this->count_print_detail($arr_code_order);


        // $res_orders_detail = [];
        foreach ($arr_code_order as $key => $val) {

            $orders_detail = DB::table('db_orders')
                ->select(
                    'db_orders.name as customers_name',
                    'db_orders.customers_id_fk',
                    'db_orders.code_order',
                    'db_orders.tracking_type',
                    'db_orders.tracking_no_sort',
                    'db_orders.created_at',
                    'db_orders.position',
                    'db_orders.bonus_percent',
                    'db_orders.sum_price',
                    'db_orders.pv_total',
                    'db_orders.shipping_price',
                    'db_orders.discount',
                    'db_orders.ewallet_price',

                )
                ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id', 'db_orders.order_status_id_fk')
                ->where('db_orders.code_order', $val['code_order'])
                // ->where('db_orders.order_status_id_fk', '=', '7')
                ->OrderBy('tracking_type', 'asc')

                ->get()

                ->map(function ($item) {
                    $item->address = DB::table('db_orders')
                        ->select(
                            'house_no',
                            'house_name',
                            'moo',
                            'soi',
                            'road',

                            'dataset_districts.name_th as district',
                            'dataset_provinces.name_en as province',
                            'dataset_amphures.name_en as tambon',
                            'db_orders.zipcode',
                            'db_orders.zipcode',
                            'tel',
                        )
                        ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'db_orders.province_id')
                        ->leftjoin('dataset_amphures', 'dataset_amphures.id', '=', 'db_orders.tambon_id')
                        ->leftjoin('dataset_districts', 'dataset_districts.id', '=', 'db_orders.district_id')

                        ->where('code_order', $item->code_order)
                        ->get();


                    return $item;
                })

                ->map(function ($item) {

                    $item->product_detail = DB::table('db_order_products_list')
                        ->select('db_order_products_list.*', 'dataset_product_unit.product_unit_en as product_unit')
                        ->leftjoin('dataset_product_unit', 'dataset_product_unit.id', 'db_order_products_list.product_unit_id_fk')
                        ->where('code_order', $item->code_order)
                        ->get();

                    return $item;
                });



            $data = [
                'orders_detail' => $orders_detail,
            ];

            // dd($orders_detail);

            // return $data;
            // dd($data);

            $number_file = '';
            if ($key <= 9) {
                $number_file  = '00' . $key;
            } else if ($key <= 99) {
                $number_file  = '0' . $key;
            } else {
                $number_file  = $key;
            }



            $pdf = PDF::loadView('backend/PDF/view_detail_oeder_pdf', $data);
            $pathfile = public_path('pdf/' . 'detailproduct_' . $val['tracking_type'] . '_' . $number_file . '.pdf');
            $pdf->save($pathfile);
        }



        $this->merger_pdf();



        return  'result.pdf';

        // $pdf = PDF::loadView('backend/PDF/view_detail_oeder_pdf', $data);
        // return $pdf->stream('document.pdf');
    }



    public function merger_pdf()
    {

        $pdf = PDFMerger::init();
        $files = scandir(public_path('pdf/'));

        foreach ($files as $val) {


            if ($val != '.' && $val != '..') {

                $pdf->addPDF(public_path('pdf/' . $val), 'all');
            }
        }
        $pdf->merge();
        $fileName = public_path('pdf/' . 'result' . '.pdf');
        // return $pdf->stream();
        $pdf->save(($fileName));
        // $pdf->save(public_path($path_file));
        // $data_image = file_get_contents($path);
    }



    public function count_print_detail($code_order)
    {

        foreach ($code_order as $val) {


            $order[] = DB::table('db_orders')->where('code_order', $val['code_order'])->first();
        }


        foreach ($order as $val) {
            $dataPrepare = [
                'count_print_detail' => $val->count_print_detail + 1
            ];
            $query_update_count_print = DB::table('db_orders')->where('code_order', $val->code_order)->update($dataPrepare);
        }
    }
}
