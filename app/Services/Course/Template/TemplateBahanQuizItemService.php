<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanQuiz;
use App\Models\Course\Template\Bahan\TemplateBahanQuizItem;
use App\Models\Course\Template\TemplateSoal;

class TemplateBahanQuizItemService
{
    private $model, $modelQuiz, $modelSoal;

    public function __construct(
        TemplateBahanQuizItem $model,
        TemplateBahanQuiz $modelQuiz,
        TemplateSoal $modelSoal
        )
    {
        $this->model = $model;
        $this->modelQuiz = $modelQuiz;
        $this->modelSoal = $modelSoal;
    }

    public function getTemplateItemList($request, int $quizId)
    {
        $query = $this->model->query();

        $query->where('template_quiz_id', $quizId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('pertanyaan', 'like', '%'.$q.'%');
            });
        });
        if (isset($request->t)) {
            $query->where('tipe_jawaban', $request->t);
        }

        $result = $query->paginate(20);

        return $result;
    }

    public function getTemplateItem(int $quizId)
    {
        $query = $this->model->query();

        $query->where('template_quiz_id', $quizId);

        $result = $query->get();

        return $result;
    }

    public function findTemplateItem(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateItem($request, int $quizId)
    {
        $quiz = $this->modelQuiz->find($quizId);

        $item = new TemplateBahanQuizItem($request->only(['pertanyaan']));
        $item->template_mata_id = $quiz->template_mata_id;
        $item->template_materi_id = $quiz->template_materi_id;
        $item->template_bahan_id = $quiz->template_bahan_id;
        $item->template_quiz_id = $quizId;
        $item->creator_id = auth()->user()->id;
        $item->tipe_jawaban = $request->get('tipe');
        if ($request->get('tipe') == 0) {
            $item->pilihan = $request->pilihan;
            $item->jawaban = $request->jawaban;

        } elseif ($request->get('tipe') == 1 || $request->get('tipe') == 3) {
            $item->jawaban = $request->jawaban;
        }
        $item->save();

        return $item;
    }

    public function storeTemplateFromBank($request, int $quizId)
    {
        $random = (bool)$request->random;

        if ($random == 0) {
            $soal = $this->modelSoal->whereIn('id', $request->soal_id)->get();
        } else {
            $soal = $this->modelSoal->where('template_kategori_id', $request->kategori_id)
                ->inRandomOrder()->limit($request->jml_soal)->get();
        }

        $quiz = $this->modelQuiz->find($quizId);

        foreach ($soal as $key => $value) {
            $item = new TemplateBahanQuizItem;
            $item->template_mata_id = $quiz->template_mata_id;
            $item->template_materi_id = $quiz->template_materi_id;
            $item->template_bahan_id = $quiz->template_bahan_id;
            $item->template_quiz_id = $quizId;
            $item->creator_id = auth()->user()->id;
            $item->pertanyaan = $value->pertanyaan;
            $item->tipe_jawaban = $value->tipe_jawaban;
            if ($value->tipe_jawaban == 0) {
                $item->pilihan = $value->pilihan;
                $item->jawaban = $value->jawaban;

            } elseif ($value->tipe_jawaban == 1 || $value->tipe_jawaban == 3) {
                $item->jawaban = $value->jawaban;
            }
            $item->save();
        }
    }

    public function updateTemplateItem($request, int $id)
    {
        $item = $this->findTemplateItem($id);
        $item->fill($request->only(['pertanyaan']));
        if ($item->tipe_jawaban == 0) {
            $item->pilihan = $request->pilihan;
            $item->jawaban = $request->jawaban;

        } elseif ($item->tipe_jawaban == 1 || $item->tipe_jawaban == 3) {
            $item->jawaban = $request->jawaban;
        }
        $item->save();

        return $item;
    }

    public function deleteTemplateItem(int $id)
    {
        $item = $this->findTemplateItem($id);
        $item->delete();

        return $item;
    }
}
