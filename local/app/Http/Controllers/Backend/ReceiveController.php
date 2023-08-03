<?php

namespace App\Http\Controllers\Backend;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Matreials;
use App\Admin;
use App\Products;
use App\ProductsUnit;
use App\Stock;
use App\Stock_lot;
use App\StockMovement;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReceiveController extends Controller
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
            ->select('products.id', 'products_details.product_name')
            ->leftjoin(
                'products_details',
                'products.id',
                'products_details.product_id_fk'
            )
            ->get();

        $y = date('Y');

        $code = IdGenerator::generate([
            'table' => 'db_stock_movement',
            'field' => 'doc_no',
            'length' => 12,
            'prefix' => 'WHO' . $y . '' . date('m'),
            'reset_on_prefix_change' => true,
        ]);

        $pro_unit = ProductsUnit::all()
            ->where('product_unit_id', '=', '4')
            ->where('status', '=', '1')
            ->where('lang_id', '=', '2');

        return view('backend/stock/receive/index')
            ->with('branch', $branch) //สาขา
            ->with('code', $code)
            ->with('pro_unit', $pro_unit)
            ->with('product', $product); //สินค้า
    }

    public function get_data_receive(Request $request)
    {
        $data = Stock_lot::orderBy('updated_at', 'DESC')

            ->where('status', '=', 'pending')
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
            });
        //->get();




        return DataTables::of($data)
            ->setRowClass('intro-x py-4 h-20 zoom-in box')

            // ดึงข้อมูลสามขา branch จาก branch_id_fk
            ->editColumn('branch_id_fk', function ($query) {
                $branch = Branch::select('b_code', 'b_name')
                    ->where('id', $query->branch_id_fk)
                    ->first();
                if ($branch) {
                    $text_branch = $branch['b_code'] . ':' . $branch['b_name'];
                    return $text_branch;
                } else {
                    return '';
                }
            })

            ->editColumn('product_id_fk', function ($query) {
                $product = DB::table('products_details')
                    ->select('products_details.product_name')
                    ->where('product_id_fk', $query->product_id_fk)
                    ->first();
                if ($product) {
                    return $product->product_name;
                } else {
                    return '';
                }
            })
            // // ดึงข้อมูล หน่วยนับของสินค้า
            // ->editColumn('amt', function ($query) {
            //     $product_unit = ProductsUnit::select('product_unit')->where('id', $query->product_unit_id_fk)->first();
            //     $text_amt  = $query->amt . ' ' . $product_unit['product_unit'];
            //     return $text_amt;
            // })
            // วันที่ หมดอายุ date_in_stock แปลงเป็น d-m-y
            ->editColumn('lot_expired_date', function ($query) {
                $time = date('d-m-Y', strtotime($query->lot_expired_date));
                return $time;
            })
            ->editColumn('doc_date', function ($query) {
                $time = date('d-m-Y', strtotime($query->doc_date));
                return $time;
            })

            // ดึงข้อมูล คลังที่จัดเก็บ
            ->editColumn('warehouse_id_fk', function ($query) {
                $warehouse = Warehouse::select('w_code', 'w_name')
                    ->where('id', $query->warehouse_id_fk)
                    ->first();
                $text_warehouse =
                    $warehouse['w_code'] . ':' . $warehouse['w_name'];
                return $text_warehouse;
            })

            // วันที่รับเข้าสินค้า แปลงเป็น d-m-y
            ->editColumn('created_at', function ($query) {
                $time = date('d-m-Y H:i:s', strtotime($query->created_at));
                return $time;
            })

            // ดึงข้อมูล member จาก id
            ->editColumn('action_user', function ($query) {
                $member = Admin::where('id', $query->action_user)
                    ->select('name')
                    ->first();
                if ($member) {
                    return $member->name;
                } else {
                    return '';
                }
            })
            // data-tw-toggle="modal" data-tw-target="#edit_position"
            ->editColumn('action', function ($query) {

                $html = '
                <a onclick="confirm_stock(' . $query->id . ')" data-tw-toggle="modal" data-tw-target="#add_product_confirm" class="btn btn-sm btn-success mr-2 text-white">
                <i class="fa-solid fa-magnifying-glass"></i>  อนุมัติรายการ </a>
                ';
                return $html;
            })
            ->make(true);
    }


    public function view_confirm_add_stock(Request $request)
    {
    }

    public function get_data_receive_confirm(Request $request)
    {
        $data = StockMovement::orderBy('updated_at', 'DESC')
            ->where('in_out', '1')
            ->where('status', 0)
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
                $branch = Branch::select('b_code', 'b_name')
                    ->where('id', $query->branch_id_fk)
                    ->first();
                $text_branch = $branch['b_code'] . ':' . $branch['b_name'];
                return $text_branch;
            })

            ->editColumn('product_id_fk', function ($query) {
                $product = DB::table('products_details')
                    ->select('products_details.product_name')
                    ->where('product_id_fk', $query->product_id_fk)
                    ->first();
                if ($product) {
                    return $product->product_name;
                } else {
                    return '';
                }
            })
            // // ดึงข้อมูล หน่วยนับของสินค้า
            // ->editColumn('amt', function ($query) {
            //     $product_unit = ProductsUnit::select('product_unit')->where('id', $query->product_unit_id_fk)->first();
            //     $text_amt  = $query->amt . ' ' . $product_unit['product_unit'];
            //     return $text_amt;
            // })
            // วันที่ หมดอายุ date_in_stock แปลงเป็น d-m-y
            ->editColumn('lot_expired_date', function ($query) {
                $time = date('d-m-Y', strtotime($query->lot_expired_date));
                return $time;
            })
            ->editColumn('doc_date', function ($query) {
                $time = date('d-m-Y', strtotime($query->doc_date));
                return $time;
            })

            // ดึงข้อมูล คลังที่จัดเก็บ
            ->editColumn('warehouse_id_fk', function ($query) {
                $warehouse = Warehouse::select('w_code', 'w_name')
                    ->where('id', $query->warehouse_id_fk)
                    ->first();
                $text_warehouse =
                    $warehouse['w_code'] . ':' . $warehouse['w_name'];
                return $text_warehouse;
            })

            // วันที่รับเข้าสินค้า แปลงเป็น d-m-y
            ->editColumn('created_at', function ($query) {
                $time = date('d-m-Y H:i:s', strtotime($query->created_at));
                return $time;
            })

            // ดึงข้อมูล member จาก id
            ->editColumn('action_user', function ($query) {
                $member = Admin::where('id', $query->action_user)
                    ->select('name')
                    ->first();
                return $member['name'];
            })
            ->make(true);
    }

    public function get_data_warehouse_select(Request $request)
    {
        $warehouse = Warehouse::where('branch_id_fk', $request->id)
            ->where('status', 1)
            ->get();
        return response()->json($warehouse);
    }

    public function get_data_product_unit(Request $request)
    {
        $product_id = $request->product_id;

        $product_unit = Products::select(
            'dataset_product_unit.product_unit',
            'products_details.product_id_fk',
            'dataset_product_unit.id'
        )
            ->join(
                'products_details',
                'products_details.product_id_fk',
                'products.id'
            )
            ->join(
                'dataset_product_unit',
                'dataset_product_unit.product_unit_id',
                'products.unit_id'
            )
            ->where('products.id', $product_id)
            ->first();

        return response()->json($product_unit);
    }
    public function get_data_product_select(Request $request)
    {
        $id = $request->id;

        $product = Stock::select(
            'products_details.product_id_fk',
            'products_details.product_name'
        )
            ->join(
                'products_details',
                'products_details.product_id_fk',
                'db_stocks.product_id_fk'
            )
            ->where('warehouse_id_fk', $id)
            ->GroupBy('product_id_fk')
            ->get();

        return response()->json($product);
    }

    public function store_product(Request $request)
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
                'product_id_fk.required' => 'กรุณาเลือกสินค้า',
                'lot_number.required' => 'กรุณากรอกข้อมูล',
                'lot_expired_date.required' => 'กรุณากรอกข้อมูล',
                'amt.required' => 'กรุณากรอกข้อมูล',
                'doc_no.required' => 'กรุณากรอกข้อมูล',
                'doc_date.required' => 'กรุณากรอกข้อมูล',
                // 'product_unit_id_fk.required' => 'กรุณาเลือกหน่วยนับ',
            ]
        );

        if (!$validator->fails()) {


            try {
                DB::BeginTransaction();

                $Stock = new Stock_lot();
                // $StockMovement =new StockMovement();

                $pro_unit_data = ProductsUnit::all()
                    ->where('status', '=', '1')
                    ->where('lang_id', '=', '1')
                    ->where('product_unit_id', '=', $request->unit)
                    ->first();
                $Stock->branch_id_fk = $request->branch_id_fk;
                $Stock->product_id_fk = $request->product_id_fk;
                $Stock->lot_number = $request->lot_number;
                $Stock->lot_expired_date = $request->lot_expired_date;
                $Stock->warehouse_id_fk = $request->warehouse_id_fk;
                $Stock->amt = $request->amt;
                $Stock->product_unit_id_fk = $request->unit;
                $Stock->product_unit_name = $pro_unit_data->product_unit;
                $Stock->doc_date = $request->doc_date;
                //   $Stock->date_in_stock = date('Y-m-d');
                $Stock->action_user = Auth::guard('admin')->user()->id;
                $Stock->action_user_name = Auth::guard('admin')->user()->name . ' ' . Auth::guard('admin')->user()->last_name;
                $Stock->type = 'add';
                $Stock->business_location_id_fk = 1;
                $Stock->save();

                $file = $request->file;

                if (isset($file)) {

                    $url = 'local/public/files_warehouse/' . date('Ym');
                    $f_name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
                    if ($file->getClientOriginalExtension() == 'pdf') {
                        $type = 'pdf';
                    } else {
                        $type = 'img';
                    }

                    if ($file->move($url, $f_name)) {
                        DB::table('db_stock_doc')->insert([
                            'stock_id_fk' => $Stock->id,
                            'warehouse_id_fk' => $request->warehouse_id_fk,
                            'url' => $url,
                            'doc_name' => $f_name,
                            'type' => $type,
                        ]);
                    }
                }
                DB::commit();
                return response()->json(['status' => 'success'], 200);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['error' => $validator->errors()]);
            }
        }


        return response()->json(['error' => $validator->errors()]);
    }


    // public function store_product(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'branch_id_fk' => 'required',
    //             'warehouse_id_fk' => 'required',
    //             'product_id_fk' => 'required',
    //             'lot_number' => 'required',
    //             'lot_expired_date' => 'required',
    //             'amt' => 'required',
    //             // 'product_unit_id_fk' => 'required',
    //             'doc_no' => 'required',
    //             'doc_date' => 'required',
    //         ],
    //         [
    //             'branch_id_fk.required' => 'กรุณาเลือกสาขา',
    //             'warehouse_id_fk.required' => 'กรุณาเลือกคลัง',
    //             'product_id_fk.required' => 'กรุณาเลือกสินค้า',
    //             'lot_number.required' => 'กรุณากรอกข้อมูล',
    //             'lot_expired_date.required' => 'กรุณากรอกข้อมูล',
    //             'amt.required' => 'กรุณากรอกข้อมูล',
    //             'doc_no.required' => 'กรุณากรอกข้อมูล',
    //             'doc_date.required' => 'กรุณากรอกข้อมูล',
    //             // 'product_unit_id_fk.required' => 'กรุณาเลือกหน่วยนับ',
    //         ]
    //     );

    //     if (!$validator->fails()) {



    //         // ถ้ามีสินค้าในระบบแล้วจะเป็นการ อัพเดท จำนวนทับกับตัวเก่าที่มีใน stock
    //         // stock_movement จะเป็นการสร้างใหม่ทุกครั้ง
    //         $data_check = Stock::where('branch_id_fk', $request->branch_id_fk)
    //             ->where('product_id_fk', $request->product_id_fk)
    //             ->where('warehouse_id_fk', $request->warehouse_id_fk)
    //             ->where('lot_number', $request->lot_number)
    //             ->where('lot_expired_date', $request->lot_expired_date)
    //             ->first();

    //         if ($data_check) {
    //             $query = Stock::where('id', $data_check->id)->first();

    //             $data_amt = [
    //                 'amt' => $query->amt + $request->amt,
    //             ];
    //             $query->update($data_amt);
    //         } else {
    //             try {
    //                 DB::BeginTransaction();

    //                 $Stock = new Stock();
    //                 // $StockMovement =new StockMovement();



    //                 $pro_unit_data = ProductsUnit::all()
    //                 ->where('status', '=', '1')
    //                 ->where('lang_id', '=', '1')
    //                 ->where('product_unit_id','=',$request->unit)
    //                 ->first();

    //                       $Stock->branch_id_fk = $request->branch_id_fk;
    //                       $Stock->product_id_fk = $request->product_id_fk;
    //                       $Stock->lot_number = $request->lot_number;
    //                       $Stock->lot_expired_date = $request->lot_expired_date;
    //                       $Stock->warehouse_id_fk = $request->warehouse_id_fk;
    //                       $Stock->amt = $request->amt;
    //                       $Stock->product_unit_id_fk = $request->unit;
    //                       $Stock->product_unit_name = $pro_unit_data->product_unit;
    //                       $Stock->date_in_stock = date('Y-m-d');
    //                       $Stock->s_maker = Auth::guard('admin')->user()->id;
    //                       $Stock->business_location_id_fk = 1;


    //                       $Stock->save();


    //                 //    $StockMovement->branch_id_fk= $request->branch_id_fk;
    //                 //    $StockMovement->product_id_fk= $request->product_id_fk;
    //                 //    $StockMovement->lot_number= $request->lot_number;
    //                 //    $StockMovement->lot_expired_date= $request->lot_expired_date;
    //                 //    $StockMovement->warehouse_id_fk= $request->warehouse_id_fk;
    //                 //    $StockMovement->amt= $request->amt;
    //                 //    $StockMovement->product_unit_id_fk= $request->unit;
    //                 //    $StockMovement->product_unit_name = $pro_unit_data->product_unit;
    //                 //    $StockMovement->action_date= date('Y-m-d');
    //                 //    $StockMovement->action_user= Auth::guard('admin')->user()->id;
    //                 //    $StockMovement->business_location_id_fk= 1;
    //                 //    $StockMovement->doc_no= $request->doc_no;
    //                 //    $StockMovement->doc_date= $request->doc_date;
    //                 //    $StockMovement->in_out = 1;
    //                 //    $StockMovement->save();

    //                 $file = $request->file;

    //                 if (isset($file)) {

    //                         $url = 'local/public/files_warehouse/' . date('Ym');

    //                         $f_name =date('YmdHis').'.'.$file->getClientOriginalExtension();

    //                         if ($file->getClientOriginalExtension() == 'pdf') {
    //                             $type = 'pdf';
    //                         } else {
    //                             $type = 'img';
    //                         }


    //                         if ($file->move($url, $f_name)) {
    //                             DB::table('db_stock_doc')->insert([
    //                                 'stock_id_fk'=>$Stock->id,
    //                                 'stock_movement_id_fk' => $StockMovement->id,
    //                                 'warehouse_id_fk' => $request->warehouse_id_fk,
    //                                 'url' => $url,
    //                                 'doc_name' => $f_name,
    //                                 'type' => $type,
    //                             ]);
    //                         }

    //                 }
    //                 DB::commit();
    //                 return response()->json(['status' => 'success'], 200);
    //             } catch (Exception $e) {
    //                 DB::rollback();
    //                 return response()->json(['error' => $validator->errors()]);

    //             }


    //         }



    //     }
    //     return response()->json(['error' => $validator->errors()]);
    // }


    public function form_add_product_confirm(Request $rs)
    {
        $data = Stock_lot::where('id', $rs->stock_lot_id)->first();

        if ($data) {

            try {
                DB::BeginTransaction();
                if ($rs->type == 'confirm') {

                    $f_name = Auth::guard('admin')->user()->name . ' ' . Auth::guard('admin')->user()->last_name;
                    $Stock_lot_update = Stock_lot::where('id', $rs->stock_lot_id)
                        ->update([
                            'status' => 'confirm',
                            'action_user_confirm_name' => $f_name,
                            'date_approve' => now(),
                            'action_user_confirm' => Auth::guard('admin')->user()->id
                        ]);


                    $StockMovement = new StockMovement();
                    $StockMovement->branch_id_fk = $data->branch_id_fk;
                    $StockMovement->product_id_fk = $data->product_id_fk;
                    $StockMovement->lot_number = $data->lot_number;
                    $StockMovement->lot_expired_date = $data->lot_expired_date;
                    $StockMovement->warehouse_id_fk = $data->warehouse_id_fk;
                    $StockMovement->amt = $data->amt;
                    $StockMovement->product_unit_id_fk = $data->product_unit_id_fk;
                    $StockMovement->product_unit_name = $data->product_unit_name;
                    $StockMovement->action_date = date('Y-m-d');
                    $StockMovement->action_user = Auth::guard('admin')->user()->id;
                    $StockMovement->business_location_id_fk = 1;
                    $StockMovement->doc_no = $data->doc_no;
                    $StockMovement->doc_date = $data->doc_date;
                    $StockMovement->in_out = 1;
                    $StockMovement->save();


                    $data_check = Stock::where('branch_id_fk', $data->branch_id_fk)
                        ->where('product_id_fk', $data->product_id_fk)
                        ->where('warehouse_id_fk', $data->warehouse_id_fk)
                        ->first();


                    if ($data_check) {
                        $query = Stock::where('id', $data_check->id)->first();

                        $data_amt = [
                            'amt' => $query->amt + $data->amt,
                        ];
                        $query->update($data_amt);
                        DB::commit();
                        return redirect('admin/receive')->withSuccess('บันทึกสำเร็จ');
                    } else {
                        $Stock = new Stock();

                        $Stock->branch_id_fk = $data->branch_id_fk;
                        $Stock->product_id_fk = $data->product_id_fk;
                        $Stock->lot_number = $data->lot_number;
                        $Stock->lot_expired_date = $data->lot_expired_date;
                        $Stock->warehouse_id_fk = $data->warehouse_id_fk;
                        $Stock->amt = $data->amt;
                        $Stock->product_unit_id_fk = $data->product_unit_id_fk;
                        $Stock->product_unit_name = $data->product_unit_name;
                        $Stock->date_in_stock = date('Y-m-d');
                        $Stock->s_maker = Auth::guard('admin')->user()->id;
                        $Stock->business_location_id_fk = 1;

                        $Stock->save();
                        DB::commit();
                        return redirect('admin/receive')->withSuccess('บันทึกสำเร็จ');
                    }
                } else {
                    $f_name = Auth::guard('admin')->user()->name . ' ' . Auth::guard('admin')->user()->last_name;
                    $data = Stock_lot::where('id', $rs->stock_lot_id)
                        ->update([
                            'status' => 'cancel',
                            'action_user_confirm_name' => $f_name,
                            'date_approve' => now(),
                            'action_user_confirm' => Auth::guard('admin')->user()->id
                        ]);
                        DB::commit();
                        return redirect('admin/receive')->withSuccess('บันทึกสำเร็จ');
                }

            } catch (Exception $e) {
                DB::rollback();
                return redirect('admin/receive')->withSuccess('บันทึกสำเร็จ');
            }
        } else {
            return redirect('admin/receive')->withError('ผิดพลาดกรุณาทำรายการไหม่');
        }
    }
}
