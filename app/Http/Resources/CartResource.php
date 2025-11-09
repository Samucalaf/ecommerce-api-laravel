<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $itemsCount = $this->whenLoaded('items') ? $this->items->count() : 0;
        return [
            'status' => $this->status,
            'items_count_message' => "This cart contains {$itemsCount} " . ($itemsCount === 1 ? 'product' : 'products') . '.',
            'products' => ProductInCartResource::collection($this->whenLoaded('items')),
            'total_price' => number_format($this->calculateTotal(), 2),
        ];
    }
}
