<?php

namespace App\Services\Course\Bahan;

use App\Models\BankData;
use App\Models\Course\ApiEvaluasi;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Services\Course\MateriService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BahanService
{
    private $model, $materi, $forum, $file, $conference, $quiz, $scorm, $audio,
     $video, $tugas, $evaluasiPengajar;

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
        BahanEvaluasiPengajarService $evaluasiPengajar
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
    }


    public function getBahan(int $materiId, $notIn = null)
    {
        $materi = $this->materi->findMateri($materiId);

        $query = $this->model->query();

        $query->where('mata_id', $materi->mata_id);
        $query->where('completion_type', '>', 0);
        $query->whereHas('materi', function ($query) use ($materi) {
            $query->where('urutan', '<=', $materi->urutan);
        });
        if (!empty($notIn)) {
            $query->whereNotIn('id', [$notIn]);
        }

        $result = $query->orderBy('urutan', 'ASC')->get();

        return $result;
    }

    public function getBahanList($request, int $materiId)
    {
        $query = $this->model->query();

        $query->where('materi_id', $materiId);
        if(!empty($request)){
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('judul', 'ilike', '%'.$q.'%');
                });
            });
        }
        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate(10);

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
        $bahan->completion_type = $request->completion_type;
        $bahan->restrict_access = $request->restrict_access;

        if ($request->completion_type == 3) {
            $bahan->completion_parameter = [
                'timer' => $request->completion_duration,
            ];
        } else {
            $bahan->completion_parameter = null;
        }

        if ($request->restrict_access == '0') {
            $bahan->requirement = $request->requirement;
        } else {
            $bahan->requirement = null;
        }
        if ($request->restrict_access == 1) {
            $bahan->publish_start = $request->publish_start;
            $bahan->publish_end = $request->publish_end;
        } else {
            $bahan->publish_start = null;
            $bahan->publish_end = null;
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
            if($segmen == false){
                return false;
            }
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
        if ($request->type == 'scorm') {
            if($segmen == false){
                $bahan->delete();
            }
        }

        return $bahan;
    }

    public function updateBahan($request, int $id)
    {
        $bahan = $this->findBahan($id);
        $bahan->fill($request->only(['judul']));
        $bahan->keterangan = $request->keterangan ?? null;
        $bahan->publish = (bool)$request->publish;
        $bahan->completion_type = $request->completion_type;
        $bahan->restrict_access = $request->restrict_access;

        if ($request->completion_type == 3) {
            $bahan->completion_parameter = [
                'timer' => $request->completion_duration,
            ];
        } else {
            $bahan->completion_parameter = null;
        }

        if ($request->restrict_access == '0') {
            $bahan->requirement = $request->requirement;
        } else {
            $bahan->requirement = null;
        }
        if ($request->restrict_access == 1) {
            $bahan->publish_start = $request->publish_start;
            $bahan->publish_end = $request->publish_end;
        } else {
            $bahan->publish_start = null;
            $bahan->publish_end = null;
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
            $scorm = $this->scorm->updateScorm($request, $bahan);
            if($scorm == false){
                return false;
            }
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
        $activity = ActivityCompletion::where('bahan_id', $id)->count();

        if ($bahan->forum()->count() == 1) {

            if ($bahan->forum->topik->count() > 0 || $activity > 0) {
                return false;
            } else {
                $bahan->forum()->delete();
            }
        }
        if ($bahan->dokumen()->count() == 1) {
            if ($activity > 0) {
                return false;
            } else {
                $bahan->dokumen()->delete();
            }
        }
        if ($bahan->conference()->count() == 1) {
            if ($bahan->conference->status > 0 || $bahan->conference->peserta->count() > 0 ||
                $activity > 0) {
                return false;
            } else {
                $bahan->conference()->delete();
            }
        }
        if ($bahan->quiz()->count() == 1) {
            if ($bahan->quiz->item->count() > 0 || $bahan->quiz->trackUser->count() > 0 ||
                $bahan->quiz->trackItem->count() > 0 || $activity > 0) {
                return false;
            } else {
                $bahan->quiz()->delete();
            }
            // $bahan->quiz->item()->delete();
        }
        if ($bahan->scorm()->count() == 1) {

            if ($activity > 0) {
                return false;
            } else {

                $oldFile = public_path('userfile/scorm/'.$bahan->scorm->materi_id.'/zip/'.$bahan->scorm->package_name.'.zip') ;
                $oldDir =  public_path('userfile/scorm/'.$bahan->scorm->materi_id.'/'.$bahan->scorm->package_name);
                File::delete($oldFile);
                File::deleteDirectory($oldDir);
                $bahan->scorm()->delete();
            }
        }
        if ($bahan->audio()->count() == 1) {
            if ($activity > 0) {
                return false;
            } else {
                $bahan->audio()->delete();
            }
        }
        if ($bahan->video()->count() == 1) {
            if ($activity > 0) {
                return false;
            } else {
                $bahan->video()->delete();
            }
        }
        if ($bahan->tugas()->count() == 1) {

            if ($bahan->tugas->respon->count() > 0 || $activity > 0) {
                return false;
            } else {

                $bankData = BankData::whereIn('id', $bahan->tugas->bank_data_id)->get();
                foreach ($bankData as $file) {
                    Storage::disk('bank_data')->delete($file->file_path);
                    Storage::disk('bank_data')->deleteDirectory($bahan->tugas->creator->name);
                    Storage::disk('bank_data')->deleteDirectory($bahan->tugas->materi->judul);

                    $file->delete();
                }

                $bahan->tugas()->delete();
            }
        }
        if ($bahan->evaluasiPengajar()->count() == 1) {
            if (ApiEvaluasi::where('bahan_id', $id)->count() > 0 || $activity > 0) {
                return false;
            } else {
                $bahan->evaluasiPengajar()->delete();
            }
        }

        $bahan->delete();

        return $bahan;
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

    public function restrictAccess(int $id)
    {
        $bahan = $this->findBahan($id);

        if ($bahan->restrict_access == '0') {
            $checkMateri = $this->serviceActivity->restrict($bahan->requirement);
            if ($checkMateri == 0) {
                return 'Materi tidak bisa diakses sebelum anda menyelesaikan materi '.
                $bahan->restrictBahan($bahan->requirement)->judul;
            }
        }

        if ($bahan->restrict_access == 1) {
            if (now() < $bahan->publish_start) {
                return 'Materi tidak bisa diakses karena belum memasuki tanggal yang sudah ditentukan';
            }

            if (now() > $bahan->publish_end) {
                return 'Materi tidak bisa diakses karena sudah melebihi tanggal yang sudah ditentukan';
            }
        }
    }
}
