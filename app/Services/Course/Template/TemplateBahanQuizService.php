<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanQuiz;

class TemplateBahanQuizService
{
    private $model;

    public function __construct(
        TemplateBahanQuiz $model
    )
    {
        $this->model = $model;
    }

    public function findTemplateQuiz(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateQuiz($request, $materi, $bahan)
    {
        $quiz = new TemplateBahanQuiz;
        $quiz->template_mata_id = $materi->template_mata_id;
        $quiz->template_materi_id = $materi->id;
        $quiz->template_bahan_id = $bahan->id;
        $quiz->creator_id = auth()->user()->id;
        $quiz->is_mandatory = (bool)$request->is_mandatory;
        $quiz->kategori = $request->kategori;
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->view = $request->view;
        $quiz->hasil = (bool)$request->hasil;
        $quiz->soal_acak = (bool)$request->soal_acak;
        if ((bool)$request->soal_acak == 1) {
            $quiz->jml_soal_acak = $request->jml_soal_acak;
        } else {
            $quiz->jml_soal_acak = null;
        }
        $quiz->save();

        return $quiz;
    }

    public function updateTemplateQuiz($request, $bahan)
    {
        $quiz = $bahan->quiz;
        $quiz->is_mandatory = (bool)$request->is_mandatory;
        $quiz->kategori = $request->kategori;
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->view = $request->view;
        $quiz->hasil = (bool)$request->hasil;
        $quiz->soal_acak = (bool)$request->soal_acak;
        if ((bool)$request->soal_acak == 1) {
            $quiz->jml_soal_acak = $request->jml_soal_acak;
        } else {
            $quiz->jml_soal_acak = null;
        }
        $quiz->save();

        return $quiz;
    }
}
