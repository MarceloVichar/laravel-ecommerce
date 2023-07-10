<?php

namespace App\Support;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationBuilder
{
    private $perPage = 10;
    private $resource;
    private $additional = [];
    private $queryBuilder;

    public function for($subject): self
    {
        $this->queryBuilder = QueryBuilder::for($subject);
        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }


    public function resource($resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    public function criteria($criteria): self
    {
        if (is_iterable($criteria)) {
            foreach ($criteria as $criterion) {
                $criterion->apply($this->queryBuilder);
            }
            return $this;
        }

        $criteria->apply($this->queryBuilder);

        return $this;
    }

    public function build()
    {
        $paginated = $this->queryBuilder
            ->paginate($this->perPage)
            ->appends(request()->query());

        return ($this->resource)
            ? $this->resource::collection($paginated)->additional($this->additional)
            : JsonResource::collection($paginated)->additional($this->additional);
    }

    public function additional(array $additional): self
    {
        $this->additional = $additional;
        return $this;
    }
}
