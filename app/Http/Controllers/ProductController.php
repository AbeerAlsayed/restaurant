<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    public function index()
    {
        $products=Product::with('category')->get();
        return ProductResource::collection($products);
    }

}
