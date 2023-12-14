<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class Bonus7Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }


    public function index()
    {

        return view('frontend/bonus7');
    }


    public function datatable_bonus7(Request $request)
    {

        $reward = DB::table('report_bonus7')

        ->where('user_name', Auth::guard('c_user')->user()->user_name)

        ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
        ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
        ->orderByDesc('id');


        $sQuery = Datatables::of($reward);
        return $sQuery


            ->addColumn('user_name', function ($row) {
                return $row->user_name;
            })

            ->addColumn('name', function ($row) {
                return $row->name;
            })

            ->addColumn('last_name', function ($row) {
                return $row->last_name;
            })


            ->addColumn('qualification', function ($row) {
                return $row->qualification;
            })

            ->addColumn('month', function ($row) {
                return $row->month;
            })



            ->addColumn('year', function ($row) {
                return $row->year;
            })

            ->addColumn('pv', function ($row) {
                return $row->pv;
            })

            ->addColumn('reth', function ($row) {
                return $row->reth;
            })

            ->addColumn('bonus_total_usd', function ($row) {
                return $row->bonus_total_usd;
            })

            ->addColumn('status', function ($row) {
                return $row->status;
              })



            ->addColumn('note', function ($row) {
                return $row->note;
            })


            ->make(true);
    }
}
