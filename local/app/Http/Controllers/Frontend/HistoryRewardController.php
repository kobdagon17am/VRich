<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class HistoryRewardController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }


    public function index()
    {
        return view('frontend/history_reward');
    }


    public function datatable_reward(Request $request)
    {



        $reward = DB::table('pv_per_month')

        ->where('user_name', Auth::guard('c_user')->user()->user_name)
        ->where('reward','>',0)
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

            ->addColumn('reward', function ($row) {
                return $row->reward;
            })


            ->addColumn('note', function ($row) {
                return $row->note;
            })



            ->make(true);
    }
}
