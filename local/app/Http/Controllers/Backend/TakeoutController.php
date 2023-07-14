<?php

namespace App\Http\Controllers\Backend;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Matreials;
use App\Admin;
use App\Products;
use App\ProductsUnit;
use App\Stock;
use App\StockMovement;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TakeoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    public function index(Request $request)
    {

        // สาขา
        $branch = Branch::where('status', 1)->get();

        $product = DB::table('products')
        ->select(
            'products.id',
            'products_details.product_name',
        )
            ->leftjoin('products_details', 'products.id', 'products_details.product_id_fk')
            ->get();
            $y = date('Y');
            $code =  IdGenerator::generate([
                'table' => 'db_stock_movement',
                'field' => 'doc_no',
                'length' => 12,
                'prefix' => 'WHO'.$y.''.date("m"),
                'reset_on_prefix_change' => true
            ]);


        return view('backend/stock/takeout/index')
        ->with('product', $product)
        ->with('code', $code)
            ->with('branch', $branch); //สาขา

    }



    public function get_data_takeout(Request $request)
    {
        $data = StockMovement::orderBy('updated_at', 'DESC')
            ->where('in_out', '2')
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
            ->get();


        return DataTables::of($data)
            ->setRowClass('intro-x py-4 h-20 zoom-in box')

            // ดึงข้อมูลสามขา branch จาก branch_id_fk
            ->editColumn('branch_id_fk', function ($query) {
                $branch =  Branch::select('b_code', 'b_name')->where('id', $query->branch_id_fk)->first();
                $text_branch =   $branch['b_code'] . ":" . $branch['b_name'];
                return  $text_branch;
            })


            // ดึงข้อมูล สินค้า จาก id

            ->editColumn('product_id_fk', function ($query) {
                $product = DB::table('products_details')
                ->select(
                    'products_details.product_name',
                )
                ->where('product_id_fk',$query->product_id_fk)
                ->first();
                if($product){
                    return $product->product_name;
                }else{
                    return '';
                }




            })

            // ดึงข้อมูล หน่วยนับของสินค้า
            // ->editColumn('amt', function ($query) {
            //     $product_unit = ProductsUnit::select('product_unit')->where('id', $query->product_unit_id_fk)->first();
            //     $text_amt  = $query->amt . ' ' . $product_unit['product_unit'];
            //     return $text_amt;
            // })

            // วันที่ หมดอายุ date_in_stock แปลงเป็น d-m-y
            ->editColumn('lot_expired_date', function ($query) {
                $time =  date('d-m-Y', strtotime($query->lot_expired_date));
                return   $time;
            })

            // ดึงข้อมูล คลังที่จัดเก็บ
            ->editColumn('warehouse_id_fk', function ($query) {
                $warehouse = Warehouse::select('w_code', 'w_name')->where('id', $query->warehouse_id_fk)->first();
                $text_warehouse =   $warehouse['w_code'] . ":" . $warehouse['w_name'];
                return   $text_warehouse;
            })

            // วันที่รับเข้าสินค้า แปลงเป็น d-m-y
            ->editColumn('created_at', function ($query) {
                $time =  date('d-m-Y H:i:s', strtotime($query->created_at));
                return   $time;
            })

            // ดึงข้อมูล member จาก id
            ->editColumn('action_user', function ($query) {
                $member = Admin::where('id', $query->action_user)->select('name')->first();


                return   $member['name'];
            })
            ->make(true);
    }



    public function get_data_warehouse_select(Request $request)
    {

        $warehouse = Warehouse::where('branch_id_fk', $request->id)->where('status', 1)->get();
        return response()->json($warehouse);
    }

    public function get_data_matereials(Request $request)
    {

        // สินค้า
        $matereials = Stock::select('db_stocks.id','products_details.product_id_fk', 'products_details.product_name', 'db_stocks.amt')
            ->where('db_stocks.amt', '>', 0)
            ->where('db_stocks.warehouse_id_fk', $request->warehouse_id_fk)
            ->Leftjoin('products_details', 'products_details.product_id_fk', 'db_stocks.product_id_fk')
            ->get();


        return response()->json($matereials);
    }


    public function get_data_product_select(Request $request)
    {
        $id =  $request->id;

        $product = Stock::select('db_stocks.product_id_fk', 'products_details.product_name')
            ->leftjoin('products_details', 'products_details.product_id_fk', 'db_stocks.product_id_fk')
            ->where('warehouse_id_fk', $id)
            // ->GroupBy('db_stocks.id')
            ->get();


        return response()->json($product);
    }

    public function get_lot_number_takeout(Request $request)
    {
        // dd($request->all());
        $query = Stock::select('lot_number')
        ->where('product_id_fk', $request->product_id_fk)
        ->where('warehouse_id_fk', $request->warehouse_id_fk)
            // ->groupBy('lot_number')
            ->get();
        return response()->json($query);
    }

    public function get_lot_expired_date(Request $request)
    {
        $query = Stock::select('lot_expired_date','id')->where('lot_number', $request->lot_number)->get();
        $arr_query = [];

        foreach ($query as $val) {
            $arr_query[] = [
                'lot_expired_date' => date('d-m-Y', strtotime($val['lot_expired_date'])),
                'id' => $val->id
            ];
        }

        return response()->json($arr_query);
    }

    public function get_max_input_atm_takeout(Request $request)
    {


        $max_atm = Stock::where('id', $request->stock_id_fk)->first();

        return  response()->json($max_atm);
    }


    public function takeout_product(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'branch_id_fk' => 'required',
                'warehouse_id_fk' => 'required',
                'product_id_fk' => 'required',
                'lot_number' => 'required',
                'lot_expired_date' => 'required',
                'amt' => 'required',
                // 'product_unit_id_fk' => 'required',
                'doc_no' => 'required',
                'doc_date' => 'required',

            ],
            [
                'branch_id_fk.required' => 'กรุณาเลือกสาขา',
                'warehouse_id_fk.required' => 'กรุณาเลือกคลัง',
                'materials_id_fk.required' => 'กรุณาเลือกสินค้า',
                'lot_number.required' => 'กรุณากรอกข้อมูล',
                'lot_expired_date.required' => 'กรุณากรอกข้อมูล',
                'amt.required' => 'กรุณากรอกข้อมูล',
                'doc_no.required' => 'กรุณากรอกข้อมูล',
                'doc_date.required' => 'กรุณากรอกข้อมูล',
                // 'product_unit_id_fk.required' => 'กรุณาเลือกหน่วยนับ',

            ]
        );

        if (!$validator->fails()) {
            $data = $request->all();

            $dataPrepareStock = [
                'branch_id_fk' => $request->branch_id_fk,
                'product_id_fk' => $request->product_id_fk,
                'lot_number' => $request->lot_number,
                'lot_expired_date' =>  date('Y-m-d', strtotime($request->lot_expired_date)),
                'warehouse_id_fk' => $request->warehouse_id_fk,
                'amt' => $request->amt,
                'product_unit_id_fk' => $request->product_unit_id_fk,
                'date_in_stock' => date('Y-m-d'),
                's_maker' => Auth::guard('admin')->user()->id,
                'business_location_id_fk' => 1,
            ];

            $dataPrepareStockMovement = [
                'branch_id_fk' => $request->branch_id_fk,
                'product_id_fk' => $request->product_id_fk,
                'lot_number' => $request->lot_number,
                'lot_expired_date' =>  date('Y-m-d', strtotime($request->lot_expired_date)),
                'warehouse_id_fk' => $request->warehouse_id_fk,
                'amt' => $request->amt,
                'product_unit_id_fk' => $request->product_unit_id_fk,
                'action_date' => date('Y-m-d'),
                'action_user' => Auth::guard('admin')->user()->id,
                'business_location_id_fk' => 1,
                'doc_no' => $request->doc_no,
                'doc_date' => $request->doc_date,
                'in_out' => 2
            ];


            // ถ้ามีสินค้าในระบบแล้วจะเป็นการ อัพเดท จำนวนทับกับตัวเก่าที่มีใน stock
            // stock_movement จะเป็นการสร้างใหม่ทุกครั้ง
            $data_check = Stock::where('branch_id_fk', $request->branch_id_fk)
                ->where('product_id_fk', $request->product_id_fk)
                ->where('warehouse_id_fk', $request->warehouse_id_fk)
                ->where('lot_number', $request->lot_number)
                ->where('lot_expired_date',  date('Y-m-d', strtotime($request->lot_expired_date)))
                ->first();

            if ($data_check) {
                $query = Stock::where('id', $data_check->id)->first();

                $data_amt = [
                    'amt' => $query->amt - $request->amt
                ];
                $query->update($data_amt);
            } else {

                $query = Stock::create($dataPrepareStock);
            }


            $query = StockMovement::create($dataPrepareStockMovement);
            return response()->json(['status' => 'success'], 200);
        }
        return response()->json(['error' => $validator->errors()]);
    }
}
