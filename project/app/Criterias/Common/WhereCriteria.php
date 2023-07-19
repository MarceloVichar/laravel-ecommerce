<?php

namespace App\Criterias\Common;

use App\Criterias\Criteria;
use Spatie\QueryBuilder\QueryBuilder;

class WhereCriteria extends Criteria
{

    /**
     * Arguments for with clause
     * @var array
     */
    private $arguments;

    public function __construct()
    {
        $this->arguments = func_get_args();
    }

    public function apply(QueryBuilder $model): QueryBuilder
    {
        return $model->where(...$this->arguments);
    }
}
