<?php

namespace App\Domains\Product\Data;

class ProductData
{
    public function __construct(
        public string $name,
        public string $description,
        public int    $valueCents,
        public int    $availableQuantity = 1
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'value_cents' => $this->valueCents,
            'available_quantity' => $this->availableQuantity
        ];
    }
}
