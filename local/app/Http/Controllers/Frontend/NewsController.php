<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use DB;
class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function news_detail($id)
    {


        $News = DB::table('news')
        ->select('news.*', 'news_images.news_image_url','news_images.news_image_name')
        ->leftjoin('news_images', 'news_images.news_id_fk', '=', 'news.id')
        ->where('news.id','=',$id)
        // ->orderby('id','DESC')
        ->first();
        $data = array(
            'News' => $News
        );
        return view('frontend/news-detail', $data);
    }
}
