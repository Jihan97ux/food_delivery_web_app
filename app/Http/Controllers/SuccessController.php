<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuccessController extends Controller
{
    public function successPayment(Request $request)
    {
        $request->session()->forget('order');
        return view('resto.payment-success');
    }
    
    
    // https://f333-2a0d-e487-135f-efe8-4f9-b816-af7a-9b0c.ngrok-free.app/success-payment?order_id=ai&status_code=200&transaction_status=capture
    public function handleSuccess(Request $request)
    {        
        // Ambil data pesanan dari url (query string)
        // $order_id = $request->query('order_id');
        $status_code = $request->query('status_code');
        
        // Ambil data pesanan dari sesi
        // $order_session = $request->session()->get('order');
        // $order_id_session = $order_session['order_id'];

        if ($status_code == 200) {
            return redirect()->route('order.confirmation');
        } else {
            return view('resto.payment-failed');
        }
    }
}
