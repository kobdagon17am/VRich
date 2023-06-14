<?php

namespace App\Http\Controllers\Frontend;

use App\Customers;
// use App\AddressProvince;
use App\CustomersAddressCard;
use App\CustomersAddressDelivery;
use App\CustomersBank;
use App\CustomersBenefit;
use App\Jang_pv;
use App\eWallet;
use App\Report_bonus_register;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class RegisterController extends Controller
{
    public function index()
    {



        $yeay = date('Y');
        $age_min = 17;
        $yeay_thai = date("Y", strtotime($yeay)) - $age_min;
        $arr_year = [];
        $age_max = 61;
        for ($i = 1; $i < $age_max; $i++) {
            $arr_year[] = date("Y", strtotime($yeay_thai)) - $i;
        }
        // END  data year   ::: age_min 20 age_max >= 80
        $bank = DB::table('dataset_bank')
            ->get();

        // BEGIN Day
        $day = [];
        for ($i = 1; $i < 32; $i++) {
            $day[] = $i;
        }
        // END Day
        rsort($arr_year);

        if(Auth::guard('c_user')->user()->business_location_id  == '1' || Auth::guard('c_user')->user()->business_location_id  == null ){
            $business_location_id = 1;
           }else{
            $business_location_id = 3;

           }


        $province = DB::table('dataset_provinces')
        ->select('*')
        ->where('business_location_id',$business_location_id)
        ->get();

        // $nation_id = DB::table('db_country')
        // ->select('*')
        // ->get();

        $customers_id = Auth::guard('c_user')->user()->id;
        // $customers_up = Auth::guard('c_user')->user()->upline_id;
        // $customers_data = Auth::guard('c_user')->user()->where('user_name', $customers_up)->first();


        $dataset_qualification = DB::table('dataset_qualification')
        ->where('status',1)
        ->get();

        return view('frontend/register')
            ->with('day', $day)
            ->with('bank', $bank)
            ->with('arr_year', $arr_year)
            ->with('dataset_qualification',$dataset_qualification)
            ->with('province', $province);
    }

    public function pv(Request $request)
    {
        $result = DB::table('dataset_qualification')->where('code', $request->val)->first();
        return $result->pv;
    }


    public function store_register(Request $request)
    {
        //dd($request->all());
        //return response()->json(['status' => 'fail', 'ms' => 'ลงทะเบียนไม่สำเร็จกรุณาลงทะเบียนไหม่sss']);


        // เช็ค PV Sponser
        $sponser = Customers::where('user_name', $request->sponser)->first();
        // if ($sponser->pv < $request->pv || $request->pv < 20) {
        //     return response()->json(['pvalert' => 'PV ของท่านไม่เพียงพอ']);
        // }

         $pv_register = $request->pv;
        // End PV Sponser

        //BEGIN data validator
        $rule = [
            // BEGIN ข้อมูลส่วนตัว
            'sizebusiness' => 'required',
            'prefix_name' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'business_name' => 'required',
            // 'id_card' => 'required|min:13|unique:customers',
            'phone' => 'required|numeric',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'nation_id' => 'required',
            'phone' => 'required|numeric',
            // END ข้อมูลส่วนตัว

            // BEGIN ที่อยู่ตามบัตรประชาชน
            'file_card' => 'required|mimes:jpeg,jpg,png',
            'card_address' => 'required',
            // 'card_moo' => 'required',
            // 'card_soi' => 'required',
            // 'card_road' => 'required',
            'card_province' => 'required',
            'card_district' => 'required',
            'card_tambon' => 'required',
            // 'card_zipcode' => 'required',
            // END ที่อยู่ตามบัตรประชาชน

            //  BEGIN ที่อยู่จัดส่ง
            'same_address' => 'required',
            // 'same_moo' => 'required',
            // 'same_soi' => 'required',
            // 'same_road' => 'required',
            'same_province' => 'required',
            'same_district' => 'required',
            'same_tambon' => 'required',
            // 'same_zipcode' => 'required',
            // END ที่อยู่จัดส่ง
        ];
        $message_err = [
            // BEGIN ข้อมูลส่วนตัว
            'sizebusiness.required' => 'Please enter the data',
            'prefix_name.required' => 'Please enter the data',
            'name.required' => 'Please enter the data',
            'last_name.required' => 'Please enter the data',
            'gender.required' => 'Please enter the data',

            'id_card.required' => 'Please enter the data',
            // 'id_card.min' => 'กรุณากรอกให้ครบ 13 หลัก',
            'id_card.unique' => 'This ID card number is already in use',
            'phone.required' => 'Please enter the data',
            'phone.numeric' => 'เป็นตัวเลขเท่านั้น',
            'day.required' => 'Please enter the data',
            'month.required' => 'Please enter the data',
            'year.required' => 'Please enter the data',
            'nation_id.required' => 'Please enter the data',
            'id_card.required' => 'Please enter the data',
            'phone.required' => 'Please enter the data',
            // END ข้อมูลส่วนตัว

            // BEGIN ที่อยู่ตามบัตรประชาชน
            'file_card.required' => 'Please enter the data',
            'file_card.mimes' => 'Only jpeg, jpg, png files are supported',
            'card_address.required' => 'Please enter the data',
            'card_moo.required' => 'Please enter the data',
            'card_soi.required' => 'Please enter the data',
            'card_road.required' => 'Please enter the data',
            'card_province.required' => 'Please enter the data',
            'card_district.required' => 'Please enter the data',
            'card_tambon.required' => 'Please enter the data',
            'card_zipcode.required' => 'Please enter the data',
            // END ที่อยู่ตามบัตรประชาชน

            // BEGIN ที่อยู่จัดส่ง
            'same_address.required' => 'Please enter the data',
            'same_moo.required' => 'Please enter the data',
            'same_soi.required' => 'Please enter the data',
            'same_road.required' => 'Please enter the data',
            'same_province.required' => 'Please enter the data',
            'same_district.required' => 'Please enter the data',
            'same_tambon.required' => 'Please enter the data',
            'same_zipcode.required' => 'Please enter the data',
            'card_phone.required' => 'Please enter the data',
            'same_phone.required' => 'Please enter the data',


            // END ที่อยู่จัดส่ง

        ];


        if ($request->file_bank) {

            $rule['file_bank'] = 'mimes:jpeg,jpg,png';
            $message_err['file_bank.mimes'] = 'Only jpeg, jpg, png files are supported';

            $rule['bank_name'] = 'required';
            $message_err['bank_name.required'] = 'Please enter the data';

            $rule['bank_branch'] = 'required';
            $message_err['bank_branch.required'] = 'Please enter the data';

            $rule['bank_no'] = 'required|numeric';
            $message_err['bank_no.required'] = 'Please enter the data';
            $message_err['bank_no.numeric'] = 'Enter numbers only';

            $rule['account_name'] = 'required';
            $message_err['account_name.required'] = 'Please enter the data';
        }

        if ($request->name_benefit) {
            $rule['last_name_benefit'] = 'required';
            $message_err['last_name_benefit.required'] = 'Please enter the data';
            $rule['involved'] = 'required';
            $message_err['involved.required'] = 'Please enter the data';
        }

        $validator = Validator::make(
            $request->all(),
            $rule,
            $message_err
        );
        //END data validator


        if (!$validator->fails()) {
            //BEGIN วันเกิด
            $day = $request->day;
            $month = $request->month;
            $year = $request->year;

            $YMD = $year . "-" . $month . "-" . $day;

            $birth_day = date('Y-m-d', strtotime($YMD));
            // END วันเกิด
            $password = substr($request->id_card, -4);



            // END generatorusername เอา 7 หลัก



            $start_month = date('Y-m-d');
            $mt_mount_new = strtotime("+33 Day", strtotime($start_month));


            try {
                DB::BeginTransaction();

                $user_name = \App\Http\Controllers\Frontend\RegisterController::gencode_customer();

                $customer = [
                    'user_name' => $user_name,
                    'expire_date' => date('Y-m-d', $mt_mount_new),
                    'password' => md5($password),

                    'pv_upgrad' =>$request->pv,
                    'introduce_id' => $request->sponsor,
                    'prefix_name' => $request->prefix_name,
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'business_name' => $request->business_name,
                    'id_card' => $request->id_card,
                    'phone' => $request->phone,
                    'birth_day' => $birth_day,
                    'nation_id' => $request->nation_id,
                    'business_location_id' => $request->nation_id,
                    'qualification_id' => $request->sizebusiness,
                    'id_card' => $request->id_card,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'line_id' => $request->line_id,
                    'vvip_register_type' => 'register',
                    'facebook' => $request->facebook,
                    'telegrams' => $request->telegrams,
                    'regis_doc4_status' => 0,
                    'regis_doc1_status' => 3,
                ];




                // หัก PV Sponser
                $sponser = Customers::where('user_name', $request->sponser)->first();
                // End PV Sponser



                $insert_customer = Customers::create($customer);




                if ($request->file_card) {

                    $url = 'local/public/images/customers_card/' . date('Ym');
                    $imageName = $request->file_card->extension();
                    $filenametostore =  date("YmdHis") . '.' . $insert_customer->id . "." . $imageName;
                    $request->file_card->move($url,  $filenametostore);

                    $CustomersAddressCard = [
                        'customers_id' => $insert_customer->id,
                        'user_name' => $user_name,
                        'url' => $url,
                        'img_card' => $filenametostore,
                        'address' => $request->card_address,
                        'moo' => $request->card_moo,
                        'soi' => $request->card_soi,
                        'road' => $request->card_road,
                        'tambon' => $request->card_tambon,
                        'district' => $request->card_district,
                        'province' => $request->card_province,
                        'zipcode' => $request->card_zipcode,
                        'phone' => $request->card_phone,
                    ];

                    // $query_address_card = CustomersAddressCard::create($CustomersAddressCard);
                    $query_address_card = CustomersAddressCard::updateOrInsert([
                        'customers_id' => $insert_customer->id
                    ], $CustomersAddressCard);

                    //END ข้อมูล บัตรประชาชน

                    //BEGIN สถานะว่า เอาข้อมูลมาจากไหน 1= บปช , 2= กรอกมาเอง
                    if ($request->status_address) {
                        $status_address = 1;
                    } else {
                        $status_address = 2;
                    }
                    //END สถานะว่า เอาข้อมูลมาจากไหน 1= บปช , 2= กรอกมาเอง
                    // BEGIN ที่อยู่ในการจัดส่ง
                    $CustomersAddressDelivery = [
                        'customers_id' => $insert_customer->id,
                        'user_name' => $user_name,
                        'address' => $request->same_address,
                        'moo' => $request->same_moo,
                        'soi' => $request->same_soi,
                        'road' => $request->same_road,
                        'tambon' => $request->same_tambon,
                        'district' => $request->same_district,
                        'province' => $request->same_province,
                        'zipcode' => $request->same_zipcode,
                        'phone' => $request->same_phone,
                        'status' => $status_address,
                    ];

                    $query_address_delivery = CustomersAddressDelivery::updateOrInsert([
                        'customers_id' => $insert_customer->id
                    ], $CustomersAddressDelivery);
                    // $query_address_delivery = CustomersAddressDelivery::create($CustomersAddressDelivery);
                    // END ที่อยู่ในการจัดส่ง

                    // BEGIN ข้อมูลธนาคาร
                    if ($request->file_bank) {

                        $url = 'local/public/images/customers_bank/' . date('Ym');
                        $imageName = $request->file_bank->extension();
                        $filenametostore =  date("YmdHis") . '.' . $insert_customer->id . "." . $imageName;
                        $request->file_bank->move($url,  $filenametostore);

                        $bank = DB::table('dataset_bank')
                            ->where('id', '=', $request->bank_name)
                            ->first();

                        $CustomersBank = [
                            'customers_id' => $insert_customer->id,
                            'user_name' => $user_name,
                            'url' => $url,
                            'img_bank' => $filenametostore,
                            'bank_name' => $bank->name,
                            'bank_id_fk' => $bank->id,
                            'code_bank' => $bank->code,
                            'bank_branch' => $request->bank_branch,
                            'bank_no' => $request->bank_no,
                            'account_name' => $request->account_name
                            // 'regis_doc4_status' => 3
                        ];



                        $rquery_bamk = CustomersBank::updateOrInsert([
                            'customers_id' => $insert_customer->id
                        ], $CustomersBank);

                        // $rquery_bamk = CustomersBank::create($CustomersBank);

                        Customers::where('id', $insert_customer->id)->update(['regis_doc4_status' => 3]);
                    }
                    // END ข้อมูลธนาคาร


                    // BEGIN  ผู้รับผลประโยชน์
                    if ($request->name_benefit) {

                        $CustomersBenefit = [
                            'customers_id' => $insert_customer->id,
                            'user_name' => $user_name,
                            'name' => $request->name_benefit,
                            'last_name' => $request->last_name_benefit,
                            'involved' => $request->involved,
                        ];

                        $qurey_customers_benefit = CustomersBenefit::create($CustomersBenefit);
                    }
                    // END  ผู้รับผลประโยชน์

                    $data_result = [
                        'prefix_name' => $request->prefix_name,
                        'name' => $request->name,
                        'last_name' => $request->last_name,
                        'business_name' => $request->business_name,
                        'user_name' => $user_name,
                        'password' => $password,
                    ];


                    DB::commit();
                    return response()->json(['status' => 'success', 'data_result' => $data_result], 200);
                }
            } catch (Exception $e) {
                DB::rollback();
                // dd( $validator->errors());
                return response()->json(['status' => 'fail', 'ms' => '
                Registration unsuccessful. Please try registering again.']);
            }
        }

        //return  redirect('register')->withError('ลงทะเบียนไม่สำเร็จ');
        // dd($validator->errors());

        return response()->json(['ms' => 'Please fill in all the required information before registering', 'error' => $validator->errors()]);
    }


    public static function gencode_customer()
    {

        $y = date('Y');
        $y = substr($y, -2);
        $code =  IdGenerator::generate([
            'table' => 'customer_code',
            'field' => 'code',
            'length' => 9,
            'prefix' => 'VR'.$y,
            'reset_on_prefix_change' => true
        ]);

          $ck_code = DB::table('customer_code')
          ->where('code','=',$code)
          ->first();

          if(empty($ck_code)){
              $rs_code_order = DB::table('customer_code')
              ->Insert(['code' => $code]);
              if ($rs_code_order == true) {
                  return  $code;
                } else {
                  \App\Http\Controllers\Frontend\RegisterController::gencode_customer();
                }

          }else{
            \App\Http\Controllers\Frontend\RegisterController::gencode_customer();
          }

    }



}
