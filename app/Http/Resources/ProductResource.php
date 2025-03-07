<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'image' => asset('images/' . $this->image),
            'spiciness_level' => $this->spiciness_level,
            'availability_status' => $this->availability_status,
            'gratuity' => $this->gratuity ? 'G' : 'No Gratuity',
            'discount_percentage' => $this->discount_percentage . '%',
            'created_at' => $this->created_at,
            'category' => new CategoryResource($this->category),
        ];
    }
}
