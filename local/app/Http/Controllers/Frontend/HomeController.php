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
    $News = DB::table('news')
    ->select('news.*', 'news_images.news_image_url','news_images.news_image_name')
    ->leftjoin('news_images', 'news_images.news_id_fk', '=', 'news.id')
    ->where('news.news_status','=',1)
    // ->orderby('id','DESC')
    ->paginate(6);


    $data = array(
        'News' => $News
    );
    return view('frontend/home', $data);
  }

  public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }

}
