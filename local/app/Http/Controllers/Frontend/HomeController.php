<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use App\News;
use App;

//use App\Http\Controllers\Session;
class HomeController extends Controller
{

  public function __construct()
  {
    $this->middleware('customer');
  }

  public function index()
  {

    $year  =  date('Y');
    $month =  date('m');

    $dealer_log =    DB::table('dealer_log')
    ->where('user_name','=',Auth::guard('c_user')->user()->user_name)
    ->where('year','=',$year)
    ->where('month','=',$month)
    ->count();

    if($dealer_log == 0){
        App\Http\Controllers\Frontend\FC\RunDealerController::RunDealer(Auth::guard('c_user')->user()->user_name);
    }

    $member =    DB::table('customers')
    ->where('customers.introduce_id','=',Auth::guard('c_user')->user()->user_name)
    ->count();

    $member_d = Auth::guard('c_user')->user()->dealer;

    $News = DB::table('news')
    ->select('news.*', 'news_images.news_image_url','news_images.news_image_name')
    ->leftjoin('news_images', 'news_images.news_id_fk', '=', 'news.id')
    ->where('news.news_status','=',1)
    ->orderby('id','DESC')
    ->paginate(6);


    $data = array(
        'News' => $News,
        'member' => $member,
        'member_d' => $member_d
    );
    return view('frontend/home',$data);
  }

  public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }

}
