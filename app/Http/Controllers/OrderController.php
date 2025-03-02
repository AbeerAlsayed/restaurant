<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('orderItems.product')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'user_id' => 'required|exists:users,id',
            'order_items' => 'required|array',
        ]);

        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id' => $request->user_id,
            'status' => 'new',
            'total_price' => 0,
        ]);

        $total = 0;
        foreach ($request->order_items as $item) {
            $total += $item['quantity'] * $item['price'];
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->update(['total_price' => $total]);

        return response()->json($order, 201);
    }
}
