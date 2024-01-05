<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cart;
use Auth;
use PhpParser\Node\Stmt\Return_;
use App\Orders;
use App\Customers;
use App\Order_products_list;
use App\Jang_pv;
use App\eWallet;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ConfirmCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function index($type)
    {


        $location = '';
        $cartCollection = Cart::session($type)->getContent();
        $data = $cartCollection->toArray();
        $quantity = Cart::session($type)->getTotalQuantity();
        $customer_id = Auth::guard('c_user')->user()->id;
        $user_name = Auth::guard('c_user')->user()->user_name;

        if ($quantity  == 0) {
            return redirect('Order')->withWarning('There are no products in the shopping cart. Please select a product');
        }

        if ($data) {

            foreach ($data as $value) {
                $pv[] = $value['quantity'] * $value['attributes']['pv'];
                $product_shipping = DB::table('products')
                    ->where('id', $value['id'])
                    ->where('status_shipping', 'Y')
                    ->first();



                if ($product_shipping) {
                    //$pv_shipping_arr[] = $value['quantity'] * $product_shipping->pv;
                    $product_shipping_th = $product_shipping->shipping_th  ?? '0';
                    $product_shipping_usd = $product_shipping->shipping_usd  ?? '0';


                    $shipping_arr_th[] =  $product_shipping_th * $value['quantity'];
                    $shipping_arr_usd[] = $product_shipping_usd * $value['quantity'];
                } else {
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

        //ราคาสินค้า
        $price = Cart::session($type)->getTotal();

        // $province_data = DB::table('customers_address_delivery')
        //     ->select('province_id_fk')
        //     ->where('customer_id', '=', $customer_id)
        //     ->first();
        // if($province_data){
        //   $data_shipping = ShippingCosController::fc_check_shipping_cos($business_location_id, $province_data->province_id_fk, $price);
        //   if($type == '3'){
        // $shipping = 0;
        //   }else{
        //     $shipping = $data_shipping['data']->shipping_cost;
        //   }

        // }else{
        //   $shipping = 0;
        // }

        // $address = DB::table('customers_address_delivery')
        //     ->select('customers_address_delivery.*', 'dataset_provinces.id as province_id', 'dataset_provinces.name_en as province_name', 'dataset_amphures.name_en as tambon_name', 'dataset_amphures.id as tambon_id', 'dataset_districts.id as district_id', 'dataset_districts.name_th as district_name')
        //     ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'customers_address_delivery.province')
        //     ->leftjoin('dataset_amphures', 'dataset_amphures.id', '=', 'customers_address_delivery.tambon')
        //     ->leftjoin('dataset_districts', 'dataset_districts.id', '=', 'customers_address_delivery.district')
        //     ->where('user_name', '=', $user_name)
        //     ->first();

        $address = DB::table('customers_address_delivery')
        ->select('customers_address_delivery.*', 'dataset_provinces.id as province_id', 'dataset_provinces.name_en as province_name', 'dataset_amphures.name_en as tambon_name', 'dataset_amphures.id as tambon_id', 'dataset_districts.id as district_id', 'dataset_districts.name_en as district_name')
        ->leftjoin('dataset_provinces', 'dataset_provinces.id', '=', 'customers_address_delivery.province')
        ->leftJoin('dataset_districts', 'customers_address_delivery.tambon', '=', 'dataset_districts.id')
        ->leftJoin('dataset_amphures', 'customers_address_delivery.district', '=', 'dataset_amphures.id')
        ->where('user_name', '=',  Auth::guard('c_user')->user()->user_name)
        ->first();

        //     $shipping = \App\Http\Controllers\Frontend\ShippingController::fc_shipping($pv_shipping);

        // if($address){
        //     $shipping_zipcode = \App\Http\Controllers\Frontend\ShippingController::fc_shipping_zip_code($address->zipcode);
        // }else{
        //     $shipping_zipcode = ['status'=>'fail','price'=>0,'ms'=>''];
        // }






        // $vat = DB::table('dataset_vat')
        //     ->where('business_location_id_fk', '=', $business_location_id)
        //     ->first();

        // $vat = $vat->vat;


        //vatใน 7%
        // $p_vat = $price * ($vat / (100 + $vat));

        //มูลค่าสินค้า
        $price_vat = $price;


        $data_user =  DB::table('customers')
            ->select('customers.*', 'dataset_qualification.business_qualifications as qualification_name')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('user_name', '=', Auth::guard('c_user')->user()->user_name)
            ->first();
        //$discount = floor($pv_total * $data_user->bonus/100);



        if (Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id)) {
            $dataset_currency =  1;
            $business_location_id = 1;
            $price_total = number_format($price + $shipping_th, 2);
        } else {
            $dataset_currency =  2;
            $business_location_id = Auth::guard('c_user')->user()->business_location_id;
            $price_total = number_format($price + $shipping_usd, 2);
        }

        $dataset_currency = DB::table('dataset_currency')
            ->where('id', '=', $dataset_currency)
            ->first();

        $bill = array(
            'price_total' => $price_total,
            'shipping_th' => $shipping_th,
            'shipping_usd' => $shipping_usd,
            'price' => $price,
            'price_vat' => $price_vat,
            'pv_total' => $pv_total,
            'data' => $data,

            'price_discount' => $price,
            // 'discount'=>$discount,
            'position' => $data_user->qualification_name,
            'quantity' => $quantity,
            'location_id' => $business_location_id,
            'status' => 'success',
            'type' => $type,
        );

        $customer = DB::table('customers')
            ->where('id', '=', Auth::guard('c_user')->user()->id)
            ->first();

        $province = DB::table('dataset_provinces')
            ->select('*')
            ->where('business_location_id', $business_location_id)
            ->get();

        return view('frontend/confirm_cart', compact('customer', 'address', 'location', 'province', 'bill', 'dataset_currency'));
    }

    public static function check_custome_unline(Request $rs)
    {


        if (empty(@$rs->user_name)) {
            $data = array('status' => 'fail', 'ms' => 'Please fill in the code you ordered for your team member.');
            return $data;
        } else {
            $sent_user_name = $rs->user_name;
        }

        $user_name = Auth::guard('c_user')->user()->user_name;

        if (strtoupper($user_name) == strtoupper($rs->user_name)) {
            $data = array('status' => 'fail', 'ms' => 'Order for only team members.');
            return $data;
        }

        $data_user =  DB::table('customers')
            ->select(
                'customers.id',
                'customers.upline_id',
                'customers.user_name',
                'customers.name',
                'customers.last_name',
                'customers.pv',
                'dataset_qualification.business_qualifications as qualification_name',
                'business_name'
            )
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('user_name', '=', $sent_user_name)
            ->first();




        if ($data_user) {
            $data = array('status' => 'success', 'data' => $data_user);
        } else {
            $data = array('status' => 'fail', 'data' => '', 'ms' => 'No Username:' . $sent_user_name);
        }


        return $data;
    }
    public function payment_submit(Request $rs)
    {

        $insert_db_orders = new Orders();
        $insert_order_products_list = new Order_products_list();
        $quantity = Cart::session($rs->type)->getTotalQuantity();
        $insert_db_orders->quantity = $quantity;
        $customer_id = Auth::guard('c_user')->user()->id;
        $price_check = Cart::session($rs->type)->getTotal();
         $price_total_check = $price_check;


        if (Auth::guard('c_user')->user()->ewallet < $price_total_check) {
            if ($rs->type == 'promotion') {
                DB::rollback();
                return redirect('cart/promotion')->withError('Unable to pay because Ewallet does not have enough money to pay.');
            }else{
                DB::rollback();
                return redirect('cart/other')->withError('Unable to pay because Ewallet does not have enough money to pay.');
            }
        }


        $code_order = \App\Http\Controllers\Frontend\FC\RunCodeController::db_code_order();


        $insert_db_orders->customers_id_fk = $customer_id;
        $insert_db_orders->tracking_type = $rs->tracking_type;



        $user_name = Auth::guard('c_user')->user()->user_name;
        $insert_db_orders->customers_user_name = $user_name;
        if (Auth::guard('c_user')->user()->business_location_id == 1 || empty(Auth::guard('c_user')->user()->business_location_id)) {
            $dataset_currency =  1;
            $business_location_id = 1;
        } else {
            $dataset_currency =  2;
            $business_location_id = Auth::guard('c_user')->user()->business_location_id;
        }

        $insert_db_orders->business_location_id_fk =  $business_location_id;

        if ($insert_db_orders->sent_type_to_customer == 'sent_type_other') {
            $insert_db_orders->customers_sent_id_fk = $rs->customers_sent_id_fk;
            $insert_db_orders->customers_sent_user_name = $rs->customers_sent_user_name;
            $insert_db_orders->status_payment_sent_other = 1;
        } else {
            $insert_db_orders->status_payment_sent_other = 0;
        }

        if ($rs->receive == 'sent_address') {
            $insert_db_orders->address_sent = 'system';

            if (empty($rs->province_id) ) {

                if ($rs->type == 'promotion') {
                    return redirect('confirm_cart/promotion')->withError('Please enter your address before purchasing.');
                }else{
                    return redirect('confirm_cart/other')->withError('Please enter your address before purchasing.');
                }


            }
            $insert_db_orders->delivery_province_id = $rs->province_id;
            $insert_db_orders->house_no = $rs->house_no;
            // $insert_db_orders->house_name = 'system';
            $insert_db_orders->moo = $rs->moo;
            $insert_db_orders->soi = $rs->soi;
            $insert_db_orders->road = $rs->road;
            $insert_db_orders->tambon_id = $rs->tambon_id;
            $insert_db_orders->district_id = $rs->district_id;
            $insert_db_orders->province_id = $rs->province_id;
            $insert_db_orders->zipcode = $rs->zipcode;

            $insert_db_orders->tel = $rs->phone;
            $insert_db_orders->name = $rs->name;
        } else {
            if (empty($rs->same_province)) {

                if ($rs->type == 'promotion') {
                    return redirect('confirm_cart/promotion')->withError('Please enter your address before purchasing.');
                }else{
                    return redirect('confirm_cart/other')->withError('Please enter your address before purchasing.');
                }

            }

            $insert_db_orders->address_sent = 'other';
            $insert_db_orders->delivery_province_id = $rs->same_province;
            $insert_db_orders->house_no = $rs->same_address;
            // $insert_db_orders->house_name = 'system';
            $insert_db_orders->moo = $rs->same_moo;
            $insert_db_orders->soi = $rs->same_soi;
            $insert_db_orders->road = $rs->same_road;
            $insert_db_orders->tambon_id = $rs->same_tambon;
            $insert_db_orders->district_id = $rs->same_district;
            $insert_db_orders->province_id = $rs->same_province;
            $insert_db_orders->zipcode = $rs->same_zipcode;
            $insert_db_orders->tel = $rs->same_phone;
            $insert_db_orders->name = $rs->sam_name;
        }
        $insert_db_orders->pay_type = $rs->type_pay;

        // dd($insert_db_orders->toArray());

        // $location = Location::location($business_location_id, $business_location_id);
        // $location = '';
        $cartCollection = Cart::session($rs->type)->getContent();
        $data = $cartCollection->toArray();
        $quantity = Cart::session($rs->type)->getTotalQuantity();

        if ($quantity  == 0) {
            return redirect('Order')->withWarning('Order not completed Please make a new transaction.');
        }
        $i = 0;
        $products_list = array();
        if ($data) {

            foreach ($data as $value) {

                $i++;
                $total_pv = $value['attributes']['pv'] * $value['quantity'];
                $total_price = $value['price'] * $value['quantity'];


                $product_data = DB::table('products')
                    ->where('id', $value['id'])
                    ->first();

                if ($rs->type == 'promotion') {



                    $insert_db_products_list[$i] = [
                        'code_order' => $code_order,
                        'product_id_fk' => $value['id'],
                        'product_id_fk_promotion' => $product_data->product_id_fk,
                        'product_unit_id_fk' => $value['attributes']['product_unit_id'],
                        'product_unit_name' =>$value['attributes']['product_unit_name'],
                        'customers_username' =>  $user_name,
                        'selling_price' =>  $value['price'],
                        'product_name' =>  $value['name'],
                        'amt' =>  $value['quantity'],
                        'pv' =>   $value['attributes']['pv'],
                        'total_pv' => $total_pv,
                        'total_price' => $total_price,

                        'type' => 'promotion',
                        'amt_out_stock' =>  $value['quantity']* $product_data->pack_qty,
                    ];

                }else{
                    $insert_db_products_list[$i] = [
                        'code_order' => $code_order,
                        'product_id_fk' => $value['id'],
                        'product_unit_id_fk' => $value['attributes']['product_unit_id'],
                        'product_unit_name' =>$value['attributes']['product_unit_name'],
                        'customers_username' =>  $user_name,
                        'selling_price' =>  $value['price'],
                        'product_name' =>  $value['name'],
                        'amt' =>  $value['quantity'],
                        'amt_out_stock' =>  $value['quantity'],
                        'pv' =>   $value['attributes']['pv'],
                        'total_pv' => $total_pv,
                        'total_price' => $total_price,
                    ];

                }



                $product_id[] = $value['id'];

                $pv[] = $value['quantity'] * $value['attributes']['pv'];


                $product_shipping = DB::table('products')
                    ->where('id', $value['id'])
                    ->where('status_shipping', 'Y')
                    ->first();



                if ($product_shipping) {
                    //$pv_shipping_arr[] = $value['quantity'] * $product_shipping->pv;


                    $product_shipping_th = $product_shipping->shipping_th  ?? '0';
                    $product_shipping_usd = $product_shipping->shipping_usd  ?? '0';


                    $shipping_arr_th[] =  $product_shipping_th * $value['quantity'];
                    $shipping_arr_usd[] = $product_shipping_usd * $value['quantity'];
                } else {
                    $shipping_arr_th[] = 0;
                    $shipping_arr_usd[] = 0;
                }


                if ($rs->type == 'promotion') {
                    $db_stock_members = DB::table('db_stock_members')
                    ->where('product_id', '=', $product_data->product_id_fk)
                    ->where('customers_id_fk', '=', $customer_id)
                    ->first();
                }else{
                    $db_stock_members = DB::table('db_stock_members')
                    ->where('product_id', '=', $value['id'])
                    ->where('customers_id_fk', '=', $customer_id)
                    ->first();

                }

                if ($db_stock_members) {
                    $amt = $db_stock_members->pack_amt;
                } else {
                    $amt = 0;
                }

                $q_promotion = $amt +  ($value['quantity']*$product_data->pack_qty);

                if ($db_stock_members) {

                    if ($rs->type == 'promotion') {

                        $product_unit_id = DB::table('products')
                        ->where('id', $product_data->product_id_fk)
                        ->first();



                        $insert_db_orders->sent_stock_type = $rs->sent_stock_type;
                        if($rs->sent_stock_type == 'add'){
                            DB::table('db_log_stock_members')->insert([
                                'code_order' => $code_order,
                                'order_id_fk' => '',
                                'product_id' =>  $product_data->product_id_fk,
                                'product_name' =>  $value['name'],
                                'user_name' => $user_name,
                                'customers_id_fk' => $customer_id,
                                'distribution_channel_id_fk' => 3,
                                'amt_old' => $amt,
                                'amt' => $value['quantity']*$product_data->pack_qty,
                                'amt_new' => $q_promotion,
                                'amt_order' => $value['quantity'],
                                'pv' =>  $value['attributes']['pv'],

                                'price' => $value['price'],
                                'price_total' => $total_price,
                                'product_unit_id_fk' =>  $product_unit_id->product_unit_id_fk,
                                'type' => 'add',
                                'status' => 'success',
                                'note' => 'from ordering products',

                            ]);

                            $update_q = DB::table('db_stock_members')
                                ->where('id',  $db_stock_members->id)
                                ->update([

                                    'pack_amt' => $q_promotion,
                                    'product_name' =>  $value['name'],
                                    'price' =>  $value['price'],
                                    'price_total' => $total_price,
                                    'pv' => $value['attributes']['pv'],
                                    'product_unit_id_fk' =>  $product_unit_id->product_unit_id_fk,

                                ]);
                        }

                    }else{


                        $insert_db_orders->sent_stock_type ='send';
                    }
                } else {


                    if ($rs->type == 'promotion') {

                        $product_unit_id = DB::table('products')
                        ->where('id', $product_data->product_id_fk)
                        ->first();


                        $insert_db_orders->sent_stock_type = $rs->sent_stock_type;
                        if($rs->sent_stock_type == 'add'){
                            DB::table('db_log_stock_members')->insert([
                                'code_order' => $code_order,
                                'order_id_fk' => '',
                                'product_id' =>  $product_data->product_id_fk,
                                'user_name' => $user_name,
                                'customers_id_fk' => $customer_id,
                                'distribution_channel_id_fk' => 3,
                                'product_name' =>  $value['name'],
                                'amt_old' => 0,
                                'amt' => $value['quantity']*$product_data->pack_qty,
                                'amt_new' => $q_promotion,
                                'amt_order' => $value['quantity'],
                                'pv' =>  $value['attributes']['pv'],

                                'price' => $value['price'],
                                'price_total' => $total_price,

                                'product_unit_id_fk' =>  $product_unit_id->product_unit_id_fk,
                                'type' => 'add',
                                'status' => 'success',
                                'note' => 'from ordering products',

                            ]);


                            DB::table('db_stock_members')->insert([
                                'product_id' =>  $product_data->product_id_fk,
                                'user_name' => $user_name,
                                'customers_id_fk' => $customer_id,
                                'distribution_channel_id_fk' => 3,
                                'product_name' =>  $value['name'],
                                'pack_amt' => $value['quantity']*$product_data->pack_qty,
                                'pv' => $value['attributes']['pv'],
                                'price' => $value['price'],
                                'price_total' => $total_price,
                                'product_unit_id_fk' =>  $product_unit_id->product_unit_id_fk,

                            ]);

                        }

                    }else{
                        $insert_db_orders->sent_stock_type ='send';


                    }
                }
            }
            $shipping_th = array_sum($shipping_arr_th);
            $shipping_usd = array_sum($shipping_arr_usd);
            $pv_total = array_sum($pv);
        } else {
            $shipping_th = 0;
            $shipping_usd = 0;
            $pv_total = 0;
        }



        //ราคาสินค้า
        $price = Cart::session($rs->type)->getTotal();

        // $vat = DB::table('dataset_vat')
        // ->where('business_location_id_fk', '=', $business_location_id)
        // ->first();




        $insert_db_orders->product_value = $price;

        if ($dataset_currency ==  1) {
            $shipping_total = $shipping_th;
        } else {
            $shipping_total = $shipping_usd;
        }

        // if($rs->sent_stock_type == 'add' and $rs->type == 'promotion'){
        //     $shipping_total = 0;
        // }


        $insert_db_orders->shipping_cost_name = '';

        $insert_db_orders->sum_price = $price;

        $data_user =  DB::table('customers')
            ->select('dataset_qualification.business_qualifications as qualification_name')
            ->leftjoin('dataset_qualification', 'dataset_qualification.code', '=', 'customers.qualification_id')
            ->where('user_name', '=', Auth::guard('c_user')->user()->user_name)
            ->first();

        $insert_db_orders->position = $data_user->qualification_name;

        //$discount = floor($pv_total * $data_user->bonus/100);
        $insert_db_orders->discount = 0;
        $total_price = $price + $shipping_total;

        if (Auth::guard('c_user')->user()->ewallet <  $total_price) {
            if ($rs->type == 'promotion') {
                DB::rollback();
                return redirect('cart/promotion')->withError('Unable to pay because Ewallet does not have enough money to pay.');
            }else{
                DB::rollback();
                return redirect('cart/other')->withError('Unable to pay because Ewallet does not have enough money to pay.');
            }


        }
        $insert_db_orders->shipping_price = $shipping_total;
        $insert_db_orders->total_price = $total_price;
        $insert_db_orders->pv_total = $pv_total;
        $insert_db_orders->tax = 0;
        $insert_db_orders->tax_total = 0;
        $insert_db_orders->type = $rs->type;


        $insert_db_orders->order_status_id_fk = 2;
        $insert_db_orders->quantity = $quantity;
        $insert_db_orders->code_order = $code_order;



        try {
            DB::BeginTransaction();

            $insert_db_orders->save();

            $insert_order_products_list::insert($insert_db_products_list);

            $run_payment = ConfirmCartController::run_payment($code_order);


            Cart::session($rs->type)->clear();

            if ($run_payment['status'] == 'success') {
                DB::commit();
                return redirect('order_history')->withSuccess($run_payment['message']);
            } else {
                DB::rollback();
                return redirect('order_history')->withError($run_payment['message']);
            }
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            // info($e->getMessage());
            $resule = ['status' => 'fail', 'message' => 'Order Update Fail', 'id' => $insert_db_orders->id];
            return redirect('Order')->withError('Order Update Fail');
        }
    }

    public function run_payment($code_order)
    {
        $order = DB::table('db_orders')
            ->where('code_order', '=', $code_order)
            ->where('order_status_id_fk', '=', 2)
            ->first();


        if ($order) {

            $order_update = Orders::find($order->id);

            if ($order->status_payment_sent_other == 1) {
                $customer_id = $order->customers_sent_id_fk;
            } else {
                $customer_id = $order->customers_id_fk;
            }


            $customer_update = Customers::find($customer_id);

            if ($customer_update->ewallet_use == '' || empty($customer_update->ewallet_use)) {
                $ewallet_use = 0;
            } else {

                $ewallet_use = $customer_update->ewallet_use;
            }


            if ($customer_update->bonus_total == '' || empty($customer_update->bonus_total)) {
                $bonus_total = 0;
            } else {

                $bonus_total = $customer_update->bonus_total;
            }

            if ($customer_update->pv_all == '' || empty($customer_update->pv_all)) {
                $pv_all = 0;
            } else {

                $pv_all = $customer_update->pv_all;
            }

            $customer_update->ewallet_use = $ewallet_use;
            $customer_update->bonus_total = $bonus_total;
            $pv_old = $customer_update->pv;
            $order_update->pv_old = $customer_update->pv;
            $ewallet_old = $customer_update->ewallet;
            $order_update->ewallet_old = $ewallet_old;
            $order_update->ewallet_price = $order->total_price;

            $customer_update->pv_all = $pv_all + $order->pv_total;
            $pv_balance = $customer_update->pv + $order->pv_total;
            $customer_update->pv = $pv_balance;
            $ewallet = $ewallet_old - $order->total_price;

            if ($ewallet < 0) {
                $resule = ['status' => 'fail', 'message' => 'Your order was unsuccessful. Your ewallet does not have enough space'];
                return $resule;
            } else {
                $customer_update->ewallet =  $ewallet;
            }


            $pv_banlance = $customer_update->pv + $order->pv_total;
            $order_update->pv_banlance = $pv_banlance;
            $order_update->ewallet_banlance = $ewallet;
            $order_update->order_status_id_fk = 5;


            $resule = ['status' => 'success', 'message' => 'Order Success'];

            $order_update->save();
            $customer_update->save();

            $dataPrepare = [
                'transaction_code' => $order->code_order,
                'customers_id_fk' => $order->customers_id_fk,
                'customer_username' => $order->customers_user_name,
                'amt' => $order->total_price,
                'old_balance' => $customer_update->ewallet,
                'balance' => $ewallet,
                'type' => 4,
                'receive_date' => now(),
                'receive_time' => now(),
                'status' => 2,
            ];

            $query =  eWallet::create($dataPrepare);
            return $resule;
        } else {
            $resule = ['status' => 'fail', 'message' => 'Unsuccessful ordering Please check the product list on the product history page.'];
            return $resule;
        }
    }
}
