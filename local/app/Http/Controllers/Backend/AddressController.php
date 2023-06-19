<?php

namespace App\Http\Controllers\Backend;

// use App\AddressDistrict;
// use App\AddressProvince;
use App\AddressTambon;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{



    function getProvince(Request $request)
    {
        //$province = AddressProvince::orderBy('province_name', 'ASC')->get();

        $province = DB::table('dataset_provinces')
        ->select('*')
        // ->where('business_location_id',$business_location_id)
        ->get();

        return response()->json($province);
    }
    function getDistrict(Request $request)
    {
        // $district = AddressDistrict::where('province_id', $request->province_id)
        //     ->orderBy('district_name', 'ASC')
        //     ->get();

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
            ->where('amphure_id',$request->district_id)
            ->get();
        return response()->json($tambon);
    }

    function getZipcode(Request $request)
    {
        // $tambon = AddressTambon::where('tambon_id', $request->tambon_id)
        //     ->orderBy('tambon_name', 'ASC')
        //     ->first();

            $tambon = DB::table('dataset_districts')
            ->select('*')
            ->where('amphure_id',$request->id)
            ->firts();
        return response()->json($tambon);
    }
}
