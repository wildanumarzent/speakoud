<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizItem;

class BahanQuizItemService
{
    private $model, $modelQuiz;

    public function __construct(BahanQuizItem $model, BahanQuiz $modelQuiz)
    {
        $this->model = $model;
        $this->modelQuiz = $modelQuiz;
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

    public function findItem(int $id)
    {
        return $this->model->findOrFail($id);
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
        $data = $this->findItem($id);
        $data->delete();

        return $data;
    }
}
