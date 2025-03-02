<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required',
            'amount' => 'required|numeric',
        ]);

        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }
}
