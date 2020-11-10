<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;

class BahanQuizService
{
    private $model;

    public function __construct(BahanQuiz $model)
    {
        $this->model = $model;
    }

    public function storeQuiz($request, $materi, $bahan)
    {
        $quiz = new BahanQuiz;
        $quiz->program_id = $materi->program_id;
        $quiz->mata_id = $materi->mata_id;
        $quiz->materi_id = $materi->id;
        $quiz->bahan_id = $bahan->id;
        $quiz->creator_id = auth()->user()->id;
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->save();

        return $quiz;
    }

    public function updateQuiz($request, $bahan)
    {
        $quiz = $bahan->quiz;
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->save();

        return $quiz;
    }
}
