<?php

namespace App\Models\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahan;
use App\Models\Course\Template\Bahan\TemplateBahanQuiz;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class TemplateMateri extends Model
{
    protected $table = 'template_materi';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        TemplateMateri::observe(new \App\Observers\LogObserver);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(TemplateMata::class, 'template_mata_id');
    }

    public function bahan()
    {
        return $this->hasMany(TemplateBahan::class, 'template_materi_id')->whereNotNull('segmenable_id');
    }

    public function quiz()
    {
        return $this->hasMany(TemplateBahanQuiz::class, 'template_materi_id');
    }
}
