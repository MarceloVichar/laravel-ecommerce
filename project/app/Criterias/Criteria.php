<?php

namespace App\Criterias;

use Spatie\QueryBuilder\QueryBuilder;

abstract class Criteria
{
    /**
     * @param QueryBuilder $model
     * @return mixed
     */
    abstract public function apply(QueryBuilder $model): QueryBuilder;
}
