<?php

namespace App\Models\Course\Template;

use App\Models\Course\MataPelatihan;
use App\Models\Course\Template\Bahan\TemplateBahan;
use App\Models\Course\Template\Bahan\TemplateBahanQuiz;
use App\Models\Users\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class TemplateMata extends Model
{
    protected $table = 'template_mata';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        TemplateMata::observe(new LogObserver);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mataProgram()
    {
        return $this->hasMany(MataPelatihan::class, 'template_id');
    }

    public function bobot()
    {
        return $this->hasOne(TemplateMataBobot::class, 'template_mata_id');
    }

    public function materi()
    {
        return $this->hasMany(TemplateMateri::class, 'template_mata_id');
    }

    public function bahan()
    {
        return $this->hasMany(TemplateBahan::class, 'template_mata_id')
            ->whereNotNull('segmenable_id');
    }

    public function quiz()
    {
        return $this->hasMany(TemplateBahanQuiz::class, 'template_mata_id');
    }

    public function soalKategori()
    {
        return $this->hasMany(TemplateSoalKategori::class, 'template_mata_id');
    }

    public function soal()
    {
        return $this->hasMany(TemplateSoal::class, 'template_mata_id');
    }
}
