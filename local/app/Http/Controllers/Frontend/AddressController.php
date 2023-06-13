<?php

namespace App\Http\Controllers\Frontend;

// use App\AddressDistrict;
// use App\AddressProvince;
// use App\AddressTambon;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }


    function getProvince(Request $request)
    {

        if(Auth::guard('c_user')->user()->business_location_id  == '1' || Auth::guard('c_user')->user()->business_location_id  == null ){
            $business_location_id = 1;
           }else{
            $business_location_id = 3;

           }


        $province = DB::table('dataset_provinces')
        ->select('*')
        ->where('business_location_id',$business_location_id)
        ->get();

        // $province = AddressProvince::orderBy('province_name', 'ASC')->get();


        return response()->json($province);
    }
    function getDistrict(Request $request)
    {

        $district = DB::table('dataset_amphures')
        ->select('*')
        ->where('province_id',$request->province_id)
        ->get();
        return response()->json($district);
    }

    function getTambon(Request $request)
    {
        // $tambon = AddressTambon::where('district_id', $request->district_id)
        //     ->orderBy('tambon_name', 'ASC')
        //     ->get();

        $tambon = DB::table('dataset_districts')
            ->select('*')
            ->where('id',$request->district_id)
            ->get();
        return response()->json($tambon);
    }

    function getZipcode(Request $request)
    {
        $tambon = AddressTambon::where('tambon_id', $request->tambon_id)
            ->orderBy('tambon_name', 'ASC')
            ->first();
        return response()->json($tambon);
    }
}
