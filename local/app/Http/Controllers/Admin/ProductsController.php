<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        // dd('111');

        $get_products = DB::table('products')
            // ->where('username','=',Auth::guard('c_user')->user()->username)
            // ->where('password','=',md5($req->password))
            // ->first();
            ->select('products.*', 'product_images.product_image_url', 'product_images.product_image_name')
            ->leftJoin('product_images', 'product_images.product_id_fk', '=', 'products.id')
            ->where('product_images.product_image_orderby', '=', '1')
            ->where('products.type', '=', 'other')
            ->get();
        // dd($get_products);

        $get_categories = DB::table('categories')
            ->where('status', 1)
            ->get();

        $get_unit = DB::table('dataset_product_unit')
            ->where('status', 1)
            ->get();

        return view('backend/products', compact('get_products', 'get_categories', 'get_unit'));
    }

    public function index_promotion()
    {
        // dd('111');

        $get_products = DB::table('products')
            // ->where('username','=',Auth::guard('c_user')->user()->username)
            // ->where('password','=',md5($req->password))
            // ->first();
            ->select('products.*', 'product_images.product_image_url', 'product_images.product_image_name')
            ->leftJoin('product_images', 'product_images.product_id_fk', '=', 'products.id')
            ->where('product_images.product_image_orderby', '=', '1')
            ->where('products.type', '=', 'promotion')
            ->get();

        $product = DB::table('products')
            ->where('status', 1)
            ->where('type', 'other')
            ->get();

        // dd($get_products);

        $get_categories = DB::table('categories')
            ->where('status', 1)
            ->get();

        $get_unit = DB::table('dataset_product_unit')
            ->where('status', 1)
            ->get();

        return view('backend/products_promotion', compact('get_products', 'product', 'get_categories', 'get_unit'));
    }

    public function view_cashback(Request $rs)
    {

        $products = DB::table('products')
            ->where('id', '=', $rs->id)
            ->first();
        $dataset_casback_product = DB::table('dataset_casback_product')
            ->where('product_id', '=', $rs->id)
            ->orderBy('amt')
            ->get();


        $html = '

      <table class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Unit</th>
                                                        <th>Price/Unit(TH|USB)</th>
                                                        <th>Cost(TH|USB)</th>
                                                        <th>Profit(TH|USB)</th>
                                                        <th>Total(TH|USB)</th>
                                                        <th>#</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
    ';

                foreach ($dataset_casback_product as $value) {
                    $Cost_th = $value->amt*$value->price_th;
                    $Cost_usd = $value->amt*$value->price_usd;
                    $Total_th = $value->amt*$value->profit_th;
                    $Total_usd = $value->amt*$value->profit_usd;
                    $html .=  "<tr>
                    <td>$value->amt</td>
                    <td>$value->price_th|$value->price_usd</td>
                    <td>$Cost_th|$Cost_usd</td>
                    <td>$value->profit_th|$value->profit_usd</td>
                    <td>$Total_th|$Total_usd</td>
                    ";
                    $html .= '<td><i class="las la-trash font-25 text-warning" onclick="delete_cashback('.$value->id.','.$rs->id.');"></i></td>';
                    $html .= "</tr>";
                }

                $html .= '</tbody></table>';
        //   $img = DB::table('product_images')
        //   ->where('product_id_fk', '=', $rs->id)
        //   ->get();

        $data = ['status' => 'success', 'data' => $products, 'html' => $html];
        return $data;
    }


    public function add_cashback(Request $rs)
    {

        $dataPrepare = [
        'product_id'=>$rs->id,
        'product_name'=>$rs->product_name_cash,
        'amt'=>$rs->amt,
        'price_th'=>$rs->price_th,
        'price_usd'=>$rs->price_usd,
        'profit_th'=>$rs->profit_th,
        'profit_usd'=>$rs->profit_usd,
        ];

        $dataset_casback_product = DB::table('dataset_casback_product')
        ->insert($dataPrepare);

        if ($dataset_casback_product) {
            // Insertion was successful
            $dataset_casback_product = DB::table('dataset_casback_product')
            ->where('product_id', '=', $rs->id)
            ->orderBy('amt')
            ->get();


        $html = '

      <table class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Unit</th>
                                                        <th>Price/Unit(TH|USB)</th>
                                                        <th>Cost(TH|USB)</th>
                                                        <th>Profit(TH|USB)</th>
                                                        <th>Total(TH|USB)</th>
                                                        <th>#</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
    ';

        foreach ($dataset_casback_product as $value) {
            $Cost_th = $value->amt*$value->price_th;
            $Cost_usd = $value->amt*$value->price_usd;
            $Total_th = $value->amt*$value->profit_th;
            $Total_usd = $value->amt*$value->profit_usd;
            $html .=  "<tr>
            <td>$value->amt</td>
             <td>$value->price_th|$value->price_usd</td>
             <td>$Cost_th|$Cost_usd</td>
             <td>$value->profit_th|$value->profit_usd</td>
             <td>$Total_th|$Total_usd</td>
             ";
             $html .= '<td><i class="las la-trash font-25 text-warning" onclick="delete_cashback('.$value->id.','.$rs->id.');"></i></td>';
             $html .= "</tr>";
        }

        $html .= '</tbody></table>';

        //   $img = DB::table('product_images')
        //   ->where('product_id_fk', '=', $rs->id)
        //   ->get();

        $data = ['status' => 'success','html' => $html];
        return $data;

            // You can perform additional actions here if needed
        } else {
            // Insertion failed
            $data = ['status' => 'fail','ms' => 'Insertion failed. Please check for errors.'];
            return $data;
        }



    }

    public function delete_cashback(Request $rs)
    {


        $dataset_casback_product = DB::table('dataset_casback_product')
        ->where('id',$rs->dataset_casback_product_id_fk)
        ->delete();

        if ($dataset_casback_product) {
            // Insertion was successful
            $dataset_casback  = DB::table('dataset_casback_product')
            ->where('product_id', '=', $rs->product_id)
            ->orderBy('amt')
            ->get();


        $html = '

      <table class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Unit</th>
                                                        <th>Price/Unit(TH|USB)</th>
                                                        <th>Cost(TH|USB)</th>
                                                        <th>Profit(TH|USB)</th>
                                                        <th>Total(TH|USB)</th>
                                                        <th>#</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
    ';

        foreach ($dataset_casback as $value) {
            $Cost_th = $value->amt*$value->price_th;
            $Cost_usd = $value->amt*$value->price_usd;
            $Total_th = $value->amt*$value->profit_th;
            $Total_usd = $value->amt*$value->profit_usd;
            $html .=  "<tr>
            <td>$value->amt</td>
             <td>$value->price_th|$value->price_usd</td>
             <td>$Cost_th|$Cost_usd</td>
             <td>$value->profit_th|$value->profit_usd</td>
             <td>$Total_th|$Total_usd</td>
             ";
             $html .= '<td><i class="las la-trash font-25 text-warning" onclick="delete_cashback('.$value->id.','.$rs->product_id.');"></i></td>';
             $html .= "</tr>";
        }

        $html .= '</tbody></table>';

        //   $img = DB::table('product_images')
        //   ->where('product_id_fk', '=', $rs->id)
        //   ->get();

        $data = ['status' => 'success','html' => $html];
        return $data;

            // You can perform additional actions here if needed
        } else {
            // Insertion failed
            $data = ['status' => 'fail','ms' => 'Delete failed. Please check for errors.'];
            return $data;
        }



    }

    public function insert(Request $rs)
    {
        //  dd($rs->all());

        $get_categories = DB::table('categories')
            ->where('id', '=', $rs->product_category_name)
            ->first();

        $get_unit = DB::table('dataset_product_unit')
            ->where('id', '=', $rs->product_unit_name)
            ->first();


        $dataPrepare = [
            'product_code' => $rs->product_code,
            'product_name' => $rs->product_name,

            'product_category_name' => $get_categories->category_name,
            'product_category_id_fk' => $get_categories->id,
            'product_category_en_name' => $get_categories->category_en_name,
            'product_vat' => $rs->product_vat,

            'product_unit_name' => $get_unit->product_unit_th,
            'product_unit_id_fk' => $get_unit->id,
            'product_unit_en_name' => $get_unit->product_unit_en,

            'product_cost_th' => $rs->product_cost_th,
            'product_cost_usd' => $rs->product_cost_usd,

            'shipping_th' => $rs->shipping_th,
            'shipping_usd' => $rs->shipping_usd,

            'product_price_retail_th' => $rs->product_price_retail_th,
            'product_price_retail_usd' => $rs->product_price_retail_usd,
            'product_price_member_th' => $rs->product_price_member_th,
            'product_price_member_usd' => $rs->product_price_member_usd,
            'status_shipping' => $rs->status_shipping,


            'product_pv' => $rs->product_pv,
            'status' => $rs->product_status,
            'product_detail' => $rs->product_detail,
        ];

        try {
            DB::BeginTransaction();
            $get_products = DB::table('products')
                ->insertGetId($dataPrepare);


            if (isset($rs->product_image1)) {
                $file_1 = $rs->product_image1;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
                if ($file_1->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '1',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image2)) {
                $file_2 = $rs->product_image2;
                $url = 'local/public/products/';

                $f_name2 = date('YmdHis') . '_2.' . $file_2->getClientOriginalExtension();
                if ($file_2->move($url, $f_name2)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name2,
                        'product_image_orderby' => '2',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image3)) {
                $file_3 = $rs->product_image3;
                $url = 'local/public/products/';

                $f_name3 = date('YmdHis') . '_3.' . $file_3->getClientOriginalExtension();
                if ($file_3->move($url, $f_name3)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name3,
                        'product_image_orderby' => '3',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image4)) {
                $file_4 = $rs->product_image4;
                $url = 'local/public/products/';

                $f_name4 = date('YmdHis') . '_4.' . $file_4->getClientOriginalExtension();
                if ($file_4->move($url, $f_name4)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name4,
                        'product_image_orderby' => '4',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            DB::commit();
            return redirect('admin/Products')->withSuccess('เพิ่มสินค้าสำเร็จ');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/Products')->withError('เพิ่มสินค้าไม่สำเร็จ');
        }

        //dd('success');

    }


    public function insert_promotion(Request $rs)
    {
        //  dd($rs->all());

        $get_categories = DB::table('categories')
            ->where('id', '=', $rs->product_category_name)
            ->first();

        $get_unit = DB::table('dataset_product_unit')
            ->where('id', '=', $rs->product_unit_name)
            ->first();


        $dataPrepare = [
            'product_code' => $rs->product_code,
            'product_name' => $rs->product_name,
            'product_id_fk' => $rs->product_id_fk,

            'product_category_name' => $get_categories->category_name,
            'product_category_id_fk' => $get_categories->id,
            'product_category_en_name' => $get_categories->category_en_name,
            'product_vat' => $rs->product_vat,

            'product_unit_name' => $get_unit->product_unit_th,
            'product_unit_id_fk' => $get_unit->id,
            'product_unit_en_name' => $get_unit->product_unit_en,

            'product_cost_th' => $rs->product_cost_th,
            'product_cost_usd' => $rs->product_cost_usd,

            'shipping_th' => $rs->shipping_th,
            'type' => 'promotion',
            'shipping_usd' => $rs->shipping_usd,
            'pack_qty' => $rs->pack_qty,

            'product_price_retail_th' => $rs->product_price_retail_th,
            'product_price_retail_usd' => $rs->product_price_retail_usd,
            'product_price_member_th' => $rs->product_price_member_th,
            'product_price_member_usd' => $rs->product_price_member_usd,
            'status_shipping' => $rs->status_shipping,


            'product_pv' => $rs->product_pv,
            'status' => $rs->product_status,
            'product_detail' => $rs->product_detail,
        ];

        try {
            DB::BeginTransaction();
            $get_products = DB::table('products')
                ->insertGetId($dataPrepare);


            if (isset($rs->product_image1)) {
                $file_1 = $rs->product_image1;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
                if ($file_1->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '1',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image2)) {
                $file_2 = $rs->product_image2;
                $url = 'local/public/products/';

                $f_name2 = date('YmdHis') . '_2.' . $file_2->getClientOriginalExtension();
                if ($file_2->move($url, $f_name2)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name2,
                        'product_image_orderby' => '2',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image3)) {
                $file_3 = $rs->product_image3;
                $url = 'local/public/products/';

                $f_name3 = date('YmdHis') . '_3.' . $file_3->getClientOriginalExtension();
                if ($file_3->move($url, $f_name3)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name3,
                        'product_image_orderby' => '3',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            if (isset($rs->product_image4)) {
                $file_4 = $rs->product_image4;
                $url = 'local/public/products/';

                $f_name4 = date('YmdHis') . '_4.' . $file_4->getClientOriginalExtension();
                if ($file_4->move($url, $f_name4)) {
                    $dataPrepare = [
                        'product_id_fk' => $get_products,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name4,
                        'product_image_orderby' => '4',

                    ];
                    DB::table('product_images')
                        ->insert($dataPrepare);
                }
            }

            DB::commit();
            return redirect('admin/Products_promotion')->withSuccess('เพิ่มสินค้าสำเร็จ');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/Products_promotion')->withError('เพิ่มสินค้าไม่สำเร็จ');
        }

        //dd('success');

    }
    public function edit_products(Request $rs)
    {


        $get_categories = DB::table('categories')
            ->where('id', '=', $rs->product_category_name)
            ->first();


        $get_unit = DB::table('dataset_product_unit')
            ->where('id', '=', $rs->product_unit_name)
            ->first();


        $dataPrepare = [
            'product_code' => $rs->product_code,
            'product_name' => $rs->product_name,



            'product_category_name' => $get_categories->category_name,
            'product_category_id_fk' => $get_categories->id,
            'product_category_en_name' => $get_categories->category_en_name,
            'product_vat' => $rs->product_vat,

            'product_unit_name' => $get_unit->product_unit_th,
            'product_unit_id_fk' => $get_unit->id,
            'product_unit_en_name' => $get_unit->product_unit_en,

            'product_cost_th' => $rs->product_cost_th,
            'product_cost_usd' => $rs->product_cost_usd,
            'shipping_th' => $rs->shipping_th,
            'shipping_usd' => $rs->shipping_usd,

            'product_price_retail_th' => $rs->product_price_retail_th,
            'product_price_retail_usd' => $rs->product_price_retail_usd,
            'product_price_member_th' => $rs->product_price_member_th,
            'product_price_member_usd' => $rs->product_price_member_usd,
            'status_shipping' => $rs->status_shipping,

            'product_pv' => $rs->product_pv,
            'status' => $rs->product_status,
            'product_detail' => $rs->product_detail,
        ];


        try {
            DB::BeginTransaction();
            // dd($rs->all());
            $get_products = DB::table('products')
                ->where('id', '=', $rs->id)
                ->update($dataPrepare);


            if (isset($rs->product_image1)) {
                $file_1 = $rs->product_image1;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
                if ($file_1->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '1',

                    ];

                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' =>  1],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image2)) {
                $file_2 = $rs->product_image2;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_2.' . $file_2->getClientOriginalExtension();
                if ($file_2->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '2',

                    ];

                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 2],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image3)) {
                $file_3 = $rs->product_image3;
                $url = 'local/public/products/';

                $f_name3 = date('YmdHis') . '_3.' . $file_3->getClientOriginalExtension();
                if ($file_3->move($url, $f_name3)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name3,
                        'product_image_orderby' => '3',

                    ];
                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 3],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image4)) {
                $file_4 = $rs->product_image4;
                $url = 'local/public/products/';

                $f_name4 = date('YmdHis') . '_4.' . $file_4->getClientOriginalExtension();
                if ($file_4->move($url, $f_name4)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name4,
                        'product_image_orderby' => '4',

                    ];
                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 4],
                            $dataPrepare
                        );
                }
            }
            DB::commit();
            return redirect('admin/Products')->withSuccess('แก้ไขข้อมูลสินค้าสำเร็จ');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/Products')->withError('แก้ไขข้อมูลสินค้าไม่สำเร็จ');
        }
    }

    public function edit_products_promotion(Request $rs)
    {

        $get_categories = DB::table('categories')
            ->where('id', '=', $rs->product_category_name)
            ->first();

        // dd($rs->all());

        $get_unit = DB::table('dataset_product_unit')
            ->where('id', '=', $rs->product_unit_name)
            ->first();


        $dataPrepare = [
            'product_code' => $rs->product_code,
            'product_name' => $rs->product_name,
            'product_id_fk' => $rs->product_id_fk,
            'pack_qty' => $rs->pack_qty,
            'product_category_name' => $get_categories->category_name,
            'product_category_id_fk' => $get_categories->id,
            'product_category_en_name' => $get_categories->category_en_name,
            'product_vat' => $rs->product_vat,

            'product_unit_name' => $get_unit->product_unit_th,
            'product_unit_id_fk' => $get_unit->id,
            'product_unit_en_name' => $get_unit->product_unit_en,

            'product_cost_th' => $rs->product_cost_th,
            'product_cost_usd' => $rs->product_cost_usd,
            'shipping_th' => $rs->shipping_th,
            'shipping_usd' => $rs->shipping_usd,

            'product_price_retail_th' => $rs->product_price_retail_th,
            'product_price_retail_usd' => $rs->product_price_retail_usd,
            'product_price_member_th' => $rs->product_price_member_th,
            'product_price_member_usd' => $rs->product_price_member_usd,
            'status_shipping' => $rs->status_shipping,

            'product_pv' => $rs->product_pv,
            'status' => $rs->product_status,
            'product_detail' => $rs->product_detail,
        ];


        try {
            DB::BeginTransaction();
            // dd($rs->all());
            $get_products = DB::table('products')
                ->where('id', '=', $rs->id)
                ->update($dataPrepare);


            if (isset($rs->product_image1)) {
                $file_1 = $rs->product_image1;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_1.' . $file_1->getClientOriginalExtension();
                if ($file_1->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '1',

                    ];

                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' =>  1],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image2)) {
                $file_2 = $rs->product_image2;
                $url = 'local/public/products/';

                $f_name = date('YmdHis') . '_2.' . $file_2->getClientOriginalExtension();
                if ($file_2->move($url, $f_name)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name,
                        'product_image_orderby' => '2',

                    ];

                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 2],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image3)) {
                $file_3 = $rs->product_image3;
                $url = 'local/public/products/';

                $f_name3 = date('YmdHis') . '_3.' . $file_3->getClientOriginalExtension();
                if ($file_3->move($url, $f_name3)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name3,
                        'product_image_orderby' => '3',

                    ];
                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 3],
                            $dataPrepare
                        );
                }
            }

            if (isset($rs->product_image4)) {
                $file_4 = $rs->product_image4;
                $url = 'local/public/products/';

                $f_name4 = date('YmdHis') . '_4.' . $file_4->getClientOriginalExtension();
                if ($file_4->move($url, $f_name4)) {
                    $dataPrepare = [
                        'product_id_fk' => $rs->id,
                        'product_image_url' => $url,
                        'product_image_name' => $f_name4,
                        'product_image_orderby' => '4',

                    ];
                    DB::table('product_images')
                        ->updateOrInsert(
                            ['product_id_fk' => $rs->id, 'product_image_orderby' => 4],
                            $dataPrepare
                        );
                }
            }
            DB::commit();
            return redirect('admin/Products_promotion')->withSuccess('แก้ไขข้อมูลสินค้าสำเร็จ');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('admin/Products_promotion')->withError('แก้ไขข้อมูลสินค้าไม่สำเร็จ');
        }
    }

    public function view_products(Request $rs)
    {

        $products = DB::table('products')
            ->where('id', '=', $rs->id)
            ->first();

        $img = DB::table('product_images')
            ->where('product_id_fk', '=', $rs->id)
            ->get();

        $data = ['status' => 'success', 'data' => $products, 'img' => $img];

        return $data;
    }


    public function view_products_promotion(Request $rs)
    {

        $products = DB::table('products')
            ->where('id', '=', $rs->id)
            ->first();

        $img = DB::table('product_images')
            ->where('product_id_fk', '=', $rs->id)
            ->get();

        $data = ['status' => 'success', 'data' => $products, 'img' => $img];

        return $data;
    }
}
