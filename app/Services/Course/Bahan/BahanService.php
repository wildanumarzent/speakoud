<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Services\Course\MateriService;
use Illuminate\Support\Facades\Storage;

class BahanService
{
    private $model, $materi, $forum, $file, $link, $quiz;

    public function __construct(
        BahanPelatihan $model,
        MateriService $materi,
        BahanForumService $forum,
        BahanFileService $file,
        BahanLinkService $link,
        BahanQuizService $quiz,
        BahanScormService $scorm
    )
    {
        $this->model = $model;
        $this->materi = $materi;
        $this->forum = $forum;
        $this->file = $file;
        $this->link = $link;
        $this->quiz = $quiz;
        $this->scorm = $scorm;
    }

    public function getBahanList($request, int $materiId)
    {
        $query = $this->model->query();

        $query->where('materi_id', $materiId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%')
                    ->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });
        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate(9);

        return $result;
    }

    public function findBahan(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeBahan($request, int $materiId)
    {
        $materi = $this->materi->findMateri($materiId);

        $bahan = new BahanPelatihan($request->only(['judul']));
        $bahan->program_id = $materi->program_id;
        $bahan->mata_id = $materi->mata_id;
        $bahan->materi_id = $materiId;
        $bahan->creator_id = auth()->user()->id;
        $bahan->keterangan = $request->keterangan ?? null;
        $bahan->publish = (bool)$request->publish;
        $bahan->urutan = ($this->model->where('materi_id', $materiId)->max('urutan') + 1);
        $bahan->save();

        if ($request->type == 'forum') {
            $segmen = $this->forum->storeForum($request, $materi, $bahan);
        }
        if ($request->type == 'dokumen') {
            $segmen = $this->file->storeFile($request, $materi, $bahan);
        }
        if ($request->type == 'link') {
            $segmen = $this->link->storeLink($request, $materi, $bahan);
        }
        if ($request->type == 'quiz') {
            $segmen = $this->quiz->storeQuiz($request, $materi, $bahan);
        }
        if ($request->type == 'scorm') {
            $segmen = $this->scorm->storeScorm($request, $materi, $bahan);
        }

        $bahan->segmenable()->associate($segmen);
        $bahan->save();

        return $bahan;
    }

    public function updateBahan($request, int $id)
    {
        $bahan = $this->findBahan($id);
        $bahan->fill($request->only(['judul']));
        $bahan->keterangan = $request->keterangan ?? null;
        $bahan->publish = (bool)$request->publish;
        $bahan->save();

        if ($request->type == 'forum') {
            $this->forum->updateForum($request, $bahan);
        }
        if ($request->type == 'dokumen') {
            $this->file->updateFile($request, $bahan);
        }
        if ($request->type == 'link') {
            $this->link->updateLink($request, $bahan);
        }
        if ($request->type == 'quiz') {
            $this->quiz->updateQuiz($request, $bahan);
        }
        if ($request->type == 'scorm') {
            $this->scorm->updateScorm($request, $bahan);
        }

        return $bahan;
    }

    public function positionBahan(int $id, $urutan)
    {
        if ($urutan >= 1) {

            $bahan = $this->findBahan($id);
            $this->model->where('urutan', $urutan)->update([
                'urutan' => $bahan->urutan,
            ]);
            $bahan->urutan = $urutan;
            $bahan->save();

            return $bahan;
        } else {
            return false;
        }
    }

    public function sortBahan(int $id, $urutan)
    {
        $find = $this->findBahan($id);

        $bahan = $this->model->where('id', $id)
                ->where('materi_id', $find->materi_id)->update([
            'urutan' => $urutan
        ]);

        return $bahan;
    }

    public function publishBahan(int $id)
    {
        $bahan = $this->findBahan($id);
        $bahan->publish = !$bahan->publish;
        $bahan->save();

        return $bahan;
    }

    public function deleteBahan(int $id)
    {
        $bahan = $this->findBahan($id);

        if ($bahan->forum()->count() == 1) {
            $bahan->forum()->delete();
        }
        if ($bahan->dokumen()->count() == 1) {
            $bahan->dokumen()->delete();
        }
        if ($bahan->link()->count() == 1) {
            $bahan->link()->delete();
        }
        if ($bahan->quiz()->count() == 1) {
            $bahan->quiz()->delete();
            $bahan->quiz->item()->delete();
        }
        if ($bahan->scorm()->count() == 1) {
            Storage::disk('bank_data')->delete($bahan->scorm->package);
            $bahan->scorm()->delete();
        }

        $bahan->delete();

        return $bahan;
    }
}
