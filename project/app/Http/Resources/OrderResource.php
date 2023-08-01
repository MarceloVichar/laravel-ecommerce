<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'company_id' => $this->company_id,
            'client' => new UserResource($this->whenLoaded('client')),
            'client_id' => $this->client_id,
            'status' => $this->status
        ];
    }
}
