<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanPelatihan extends Model
{
    protected $table = 'bahan_pelatihan';
    protected $guarded = [];

    protected $casts = [
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
    ];

    public function segmenable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class, 'materi_id');
    }

    public function forum()
    {
        return $this->hasOne(BahanForum::class, 'bahan_id');
    }

    public function dokumen()
    {
        return $this->hasOne(BahanFile::class, 'bahan_id');
    }

    public function conference()
    {
        return $this->hasOne(BahanConference::class, 'bahan_id');
    }

    public function quiz()
    {
        return $this->hasOne(BahanQuiz::class, 'bahan_id');
    }

    public function scorm()
    {
        return $this->hasOne(BahanScorm::class, 'bahan_id');
    }

    public function audio()
    {
        return $this->hasOne(BahanAudio::class, 'bahan_id');
    }

    public function video()
    {
        return $this->hasOne(BahanVideo::class, 'bahan_id');
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

        return $segmen;
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
