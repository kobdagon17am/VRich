<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }
    public function index()
    {
        return view('frontend/upgradePosition');
    }
}
