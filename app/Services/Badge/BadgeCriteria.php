<?php

namespace App\Services\Badge;
use App\Models\Badge\BadgeCriteria;


class BadgeCriteriaService
{
    private $model;

    public function __construct(BadgeCriteria $model)
    {
        $this->model = $model;
    }
}
