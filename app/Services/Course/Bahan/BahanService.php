<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Services\Course\MateriService;

class BahanService
{
    private $model, $materi;

    public function __construct(
        BahanPelatihan $model,
        MateriService $materi
    )
    {
        $this->model = $model;
        $this->materi = $materi;
    }
}
