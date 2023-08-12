<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
public function __construct()
{
    $this->middleware('admin');
}
  public function index()
  {


    return  view('backend.dashboard');

  }
}
