<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'table_number' => $this->table_number,
            'floor' => $this->floor,
            'status' => $this->status,
            'reserved_by' => $this->reserved_by ? [
                'id' => $this->reserved_by,
                'name' => $this->reservedBy?->name, // Assuming there is a relation to User model
            ] : null,
            'guests_count' => $this->guests_count ?? 0,
            'capacity' => $this->capacity,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
