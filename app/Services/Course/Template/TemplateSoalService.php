<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanQuiz;
use App\Models\Course\Template\Bahan\TemplateBahanQuizItem;
use App\Models\Course\Template\TemplateSoal;

class TemplateSoalService
{
    private $model;

    public function __construct(TemplateSoal $model)
    {
        $this->model = $model;
    }

    public function getTemplateSoalList($request, int $mataId, int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);
        $query->where('template_kategori_id', $kategoriId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('pertanyaan', 'like', '%'.$q.'%');
            });
        });

        if (isset($request->t)) {
            $query->where('tipe_jawaban', $request->t);
        }

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->paginate($limit);

        return $result;
    }

    public function getTemplateSoalByMata(int $mataId, $notIn = null)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);

        if (!empty($notIn)) {
            $query->whereNotIn('pertanyaan', $notIn);
        }

        $result = $query->get();

        return $result;
    }

    public function getTemplateSoalByKategori(int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('template_kategori_id', $kategoriId);

        $result = $query->get();

        return $result;
    }

    public function getTemplateSoalForQuiz($request, int $quizId)
    {
        $quiz = TemplateBahanQuiz::find($quizId);
        $item = TemplateBahanQuizItem::where('template_quiz_id', $quizId);

        $query = $this->model->query();

        if ($request->kategori_id == 0) {
            $query->where('template_mata_id', $quiz->template_mata_id);
        } else {
            $query->where('template_kategori_id', $request->kategori_id);
        }

        if ($item->count() > 0) {
            $collectSoal = collect($item->get());
            $soal = $collectSoal->map(function($item, $key) {
                return $item->pertanyaan;
            })->all();
            $query->whereNotIn('pertanyaan', $soal)->pluck('pertanyaan', 'id');
        }

        $result = $query->pluck('pertanyaan', 'id');

        return $result;
    }

    public function findTemplateSoal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateSoal($request, int $mataId, int $kategoriId)
    {
        $soal = new TemplateSoal($request->only(['pertanyaan']));
        $soal->template_mata_id = $mataId;
        $soal->template_kategori_id = $kategoriId;
        $soal->creator_id = auth()->user()->id;
        $soal->tipe_jawaban = $request->get('tipe');
        if ($request->get('tipe') == 0) {
            $soal->pilihan = $request->pilihan;
            $soal->jawaban = $request->jawaban;

        } elseif ($request->get('tipe') == 1 || $request->get('tipe') == 3) {
            $soal->jawaban = $request->jawaban;
        }
        $soal->save();

        return $soal;
    }

    public function updateTemplateSoal($request, int $id)
    {
        $soal = $this->findTemplateSoal($id);
        $soal->fill($request->only(['pertanyaan']));
        if ($soal->tipe_jawaban == 0) {
            $soal->pilihan = $request->pilihan;
            $soal->jawaban = $request->jawaban;

        } elseif ($soal->tipe_jawaban == 1 || $soal->tipe_jawaban == 3) {
            $soal->jawaban = $request->jawaban;
        }
        $soal->save();

        return $soal;
    }

    public function deleteTemplateSoal(int $id)
    {
        $soal = $this->findTemplateSoal($id);
        $quizItem = TemplateBahanQuizItem::where('template_mata_id', $soal->mata_id)
            ->where('pertanyaan', $soal->pertanyaan)->count();

        if ($quizItem > 0) {
            return false;
        } else {

            $soal->delete();

            return true;
        }
    }
}
