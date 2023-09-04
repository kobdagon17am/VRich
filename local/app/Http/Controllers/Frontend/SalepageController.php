<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use Auth;

class SalepageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('customer');
    // }


    public function serum($user_name = '')
    {
      // return redirect('salepage/warring');

      $data = DB::table('customers')
        ->select(
          'db_salepage_setting.*',
          // 'customers_detail.tel_mobile',
          'customers.user_name',
          'customers.name',
          'customers.last_name',
          'customers.business_name',
          'customers.profile_img',
          'customers.email',
          'customers.business_location_id'
        )
        ->leftjoin('db_salepage_setting', 'customers.user_name', '=', 'db_salepage_setting.customers_username')
        // ->leftjoin('customers_detail', 'customers_detail.user_name', '=', 'customers.user_name')
        ->where('customers.user_name', '=', $user_name)
        // ->orwhere('db_salepage_setting.name_s3', '=', $user_name)
        ->first();

        if(!$data){
          $data = DB::table('customers')
          ->select(
            'db_salepage_setting.*',
            // 'customers_detail.tel_mobile',
            'customers.user_name',
            'customers.name',
            'customers.last_name',
            'customers.business_name',
            'customers.profile_img',
            'customers.email',
            'customers.business_location_id'
          )
          ->leftjoin('db_salepage_setting', 'customers.user_name', '=', 'db_salepage_setting.customers_username')
          // ->leftjoin('customers_detail', 'customers_detail.user_name', '=', 'customers.user_name')
          // ->where('customers.user_name', '=', $user_name)
          // ->orwhere('db_salepage_setting.name_s3', '=', $user_name)
          ->where('db_salepage_setting.name_s3', '=', $user_name)
          ->first();
        }

        $business_location_id = @$data->business_location_id;
        if (empty($business_location_id)) {
            $business_location_id = 1;
        }


      if ($data) {
        $rs = ['stattus' => 'success', 'data' => $data];

        if( $business_location_id  == 1){
          return view('frontend/salepage/serum', compact('rs'));
        }else{
          return view('frontend/salepage/serum', compact('rs'));
        }

      } else {
        return view('frontend/alert/Error');
      }
    }

    public function coffee($user_name = '')
    {
      // return redirect('salepage/warring');

      $data = DB::table('customers')
        ->select(
          'db_salepage_setting.*',
          // 'customers_detail.tel_mobile',
          'customers.user_name',
          'customers.name',
          'customers.last_name',
          'customers.business_name',
          'customers.profile_img',
          'customers.email',
          'customers.business_location_id'
        )
        ->leftjoin('db_salepage_setting', 'customers.user_name', '=', 'db_salepage_setting.customers_username')
        // ->leftjoin('customers_detail', 'customers_detail.user_name', '=', 'customers.user_name')
        ->where('customers.user_name', '=', $user_name)
        // ->orwhere('db_salepage_setting.name_s3', '=', $user_name)
        ->first();

        if(!$data){
          $data = DB::table('customers')
          ->select(
            'db_salepage_setting.*',
            // 'customers_detail.tel_mobile',
            'customers.user_name',
            'customers.name',
            'customers.last_name',
            'customers.business_name',
            'customers.profile_img',
            'customers.email',
            'customers.business_location_id'
          )
          ->leftjoin('db_salepage_setting', 'customers.user_name', '=', 'db_salepage_setting.customers_username')
          // ->leftjoin('customers_detail', 'customers_detail.user_name', '=', 'customers.user_name')
          // ->where('customers.user_name', '=', $user_name)
          // ->orwhere('db_salepage_setting.name_s3', '=', $user_name)
          ->where('db_salepage_setting.name_s3', '=', $user_name)
          ->first();
        }

        $business_location_id = @$data->business_location_id;
        if (empty($business_location_id)) {
            $business_location_id = 1;
        }


      if ($data) {
        $rs = ['stattus' => 'success', 'data' => $data];

        if( $business_location_id  == 1){
          return view('frontend/salepage/coffee', compact('rs'));
        }else{
          return view('frontend/salepage/coffee', compact('rs'));
        }

      } else {
        return view('frontend/alert/Error');
      }
    }
}
