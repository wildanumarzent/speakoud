<?php

namespace App\Services\Soal;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Models\Soal\Soal;

class SoalService
{
    private $model;

    public function __construct(Soal $model)
    {
        $this->model = $model;
    }

    public function getSoalList($request, int $mataId, int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('mata_id', $mataId);
        $query->where('kategori_id', $kategoriId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('pertanyaan', 'like', '%'.$q.'%');
            });
        });

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->where('creator_id', auth()->user()->id);
        }

        if (isset($request->t)) {
            $query->where('tipe_jawaban', $request->t);
        }

        $result = $query->paginate(20);

        return $result;
    }

    public function getSoalByMata(int $mataId, $notIn = null)
    {
        $query = $this->model->query();

        $query->where('mata_id', $mataId);

        if (!empty($notIn)) {
            $query->whereNotIn('pertanyaan', $notIn);
        }

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->where('creator_id', auth()->user()->id);
        }

        $result = $query->get();

        return $result;
    }

    public function getSoalByKategori(int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('kategori_id', $kategoriId);

        $result = $query->get();

        return $result;
    }

    public function getSoalForQuiz($request, int $quizId)
    {
        $quiz = BahanQuiz::find($quizId);
        $item = BahanQuizItem::where('quiz_id', $quizId);

        $query = $this->model->query();

        if ($request->kategori_id == 0) {
            $query->where('mata_id', $quiz->mata_id);
        } else {
            $query->where('kategori_id', $request->kategori_id);
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

    public function findSoal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeSoal($request, int $mataId, int $kategoriId)
    {
        $soal = new Soal($request->only(['pertanyaan']));
        $soal->mata_id = $mataId;
        $soal->kategori_id = $kategoriId;
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

    public function updateSoal($request, int $id)
    {
        $soal = $this->findSoal($id);
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

    public function deleteSoal(int $id)
    {
        $soal = $this->findSoal($id);
        $quizItem = BahanQuizItem::where('mata_id', $soal->mata_id)
            ->where('pertanyaan', $soal->pertanyaan)->count();

        if ($quizItem > 0) {
            return false;
        } else {

            $soal->delete();

            return true;
        }
    }
}
