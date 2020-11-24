<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Models\Course\Bahan\BahanQuizItemTracker;

class BahanQuizItemService
{
    private $model, $modelQuiz, $modelTracker;

    public function __construct(
        BahanQuizItem $model,
        BahanQuiz $modelQuiz,
        BahanQuizItemTracker $modelTracker
        )
    {
        $this->model = $model;
        $this->modelQuiz = $modelQuiz;
        $this->modelTracker = $modelTracker;
    }

    public function getItemList($request, int $quizId)
    {
        $query = $this->model->query();

        $query->where('quiz_id', $quizId);
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

    public function getSoalQuizTracker(int $quizId)
    {
        $query = $this->modelTracker->query();

        $query->where('quiz_id', $quizId)->where('user_id', auth()->user()->id);

        $result = $query->orderBy('posisi', 'ASC')->get();

        return $result;
    }

    public function soalQuiz(int $quizId, array $notIn = null)
    {
        $query = $this->model->query();

        $query->where('quiz_id', $quizId);
        if ($notIn != null) {
            $query->whereNotIn('id', $notIn);
        }

        $result = $query->inRandomOrder()->get();

        return $result;
    }

    public function jawabanPeserta(int $quizId, int $pesertaId)
    {
        $query = $this->modelTracker->query();

        $query->where('quiz_id', $quizId)->where('user_id', $pesertaId);

        $result = $query->orderBy('posisi', 'ASC')->get();

        return $result;
    }

    public function findItem(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findItemTracker(int $id)
    {
        return $this->modelTracker->findOrFail($id);
    }

    public function findQuiz(int $id)
    {
        return $this->modelQuiz->findOrFail($id);
    }

    public function storeItem($request, int $quizId)
    {
        $quiz = $this->findQuiz($quizId);

        $item = new BahanQuizItem($request->only(['pertanyaan']));
        $item->program_id = $quiz->program_id;
        $item->mata_id = $quiz->mata_id;
        $item->materi_id = $quiz->materi_id;
        $item->bahan_id = $quiz->bahan_id;
        $item->quiz_id = $quizId;
        $item->creator_id = auth()->user()->id;
        $item->tipe_jawaban = $request->get('tipe');
        if ($request->get('tipe') == 0) {
            $item->pilihan = $request->pilihan;
            $item->jawaban = $request->jawaban;

        } elseif ($request->get('tipe') == 1) {
            $item->jawaban = $request->jawaban;
        }
        $item->save();

        return $item;
    }

    public function updateItem($request, int $id)
    {
        $item = $this->findItem($id);
        $item->fill($request->only(['pertanyaan']));
        if ($item->tipe_jawaban == 0) {
            $item->pilihan = $request->pilihan;
            $item->jawaban = $request->jawaban;

        } elseif ($item->tipe_jawaban == 1) {
            $item->jawaban = $request->jawaban;
        }
        $item->save();

        return $item;
    }

    public function deleteItem(int $id)
    {
        $item = $this->findItem($id);
        $item->delete();

        return $item;
    }

    public function trackJawaban($request, int $quizId)
    {
        $item = $this->findItem($request->id);

        $benar = null;
        if ($item->tipe_jawaban == 0) {
            $benar = ($request->jawaban == $item->jawaban) ? 1 : 0;
        }
        if ($item->tipe_jawaban == 1) {
            $jawaban = array_map('strtolower', $item->jawaban);
            if (in_array(strtolower(str_replace(' ', '', $request->jawaban)),
                str_replace(' ', '', $jawaban), true) == true) {
                $benar = 1;
            } else {
                $benar = 0;
            }
        }

        $tracker = $this->modelTracker->updateOrCreate([
            'quiz_id' => $quizId,
            'quiz_item_id' => $request->id,
            'user_id' => auth()->user()->id,
        ], [
            'quiz_id' => $quizId,
            'quiz_item_id' => $request->id,
            'user_id' => auth()->user()->id,
            'posisi' => $request->posisi,
            'jawaban' => $request->jawaban ?? ' ',
            'benar' => $benar ?? null,
        ]);
        $tracker->save();

        return $tracker;
    }

    public function cekEssay(int $id, int $status)
    {
        $essay = $this->findItemTracker($id);
        $essay->benar = $status;
        $essay->save();

        return $essay;
    }
}
