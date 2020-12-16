<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Services\Course\MateriService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BahanService
{
    private $model, $materi, $forum, $file, $conference, $quiz, $scorm, $audio,
     $video, $tugas, $evaluasiPengajar, $completion;

    public function __construct(
        BahanPelatihan $model,
        MateriService $materi,
        BahanForumService $forum,
        BahanFileService $file,
        BahanConferenceService $conference,
        BahanQuizService $quiz,
        BahanScormService $scorm,
        BahanAudioService $audio,
        BahanVideoService $video,
        BahanTugasService $tugas,
        BahanEvaluasiPengajarService $evaluasiPengajar,
        ActivityCompletion $completion
    )
    {
        $this->model = $model;
        $this->materi = $materi;
        $this->forum = $forum;
        $this->file = $file;
        $this->conference = $conference;
        $this->quiz = $quiz;
        $this->scorm = $scorm;
        $this->audio = $audio;
        $this->video = $video;
        $this->tugas = $tugas;
        $this->evaluasiPengajar = $evaluasiPengajar;
        $this->completion = $completion;
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

    public function bahanJump($id)
    {
        $query = $this->model->query();

        $query->where('publish', 1);
        $query->whereNotIn('id', [$id]);

        $result = $query->orderBy('urutan', 'ASC')->get();

        return $result;
    }

    public function bahanPrevNext(int $materiId, int $urutan, $type)
    {
        $query = $this->model->query();

        $query->where('materi_id', $materiId);
        $query->where('publish', 1);
        if ($type == 'prev') {
            $query->where('urutan', '<', $urutan);
            $query->orderBy('urutan', 'DESC');
        }

        if ($type == 'next') {
            $query->where('urutan', '>', $urutan);
            $query->orderBy('urutan', 'ASC');
        }

        $result = $query->limit(1)->get();

        return $result;
    }

    public function countBahan()
    {
        $query = $this->model->query();

        if (auth()->user()->hasRole('internal')) {
            $query->whereHas('program', function ($query) {
                $query->where('tipe', 0);
            });
        }

        if (auth()->user()->hasRole('mitra')) {
            $query->whereHas('program', function ($query) {
                $query->where('mitra_id', auth()->user()->id)
                ->where('tipe', 1);
            });
        }

        $result = $query->count();

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
        if ((bool)$request->batas_tanggal == 1) {
            $bahan->publish_start = $request->publish_start ?? null;
            $bahan->publish_end = $request->publish_end ?? null;
        }
        $bahan->urutan = ($this->model->where('materi_id', $materiId)->max('urutan') + 1);
        $bahan->save();

        if ($request->type == 'forum') {
            $segmen = $this->forum->storeForum($request, $materi, $bahan);
        }
        if ($request->type == 'dokumen') {
            $segmen = $this->file->storeFile($request, $materi, $bahan);
        }
        if ($request->type == 'conference') {
            $segmen = $this->conference->storeConference($request, $materi, $bahan);
        }
        if ($request->type == 'quiz') {
            $segmen = $this->quiz->storeQuiz($request, $materi, $bahan);
        }
        if ($request->type == 'scorm') {
            $segmen = $this->scorm->storeScorm($request, $materi, $bahan);
        }
        if ($request->type == 'audio') {
            $segmen = $this->audio->storeAudio($request, $materi, $bahan);
        }
        if ($request->type == 'video') {
            $segmen = $this->video->storeVideo($request, $materi, $bahan);
        }
        if ($request->type == 'tugas') {
            $segmen = $this->tugas->storeTugas($request, $materi, $bahan);
        }
        if ($request->type == 'evaluasi-pengajar') {
            $segmen = $this->evaluasiPengajar->storeEvaluasiPengajar($request, $materi, $bahan);
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
        if ((bool)$request->batas_tanggal == 1) {
            $bahan->publish_start = $request->publish_start ?? null;
            $bahan->publish_end = $request->publish_end ?? null;
        }
        $bahan->save();

        if ($request->type == 'forum') {
            $this->forum->updateForum($request, $bahan);
        }
        if ($request->type == 'dokumen') {
            $this->file->updateFile($request, $bahan);
        }
        if ($request->type == 'conference') {
            $this->conference->updatuConferece($request, $bahan);
        }
        if ($request->type == 'quiz') {
            $this->quiz->updateQuiz($request, $bahan);
        }
        if ($request->type == 'scorm') {
            $this->scorm->updateScorm($request, $bahan);
        }
        if ($request->type == 'audio') {
            $this->audio->updateAudio($request, $bahan);
        }
        if ($request->type == 'video') {
            $this->video->updateVideo($request, $bahan);
        }
        if ($request->type == 'tugas') {
            $this->tugas->updateTugas($request, $bahan);
        }
        if ($request->type == 'evaluasi-pengajar') {
            $this->evaluasiPengajar->updateEvaluasiPengajar($request, $bahan);
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
        if ($bahan->conference()->count() == 1) {
            $bahan->conference()->delete();
        }
        if ($bahan->quiz()->count() == 1) {
            $bahan->quiz()->delete();
            $bahan->quiz->item()->delete();
        }
        if ($bahan->scorm()->count() == 1) {
            $oldFile = public_path('userfile/scorm/'.$bahan->scorm->materi_id.'/zip/'.$bahan->scorm->package_name.'.zip') ;
            $oldDir =  public_path('userfile/scorm/'.$bahan->scorm->materi_id.'/'.$bahan->scorm->package_name);
            File::delete($oldFile);
            File::deleteDirectory($oldDir);
            $bahan->scorm()->delete();
        }
        if ($bahan->audio()->count() == 1) {
            $bahan->audio()->delete();
        }
        if ($bahan->video()->count() == 1) {
            $bahan->video()->delete();
        }
        if ($bahan->tugas()->count() == 1) {

            foreach ($bahan->tugas->files as $file) {
                Storage::disk('bank_data')->delete($file);
            }

            $bahan->tugas()->delete();
        }
        if ($bahan->evaluasiPengajar()->count() == 1) {
            $bahan->evaluasiPengajar()->delete();
        }

        $bahan->delete();

        return $bahan;
    }

    public function recordActivity(int $id)
    {
        $bahan = $this->findBahan($id);

        return $this->completion->updateOrCreate([
            'program_id' => $bahan->program_id,
            'mata_id' => $bahan->mata_id,
            'materi_id' => $bahan->materi_id,
            'bahan_id' => $id,
            'user_id' => auth()->user()->id,
        ], [
            'program_id' => $bahan->program_id,
            'mata_id' => $bahan->mata_id,
            'materi_id' => $bahan->materi_id,
            'bahan_id' => $id,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function checkInstruktur($materiId)
    {
        $materi = $this->materi->findMateri($materiId);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($materi->instruktur_id != auth()->user()->instruktur->id) {
                return abort(403);
            }
        }
    }
}
