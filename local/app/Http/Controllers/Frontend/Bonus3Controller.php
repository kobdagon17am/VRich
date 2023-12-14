<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class Bonus3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function bonus_all()
    {
        return view('frontend/bonus-all');
    }


    public function bonus_fastStart()
    {
        return view('frontend/bonus-fastStart');
    }

    public function bonus_team()
    {
        return view('frontend/bonus-team');
    }


    public function bonus_cashback()
    {
        return view('frontend/bonus-cashback');
    }

    public function bonus_cashback_detail($user_name)
    {

        // $Shipping_type = Shipping_type::get();
        // $branch = DB::table('branch')
        //     ->where('status', '=', 1)
        //     ->get();



        return view('frontend/bonus-cashback-detail',compact('user_name'));
    }



    public function datatable_casback(Request $request)
    {


        $report_cashback = DB::table('report_cashback')
        ->where('user_name', Auth::guard('c_user')->user()->user_name)
        // ->whereRaw(("case WHEN  '{$request->route}' != ''  THEN  route = '{$request->route}' else 1 END"))
        ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
        ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
        ->orderByDesc('id');





        $sQuery = Datatables::of($report_cashback);
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

          ->addColumn('date_start', function ($row) {
            return $row->date_start;
          })

          ->addColumn('date_end', function ($row) {
            return $row->date_end;
          })

          ->addColumn('year', function ($row) {
            return $row->year;
          })

          ->addColumn('route', function ($row) {
            return $row->route;
          })

          ->addColumn('status', function ($row) {
            return $row->status;
          })


          ->addColumn('note', function ($row) {
            return $row->note;
          })
          ->addColumn('detail', function ($row) {
            $url = route('bonus_cashback_detail',['user_name'=>$row->user_name]);
           $detail =  '<a type="button" target="_blank" class="btn btn-info btn-sm" href="'.$url.'">
                    <i class="bx bx-search"></i></a>';

            return $detail;
          })



          ->rawColumns(['detail'])

          ->make(true);
      }

      public function datatable_casback_detail(Request $request)
      {

          $report_cashback = DB::table('report_cashback_orderlist')
          ->where('user_name', Auth::guard('c_user')->user()->user_name)
          ->whereRaw(("case WHEN  '{$request->route}' != ''  THEN  route = '{$request->route}' else 1 END"))
          ->whereRaw(("case WHEN  '{$request->month}' != ''  THEN  month = '{$request->month}' else 1 END"))
          ->whereRaw(("case WHEN  '{$request->year}' != ''  THEN  year = '{$request->year}' else 1 END"))
          ->orderByDesc('id');




          $sQuery = Datatables::of($report_cashback);
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

            ->addColumn('date_start', function ($row) {
              return $row->date_start;
            })

            ->addColumn('date_end', function ($row) {
              return $row->date_end;
            })

            ->addColumn('year', function ($row) {
              return $row->year;
            })




            ->addColumn('route', function ($row) {
              return $row->route;
            })



            ->addColumn('note', function ($row) {
              return $row->note;
            })
            ->addColumn('detail', function ($row) {
              $url = route('admin/bonus2_detail',['user_name'=>$row->user_name]);
              $detail = '<a href="'.$url.'" target="_blank"> <i class="las la-search font-25 text-warning" ></i> </a>';
              return $detail;
            })



            ->rawColumns(['detail'])

            ->make(true);
        }




    public function bonus_matching()
    {
        return view('frontend/bonus-matching');
    }

    public function bonus_history()
    {
        return view('frontend/bonus-history');
    }
}
