<?php

namespace App\Data;

class ProductCategoryData
{
    public function __construct(
        public string $name,
        public string $description = ""
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
