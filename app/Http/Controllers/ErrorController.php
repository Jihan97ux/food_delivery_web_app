<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error()
    {
        return view('error.error');   
    }

    public function errorPaymentUnfinish(Request $request)
    {
        $request->session()->forget('order');
        return view('error.payment_unfinish');
    }

    public function errorPaymentFailed(Request $request)
    {
        $request->session()->forget('order');
        return view('error.payment_error');
    }
}
