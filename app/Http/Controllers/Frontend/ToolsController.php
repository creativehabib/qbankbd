<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index()
    {
        return view('frontend.tools.index');
    }

    public function payscaleCalculate(Request $request)
    {
        return view('frontend.tools.payscale-calculate');
    }

    public function ageCalculator(Request $request)
    {
        return view('frontend.tools.age-calculator');
    }

    public function cgpaCalculator(Request $request)
    {
        return view('frontend.tools.cgpa-calculator');
    }

    public function unitConverter()
    {
        return view('frontend.tools.unit-converter');
    }
}
