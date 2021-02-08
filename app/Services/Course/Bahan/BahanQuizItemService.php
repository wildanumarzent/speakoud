<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Models\Course\Bahan\BahanQuizItemTracker;
use App\Models\Course\Bahan\BahanQuizUserTracker;
use App\Models\Soal\Soal;

class BahanQuizItemService
{
    private $model, $modelQuiz, $modelTracker, $modelSoal;

    public function __construct(
        BahanQuizItem $model,
        BahanQuiz $modelQuiz,
        BahanQuizItemTracker $modelTracker,
        Soal $modelSoal
        )
    {
        $this->model = $model;
        $this->modelQuiz = $modelQuiz;
        $this->modelTracker = $modelTracker;
        $this->modelSoal = $modelSoal;
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

    public function getItem(int $quizId)
    {
        $query = $this->model->query();

        $query->where('quiz_id', $quizId);

        $result = $query->get();

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

    public function nilaiTest(int $mataId, $kategori)
    {
        $quiz = $this->modelQuiz->where('mata_id', $mataId)
            ->where('kategori', $kategori)->pluck('id');

        $test = $this->modelTracker->query();
        $test->whereIn('quiz_id', $quiz);

        $result = $test->get();

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

        } elseif ($request->get('tipe') == 1 || $request->get('tipe') == 3) {
            $item->jawaban = $request->jawaban;
        }
        $item->save();

        return $item;
    }

    public function storeFromBank($request, int $quizId)
    {
        $quiz = $this->findQuiz($quizId);

        $random = (bool)$request->random;

        if ($random == 0) {
            $soal = $this->modelSoal->whereIn('id', $request->soal_id)->get();
        } else {

            if ($request->kategori_id > 0) {
                $soal = $this->modelSoal->where('kategori_id', $request->kategori_id)
                    ->inRandomOrder()->limit($request->jml_soal)->get();
            } else {
                $soal = $this->modelSoal->where('mata_id', $quiz->mata_id)
                    ->inRandomOrder()->limit($request->jml_soal)->get();
            }
            
        }

        foreach ($soal as $key => $value) {
            $item = new BahanQuizItem;
            $item->program_id = $quiz->program_id;
            $item->mata_id = $quiz->mata_id;
            $item->materi_id = $quiz->materi_id;
            $item->bahan_id = $quiz->bahan_id;
            $item->quiz_id = $quizId;
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

    public function updateItem($request, int $id)
    {
        $item = $this->findItem($id);
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

    public function deleteItem(int $id)
    {
        $item = $this->findItem($id);
        $item->delete();

        return $item;
    }

    public function insertSoalRandom(int $quizId)
    {
        $quiz = $this->findQuiz($quizId);
        $soal = $quiz->item()->inRandomOrder()->limit($quiz->jml_soal_acak)->get();

        foreach ($soal as $key => $value) {
            $insertSoal = new BahanQuizItemTracker;
            $insertSoal->quiz_id = $quizId;
            $insertSoal->quiz_item_id = $value->id;
            $insertSoal->user_id = auth()->user()->id;
            $insertSoal->posisi = ($key+1);
            $insertSoal->jawaban = ' ';
            $insertSoal->benar = null;
            $insertSoal->save();
        }
    }

    public function trackJawaban($request, int $quizId)
    {
        $item = $this->findItem($request->id);

        $benar = null;
        if ($item->tipe_jawaban == 0 || $item->tipe_jawaban == 3) {
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

    public function ulangi(int $quizId, int $pesertaId)
    {
        $quiz = $this->findQuiz($quizId);

        if ($quiz->trackUserIn->cek == 1) {

            return false;

        } else {

            $userTracker = BahanQuizUserTracker::where('quiz_id', $quizId)
                ->where('user_id', $pesertaId)->delete();
            $itemTracker = BahanQuizItemTracker::where('quiz_id', $quizId)
                ->where('user_id', $pesertaId)->delete();

            return true;
        }

    }
}
