<?php

namespace App\Models\Course\Template\Bahan;

use App\Models\Course\Template\TemplateMata;
use App\Models\Course\Template\TemplateMateri;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class TemplateBahanQuizItem extends Model
{
    protected $table = 'template_bahan_quiz_item';
    protected $guarded = [];

    protected $casts = [
        'pilihan' => 'array',
        'jawaban' => 'array',
    ];

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

    public function bahan()
    {
        return $this->belongsTo(TemplateBahan::class, 'template_bahan_id');
    }

    public function quiz()
    {
        return $this->belongsTo(TemplateBahanQuiz::class, 'template_quiz_id');
    }

    public function shufflePilihan($item)
    {
        $array = $item;

        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $output = $new;

        return $output;
    }
}
