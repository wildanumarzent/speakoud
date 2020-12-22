<?php

namespace App\Services\Badge;
use App\Models\Badge\Badge;


class BadgeService
{
    private $model;

    public function __construct(Badge $model)
    {
        $this->model = $model;
    }
}
