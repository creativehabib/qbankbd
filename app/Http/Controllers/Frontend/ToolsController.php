<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index(){
        return view('frontend.tools.index');
    }

    public function payscaleCalculate(request $request){
        return view('frontend.tools.payscale-calculate');
    }
    public function ageCalculator(request $request){
        //
    }

    public function cgpaCalculator(request $request){
        //
    }

    public function unitConverter()
    {
        //
    }
}
