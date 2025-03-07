<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'products'])->get();
        return OrderResource::collection($orders);
    }
}
