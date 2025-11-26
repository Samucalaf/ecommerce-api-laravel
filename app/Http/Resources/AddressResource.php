<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'owner' => $this->owner,
            'city' => $this->city,
            'federation_unit' => $this->federation_unit,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
        ];
    }
}
