<?php

namespace App\Http\Resources;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->name,
            'value_cents' => (int) $this->value_cents,
            'available_quantity' => (int) $this->available_quantity,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'category' => new ProductCategoryResource($this->whenLoaded('category')),
            'category_id' => $this->category_id,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'company_id' => $this->company_id,
        ];
    }
}
