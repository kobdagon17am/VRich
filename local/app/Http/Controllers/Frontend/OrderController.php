<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cart;
use PhpParser\Node\Stmt\Return_;
use Auth;
use Mpdf\Tag\Em;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function index()
    {
        if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
            $dataset_currency =  1;
        }else{
            $dataset_currency =  2;
        }

        $dataset_currency = DB::table('dataset_currency')
        ->where('id', '=',$dataset_currency)
        ->first();


        // Cart::session(1)->clear();

        $categories = DB::table('categories')
            // ->where('lang_id', '=', 1)
            ->where('status', '=', 1)
            ->get();

        $product_all = OrderController::product_list('other');


        return view('frontend/order', compact('product_all', 'categories','dataset_currency'));
    }



    public function index_promotion()
    {
        if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
            $dataset_currency =  1;
        }else{
            $dataset_currency =  2;
        }

        $dataset_currency = DB::table('dataset_currency')
        ->where('id', '=',$dataset_currency)
        ->first();


        // Cart::session(1)->clear();

        $categories = DB::table('categories')
            // ->where('lang_id', '=', 1)
            ->where('status', '=', 1)
            ->get();

        $product_all = OrderController::product_list('promotion');


        return view('frontend/order_promotion', compact('product_all', 'categories','dataset_currency'));
    }


    public function cancel_order($type)
    {


         Cart::session($type)->clear();
         if($type == 'other'){
            return redirect('Order')->withSuccess('Order canceled successfully');
         }else{
            return redirect('Orderpromotion')->withSuccess('Order canceled successfully');
         }

    }


    public static function product_list($type,$categories = '')
    {
        if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
            $dataset_currency =  1;
        }else{
            $dataset_currency =  2;
        }

        $dataset_currency = DB::table('dataset_currency')
        ->where('id', '=',$dataset_currency)
        ->first();

        if(empty($categories)){
            $product = DB::table('products')
            ->select(
                'products.*',
                'products.id as products_id',
                'product_images.product_image_url',
                'product_images.product_image_name',



                // 'dataset_currency.*',
            )
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id_fk')
            ->where('products.status', '=', 1)
            ->where('products.type', '=', $type)
            // ->where('products_cost.business_location_id', '=', 1)
            ->groupby('products.id')
            ->orderby('products.product_price_member_usd')
            ->get();


        }else{

            $product = DB::table('products')
            ->select(
                'products.*',
                'products.id as products_id',
                'product_images.product_image_url',
                'product_images.product_image_name',


                // 'dataset_currency.*',
            )
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id_fk')
            ->where('products.status', '=', 1)
            ->where('products.product_category_id_fk','=',$categories)

            // ->where('products_cost.business_location_id', '=', 1)
            ->groupby('products.id')
            ->orderby('products.product_price_member_usd')
            ->get();


        }

        //->Paginate(4);

        $data = array(
            'product' => $product,
            'currency'=>$dataset_currency
        );
        return $data;
    }
    public static function get_product(Request $rs)
    {
        if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
            $dataset_currency =  1;
        }else{
            $dataset_currency =  2;
        }


            $product = DB::table('products')
            ->select(
                'products.*',
                'products.id as products_id',
                'products.product_pv as pv',
                'product_images.product_image_url',
                'product_images.product_image_name',

                // 'dataset_currency.*',
            )
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id_fk')
            // ->where('products_cost.business_location_id', '=', 1)
            ->where('products.id', '=', $rs->product_id)
            ->groupby('products.id')
            ->first();



            $dataset_currency = DB::table('dataset_currency')
            ->where('id', '=',$dataset_currency)
            ->first();

        $data = array(
            'product' => $product,
            'dataset_currency' =>  $dataset_currency,
        );
        return $data;
    }


    public function add_cart(Request $rs)
    {


        $product = DB::table('products')
        ->select(
            'products.*',
            'products.id as products_id',
            'products.product_pv as pv',
            'product_images.product_image_url',
            'product_images.product_image_name',

            // 'dataset_currency.*',
        )
        ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id_fk')
        // ->where('products_cost.business_location_id', '=', 1)
        ->where('products.id', '=', $rs->id)
        ->groupby('products.id')
        ->first();




            if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
                $dataset_currency =  1;
                $price = $product->product_price_member_th;
                $shipping = $product->shipping_th  ?? '0';
            }else{
                $dataset_currency =  2;
                $price = $product->product_price_member_usd;
                $shipping = $product->shipping_usd  ?? '0';
            }

            $dataset_currency = DB::table('dataset_currency')
            ->where('id', '=',$dataset_currency)
            ->first();

        if ($product) {
            Cart::session($rs->type)->add(array(
                'id' => $product->products_id, // inique row ID
                'name' => $product->product_name,
                'price' =>  $price,
                'quantity' => $rs->quantity,
                'attributes' => array(
                    'shipping' => $shipping,
                    'pv' => $product->pv,
                    'img' => asset($product->product_image_url . '' . $product->product_image_name),
                    'product_unit_id'=>$product->product_unit_id_fk,
                    'product_unit_name' => $product->product_unit_name,
                    'descriptions' => $product->product_detail,
                    // 'promotion_id' => $rs->id,
                    'detail' => '',
                    // 'category_id' => $product->category_id,
                ),
            ));

            $getTotalQuantity = Cart::session($rs->type)->getTotalQuantity();

            // $item = Cart::session($request->type)->getContent();
            $data = ['status' => 'success', 'qty' => $getTotalQuantity];
        } else {
            $data = ['status' => 'fail', 'ms' => 'ไม่พบสินค้าในระบบกรุณาทำรยการไหม่อีกครั้ง'];
        }


        return $data;
    }

    public function cart($type)
    {


        $cartCollection = Cart::session($type)->getContent();
        $data = $cartCollection->toArray();




        $quantity = Cart::session($type)->getTotalQuantity();

        if($quantity  == 0){

            if($type == 'other'){
                return redirect('Order')->withWarning('There is no any product in the shopping cart, Please Select!');
            }else{
                return redirect('Orderpromotion')->withWarning('There is no any product in the shopping cart, Please Select!');

            }

        }



        if ($data) {
            foreach ($data as $value) {
                $pv[] = $value['quantity'] * $value['attributes']['pv'];

                $product_shipping = DB::table('products')
                ->where('id',$value['id'])
                ->where('status_shipping','Y')
                ->first();

                if($product_shipping){
                    //$pv_shipping_arr[] = $value['quantity'] * $product_shipping->pv;
                     $product_shipping_th = $product_shipping->shipping_th  ?? '0';
                     $product_shipping_usd = $product_shipping->shipping_usd  ?? '0';


                    $shipping_arr_th[] =  $product_shipping_th * $value['quantity'] ;
                    $shipping_arr_usd[] = $product_shipping_usd * $value['quantity'] ;
                }else{
                    $shipping_arr_th[] = 0;
                    $shipping_arr_usd[] = 0;
                }

            }


            $shipping_th = array_sum($shipping_arr_th);
            $shipping_usd = array_sum($shipping_arr_usd);
            $pv_total = array_sum($pv);

        } else {
            $pv_total = 0;
            $shipping_th = 0;
            $shipping_usd = 0;


        }



        $data_user =  DB::table('customers')
        ->select('dataset_qualification.business_qualifications as qualification_name','dataset_qualification.bonus')
        ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=','customers.qualification_id')
        ->where('user_name','=',Auth::guard('c_user')->user()->user_name)
        ->first();

        $price = Cart::session($type)->getTotal();
        if( Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id) ){
            $dataset_currency =  1;
            $price_total = number_format($price+$shipping_th, 2);
        }else{
            $dataset_currency =  2;
            $price_total = number_format($price+$shipping_usd, 2);
        }


        // $shipping = \App\Http\Controllers\Frontend\ShippingController::fc_shipping($pv_shipping);


        // $discount = floor($pv_total * $data_user->bonus/100);

        $bill = array(
            'price_total' => $price_total,
            'shipping_th'=>$shipping_th,
            'shipping_usd'=>$shipping_usd,
            'pv_total' => $pv_total,
            'data' => $data,
            'bonus'=>$data_user->bonus,
            // 'discount'=>$discount,
            'position'=>$data_user->qualification_name,
            'quantity' => $quantity,
            'status' => 'success',

        );



        $dataset_currency = DB::table('dataset_currency')
        ->where('id', '=',$dataset_currency)
        ->first();

        if($type == 'other'){
            return view('frontend/cart',['type'=>'other'], compact('bill','dataset_currency'));
        }else{
            return view('frontend/cart_promotion',['type'=>'promotion'], compact('bill','dataset_currency'));

        }


    }

    public function cart_delete(Request $request)
    {

        Cart::session($request->type)->remove($request->data_id);
        if( $request->type == 'other'){
            return redirect('cart/other')->withSuccess('Deleted Success');
        }else{
            return redirect('cart/promotion')->withSuccess('Deleted Success');
        }

    }


    public function quantity_change(Request $request){
        if ($request->product_id) {
            Cart::session($request->type)->update($request->product_id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->productQty,
                ),
            ));
            if( $request->type == 'other'){
                return redirect('cart/other')->withSuccess('Number edited successfully');
            }else{
                return redirect('cart/promotion')->withSuccess('Number edited successfully');
            }

        }else{
            return redirect('cart/other')->withError('Unable to edit product quantity');

        }


    }





    // ประวัติการสั่งซื้อ
    public function order_history()
    {
        return view('frontend/order-history');
    }

    // รายละเอียดของ ออเดอร์
    public function order_detail($code_order)
    {


        $orders_detail = DB::table('db_orders')
        ->select(

            'customers.user_name',
            'customers.name',
            'customers.last_name',
            'dataset_order_status.detail',
            'dataset_order_status.css_class',
            'db_orders.*',

        )
        ->leftjoin('customers', 'customers.id','db_orders.customers_id_fk')
        ->leftjoin('dataset_order_status', 'dataset_order_status.orderstatus_id','db_orders.order_status_id_fk')
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
                    'dataset_districts.name_th as district',
                    'dataset_provinces.name_th as province',
                    'dataset_amphures.name_th as tambon',
                    'db_orders.zipcode',
                    'tel',
                )
                ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'db_orders.province_id')
                ->leftjoin('dataset_amphures', 'dataset_amphures.id', '=', 'db_orders.tambon_id')
                ->leftjoin('dataset_districts', 'dataset_districts.id', '=', 'db_orders.district_id')
                ->GroupBy('house_no')
                ->where('code_order', $code_order)
                ->get();


            return $item;
        })

        // เอาข้อมูลสินค้าที่อยู่ในรายการ order
        ->map(function ($item) use ($code_order) {
            $item->product_detail = DB::table('db_order_products_list')
                ->leftjoin('product_images', 'product_images.product_id_fk', 'db_order_products_list.product_id_fk')
                ->where('code_order', $code_order)
                ->GroupBy('product_images.product_id_fk')
                ->get();
            return $item;
        });

        // dd($orders_detail);

        if(count($orders_detail) <= 0){
            return redirect('order_history')->withWarning('There is no ordering information for this tracking number.');
        }

        return view('frontend/order-detail',compact('orders_detail'));
    }
}
