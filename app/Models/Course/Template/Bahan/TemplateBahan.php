<?php

namespace App\Models\Course\Template\Bahan;

use App\Models\Course\Template\TemplateMata;
use App\Models\Course\Template\TemplateMateri;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class TemplateBahan extends Model
{
    protected $table = 'template_bahan';
    protected $guarded = [];

    protected $casts = [
        'completion_parameter' => 'array',
    ];

    public function segmenable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(TemplateMata::class, 'template_mata_id');
    }

    public function materi()
    {
        return $this->belongsTo(TemplateMateri::class, 'template_materi_id');
    }

    public function forum()
    {
        return $this->hasOne(TemplateBahanForum::class, 'template_bahan_id');
    }

    public function dokumen()
    {
        return $this->hasOne(TemplateBahanFile::class, 'template_bahan_id');
    }

    public function conference()
    {
        return $this->hasOne(TemplateBahanConference::class, 'template_bahan_id');
    }

    public function quiz()
    {
        return $this->hasOne(TemplateBahanQuiz::class, 'template_bahan_id');
    }

    public function scorm()
    {
        return $this->hasOne(TemplateBahanScorm::class, 'template_bahan_id');
    }

    public function audio()
    {
        return $this->hasOne(TemplateBahanAudio::class, 'template_bahan_id');
    }

    public function video()
    {
        return $this->hasOne(TemplateBahanVideo::class, 'template_bahan_id');
    }

    public function tugas()
    {
        return $this->hasOne(TemplateBahanTugas::class, 'template_bahan_id');
    }

    public function restrictBahan($id)
    {
        return TemplateBahan::find($id);
    }

    public function type($bahan)
    {
        if ($bahan->forum()->count() == 1) {
            $segmen = [
                'tipe' => 'forum',
                'title' => 'Forum',
                'icon' => 'comments'
            ];
        }

        if ($bahan->dokumen()->count() == 1) {
            $segmen = [
                'tipe' => 'dokumen',
                'title' => 'Dokumen',
                'icon' => 'file'
            ];
        }

        if ($bahan->conference()->count() == 1) {
            $segmen = [
                'tipe' => 'conference',
                'title' => 'Video Conference',
                'icon' => 'video'
            ];
        }

        if ($bahan->quiz()->count() == 1) {
            $segmen = [
                'tipe' => 'quiz',
                'title' => 'Quiz',
                'icon' => 'spell-check'
            ];
        }

        if ($bahan->scorm()->count() == 1) {
            $segmen = [
                'tipe' => 'scorm',
                'title' => 'Scorm',
                'icon' => 'archive'
            ];
        }

        if ($bahan->audio()->count() == 1) {
            $segmen = [
                'tipe' => 'audio',
                'title' => 'Audio',
                'icon' => 'file-audio'
            ];
        }

        if ($bahan->video()->count() == 1) {
            $segmen = [
                'tipe' => 'video',
                'title' => 'Video',
                'icon' => 'file-video'
            ];
        }

        if ($bahan->tugas()->count() == 1) {
            $segmen = [
                'tipe' => 'tugas',
                'title' => 'Tugas',
                'icon' => 'briefcase'
            ];
        }

        return $segmen;
    }
}
