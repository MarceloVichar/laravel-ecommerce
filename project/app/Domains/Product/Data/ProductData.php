<?php

namespace App\Domains\Product\Data;

class ProductData
{
    public function __construct(
        public string $name,
        public string $description,
        public int    $valueCents,
        public int $company_id,
        public int    $availableQuantity = 1,
        public ?int $category_id = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'value_cents' => $this->valueCents,
            'company_id' => $this->company_id,
            'available_quantity' => $this->availableQuantity,
            'category_id' => $this->category_id,
        ];
    }
}
