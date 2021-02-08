<?php

namespace App\Models\Course\Bahan;

use App\Models\Badge\Badge;
use App\Models\Course\ApiEvaluasi;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;
class BahanPelatihan extends Model
{
    protected $table = 'bahan_pelatihan';
    protected $guarded = [];

    protected $casts = [
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
        'completion_parameter' => 'array',
    ];

    public function badge()
    {
        return $this->hasMany(Badge::class, 'tipe_id', 'id')->where('tipe','materi');
    }
    public static function boot() {
        parent::boot();
        BahanPelatihan::observe(new \App\Observers\LogObserver);
        static::deleting(function($bahan) { // before delete() method call this
             $bahan->badge()->delete();
             // do the rest of the cleanup...
        });
    }

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

    public function tugas()
    {
        return $this->hasOne(BahanTugas::class, 'bahan_id');
    }

    public function evaluasiPengajar()
    {
        return $this->hasOne(BahanEvaluasiPengajar::class, 'bahan_id');
    }

    public function userEvaluasiPengajar()
    {
        return $this->hasMany(ApiEvaluasi::class, 'bahan_id')->where('user_id', auth()->user()->id);
    }

    public function activityCompletionByUser()
    {
        return $this->hasOne(ActivityCompletion::class, 'bahan_id')->where('user_id', auth()->user()->id);
    }

    public function restrictBahan($id)
    {
        return BahanPelatihan::where('id', $id)->whereNotNull('segmenable_id')->first();
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

        if ($bahan->evaluasiPengajar()->count() == 1) {
            $segmen = [
                'tipe' => 'evaluasi-pengajar',
                'title' => 'Evaluasi Pengajar',
                'icon' => 'user-tie'
            ];
        }

        return $segmen;
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
