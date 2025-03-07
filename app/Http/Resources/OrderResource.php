<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'subtotal' => $this->subtotal,
            'service_charge' => $this->service_charge,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'table' => [
                'id' => $this->table->id,
                'table_number' => $this->table->table_number,
                'status' => $this->table->status,
                'guests_count' => $this->table->guests_count ?? 0,

            ],
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                ];
            }),
        ];
    }
}
