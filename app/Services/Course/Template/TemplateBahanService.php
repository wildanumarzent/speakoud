<?php

namespace App\Services\Course\Template;

use App\Models\BankData;
use App\Models\Course\Template\Bahan\TemplateBahan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TemplateBahanService
{
    private $model, $materi, $forum, $file, $conference, $quiz, $audio, $video,
        $tugas, $scorm;

    public function __construct(
        TemplateBahan $model,
        TemplateMateriService $materi,
        TemplateBahanForumService $forum,
        TemplateBahanFileService $file,
        TemplateBahanConferenceService $conference,
        TemplateBahanQuizService $quiz,
        TemplateBahanScormService $scorm,
        TemplateBahanAudioService $audio,
        TemplateBahanVideoService $video,
        TemplateBahanTugasService $tugas
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
    }

    public function getTemplateBahan(int $materiId, $notIn = null)
    {
        $materi = $this->materi->findTemplateMateri($materiId);

        $query = $this->model->query();

        $query->where('template_mata_id', $materi->template_mata_id);
        $query->where('completion_type', '>', 0);
        $query->whereHas('materi', function ($query) use ($materi) {
            $query->where('urutan', '<=', $materi->urutan);
        });
        if (!empty($notIn)) {
            $query->whereNotIn('id', [$notIn]);
        }
        $query->where(function ($query) {
            $query->whereNotNull('segmenable_id');
        });

        $result = $query->get();

        return $result;
    }

    public function getTemplateBahanList($request, int $materiId)
    {
        $query = $this->model->query();

        $query->where('template_materi_id', $materiId);
        if(!empty($request)){
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('judul', 'ilike', '%'.$q.'%');
                });
            });
        }
        $query->where(function ($query) {
            $query->whereNotNull('segmenable_id');
        });

        $limit = 10;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->paginate($limit);

        return $result;
    }

    public function findTemplateBahan(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateBahan($request, int $materiId)
    {
        $materi = $this->materi->findTemplateMateri($materiId);

        $bahan = new TemplateBahan($request->only(['judul']));
        $bahan->template_mata_id = $materi->template_mata_id;
        $bahan->template_materi_id = $materiId;
        $bahan->creator_id = auth()->user()->id;
        $bahan->keterangan = $request->keterangan ?? null;
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
        $bahan->save();

        if ($request->type == 'forum') {
            $segmen = $this->forum->storeTemplateForum($request, $materi, $bahan);
        }

        if ($request->type == 'dokumen') {
            $segmen = $this->file->storeTemplateFile($request, $materi, $bahan);
        }

        if ($request->type == 'conference') {
            $segmen = $this->conference->storeTemplateConference($request, $materi, $bahan);
        }

        if ($request->type == 'quiz') {
            $segmen = $this->quiz->storeTemplateQuiz($request, $materi, $bahan);
        }

        if ($request->type == 'scorm') {
            $segmen = $this->scorm->storeTemplateScorm($request, $materi, $bahan);
            if($segmen == false){
                return false;
            }
        }

        if ($request->type == 'audio') {
            $segmen = $this->audio->storeTemplateAudio($request, $materi, $bahan);
        }

        if ($request->type == 'video') {
            $segmen = $this->video->storeTemplateVideo($request, $materi, $bahan);
        }

        if ($request->type == 'tugas') {
            $segmen = $this->tugas->storeTemplateTugas($request, $materi, $bahan);
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

    public function updateTemplateBahan($request, int $id)
    {
        $bahan = $this->findTemplateBahan($id);
        $bahan->fill($request->only(['judul']));
        $bahan->keterangan = $request->keterangan ?? null;
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

        $bahan->save();

        if ($request->type == 'forum') {
            $this->forum->updateTemplateForum($request, $bahan);
        }

        if ($request->type == 'dokumen') {
            $this->file->updateTemplateFile($request, $bahan);
        }

        if ($request->type == 'conference') {
            $this->conference->updateTemplateConferece($request, $bahan);
        }

        if ($request->type == 'quiz') {
            $this->quiz->updateTemplateQuiz($request, $bahan);
        }

        if ($request->type == 'scorm') {
            $scorm = $this->scorm->updateTemplateScorm($request, $bahan);
            if($scorm == false){
                return false;
            }
        }

        if ($request->type == 'audio') {
            $this->audio->updateTemplateAudio($request, $bahan);
        }

        if ($request->type == 'video') {
            $this->video->updateTemplateVideo($request, $bahan);
        }

        if ($request->type == 'tugas') {
            $this->tugas->updateTemplateTugas($request, $bahan);
        }

        return $bahan;
    }

    public function deleteTemplateBahan(int $id)
    {
        $bahan = $this->findTemplateBahan($id);

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
        }

        if ($bahan->scorm()->count() == 1) {
            $bankData = BankData::where('id', $bahan->scorm->bank_data_id)->get();

            $oldFile = public_path('userfile/scorm/template/'.$bahan->scorm->materi_id.'/zip/'.$bahan->scorm->package_name.'.zip') ;
            $oldDir =  public_path('userfile/scorm/template/'.$bahan->scorm->materi_id.'/'.$bahan->scorm->package_name);
            File::delete($oldFile);
            File::deleteDirectory($oldDir);

            $bahan->scorm->bankData->delete();
            $bahan->scorm()->delete();
        }

        if ($bahan->audio()->count() == 1) {
            $bahan->audio()->delete();
        }

        if ($bahan->video()->count() == 1) {
            $bahan->video()->delete();
        }

        if ($bahan->tugas()->count() == 1) {
            $bankData = BankData::whereIn('id', $bahan->tugas->bank_data_id)->get();
            foreach ($bankData as $file) {
                Storage::disk('bank_data')->delete($file->file_path);
                Storage::disk('bank_data')->deleteDirectory($bahan->tugas->creator->name);
                Storage::disk('bank_data')->deleteDirectory($bahan->tugas->materi->judul);

                $file->delete();
            }

            $bahan->tugas()->delete();
        }

        $bahan->delete();

        return $bahan;
    }
}
