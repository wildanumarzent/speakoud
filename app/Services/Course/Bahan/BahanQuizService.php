<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizUserTracker;

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
            return $query->whereHas('user', function ($query) use ($q) {
                $query->where('name', $q);
            });
        });

        if (isset($request->s)) {
            $query->where('status', $request->s);
        }

        $result = $query->orderBy('end_time', 'DESC')->paginate(20);

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
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->view = $request->view;
        $quiz->save();

        return $quiz;
    }

    public function updateQuiz($request, $bahan)
    {
        $quiz = $bahan->quiz;
        $quiz->durasi = $request->durasi ?? null;
        $quiz->tipe = $request->tipe;
        $quiz->view = $request->view;
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

    public function trackUserOut(int $quizId)
    {
        $track = $this->modelTrackUser->where('quiz_id', $quizId)
            ->where('user_id', auth()->user()->id)->first();
        $track->status = 2;
        $track->end_time = now();
        $track->save();

        return $track;
    }
}
