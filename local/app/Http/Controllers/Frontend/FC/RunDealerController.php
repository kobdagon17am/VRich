<?php

namespace App\Http\Controllers\Frontend\FC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\eWallet;

class RunDealerController extends Controller
{
    public static $arr = array();
    //App\Http\Controllers\Frontend\FC\RunDealerController::RunDealer($user_name);
    public static function RunDealer($user_name)
    {
        $year  =  date('Y');
        $month =  date('m');
        $day =  date('d');

        $customers_all =  DB::table('customers')
        ->select('id', 'pv', 'user_name', 'introduce_id', 'qualification_id')
        ->where('user_name', '=',  $user_name)
        ->orderby('id')
        ->get();
       // dd($customers_all);

       if(count($customers_all) == 0){
        return 'fail';
       }

       $i=0;
        try {
            DB::BeginTransaction();
        foreach($customers_all as $value){
            $i++;
            $data =  \App\Http\Controllers\Frontend\FC\RunDealerController::all_upline($value->user_name);
            if(@$data['username']){
                $dealer =  count($data['username']);
            }else{
                $dealer = 0;
            }

            DB::table('customers')
            ->where('user_name', '=', $value->user_name)
            ->update(['dealer' => $dealer]);


            $dataPrepare = [
                'user_name' => $value->user_name,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'dealer' => $dealer,
            ];

            DB::table('dealer_log')
                ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);
                self::$arr = array();
        }

        DB::commit();
        return  'success '.$i;
        } catch (Exception $e) {
            DB::rollback();
            return 'fail';
        }


    }

    public static function RunDealer_all($year,$month)
    {
        // $year  =  date('Y');
        // $month =  date('m');
        $day =  date('d');

        $customers_all =  DB::table('customers')
        ->select('id', 'pv', 'user_name', 'introduce_id', 'qualification_id')
        //  ->where('user_name','VR2300032')
        ->orderby('id')
        ->get();
       // dd($customers_all);

       if(count($customers_all) == 0){
        return 'fail';
       }

       $i=0;
        try {
            DB::BeginTransaction();
        foreach($customers_all as $value){
            $i++;
            $data =  \App\Http\Controllers\Frontend\FC\RunDealerController::all_upline($value->user_name);

            if(@$data['username']){
                $dealer =  count($data['username']);
            }else{
                $dealer = 0;
            }
            DB::table('customers')
            ->where('user_name', '=', $value->user_name)
            ->update(['dealer' =>$dealer]);


            $dataPrepare = [
                'user_name' => $value->user_name,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'dealer' => $dealer,
            ];

            DB::table('dealer_log')
                ->updateOrInsert(['user_name' => $value->user_name, 'year' => $year, 'month' => $month], $dataPrepare);
                self::$arr = array();

        }

        DB::commit();
        return  'success '.$i;
        } catch (Exception $e) {
            DB::rollback();
            return 'fail';
        }


    }

    //App\Http\Controllers\Frontend\FC\RunDealerController::all_upline();

    public static function all_upline($user_name){
        $introduce = self::tree($user_name)->flatten();
        $data = ['status'=>'success','username'=>@self::$arr['username'],'name'=>@self::$arr['name']];
        return $data;
    }


    public static function tree($user_name)
    {
        $user = DB::table('customers')
        ->select(
        'customers.id',
        'customers.user_name',
        'customers.name',
        'customers.last_name',
        'customers.introduce_id',
        'customers.qualification_id',
        'customers.status_customer',
        )

    ->where('customers.user_name', '=', $user_name)
    ->first();

        $all_upline = self::user_upline($user_name, null);
        //self::formatTree($c);
        RunDealerController::formatTree($all_upline);
        return $all_upline;
    }


    public static function user_upline($user_name)
    {

        $introduce = DB::table('customers')
        ->select(
            'customers.id',
            'customers.user_name',
            'customers.name',
            'customers.last_name',
            'customers.introduce_id',
            'customers.qualification_id',
            'customers.status_customer',

        )
        ->where('customers.introduce_id', '=', $user_name);

        return $introduce->get();
    }

    public static function formatTree($introduce_id,$num = 0,$i=0)
    {
        $num += 1;
        foreach ($introduce_id as $introduce) {
        $introduce->lv = $num;
        $introduce->children = self::user_upline($introduce->user_name);

        if ($introduce->children->isNotEmpty()) {


            if($introduce->qualification_id >= 3 and $introduce->status_customer != 'cancel'){

                self::$arr['username'][] = $introduce->user_name;
                self::$arr['name'][$introduce->user_name] = $introduce->name.' '.$introduce->last_name.'('.$introduce->qualification_id.')' ;
            }
            self::formatTree($introduce->children, $num,$i);

        } else {

            if($introduce->qualification_id >= 3 and $introduce->status_customer != 'cancel'){

                self::$arr['username'][] = $introduce->user_name;
                self::$arr['name'][$introduce->user_name] = $introduce->name.' '.$introduce->last_name.'('.$introduce->qualification_id.')' ;
            }
        }
        }
    }





}
