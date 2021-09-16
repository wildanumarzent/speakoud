<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizUserTracker;
use Illuminate\Database\Eloquent\Builder;

class BahanQuizService
{
    private $model, $modelTrackUser;

    public function __construct(
        BahanQuiz $model,
        BahanQuizUserTracker $modelTrackUser
    )
    {
        $this->model = $model;
        $this->modelTrackUser = $modelTrackUser;
    }

    public function quizPesertaList($request, int $quizId)
    {
        $query = $this->modelTrackUser->query();

        $query->where('quiz_id', $quizId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'ilike', '%'.$q.'%')
                        ->orWhereHas('peserta', function (Builder $queryC) use ($q) {
                            $queryC->orWhere('nip', 'ilike', '%'.$q.'%');
                        });
                });
            });
        });

        if (isset($request->s)) {
            $query->where('status', $request->s);
        }

        $result = $query->orderBy('end_time', 'DESC')->paginate(20);

        return $result;
    }

    public function quizPesertaExport(int $quizId)
    {
        $query = $this->modelTrackUser->query();

        $query->where('quiz_id', $quizId);

        $result = $query->orderBy('end_time', 'DESC')->get();

        return $result;
    }

    public function findQuizPeserta(int $quizId, int $pesertaId)
    {
        $query = $this->modelTrackUser->query();

        $query->where('quiz_id', $quizId)
            ->where('user_id', $pesertaId);

        $result = $query->first();

        return $result;
    }

    public function storeQuiz($request, $materi, $bahan)
    {
        $quiz = new BahanQuiz;
        $quiz->program_id = $materi->program_id;
        $quiz->mata_id = $materi->mata_id;
        $quiz->materi_id = $materi->id;
        $quiz->bahan_id = $bahan->id;
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

    public function updateQuiz($request, $bahan)
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

    public function trackUserIn(int $quizId)
    {
        $track = new BahanQuizUserTracker;
        $track->quiz_id = $quizId;
        $track->user_id = auth()->user()->id;
        $track->status = 1;
        $track->start_time = now();
        $track->save();

        return $track;
    }

    public function trackUserOut(int $quizId, $lulus)
    {
        $track = $this->modelTrackUser->where('quiz_id', $quizId)
            ->where('user_id', auth()->user()->id)->first();
        $track->status = 2;
        $track->is_graduaded = $lulus;
        $track->end_time = now();        
        $track->save();

        return $track;
    }

    public function cekPeserta(int $id)
    {
        $track = $this->modelTrackUser->findOrFail($id);
        $track->cek = 1;
        $track->save();

        return $track;
    }
}
