<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'trading_name' => $this->name,
            'cnpj' => $this->cnpj,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'owner_id' => $this->owner_id,
        ];
    }
}
