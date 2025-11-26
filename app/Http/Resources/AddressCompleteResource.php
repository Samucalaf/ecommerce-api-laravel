<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressCompleteResource extends JsonResource
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
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->whenNotNull($this->complement),
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'federation_unit' => $this->federation_unit,
            'zip_code' => $this->zip_code,
        ];
    }
}
