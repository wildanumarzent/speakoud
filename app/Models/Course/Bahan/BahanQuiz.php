<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanQuiz extends Model
{
    protected $table = 'bahan_quiz';
    protected $guarded = [];

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

    public function bahan()
    {
        return $this->belongsTo(BahanPelatihan::class, 'bahan_id');
    }

    public function item()
    {
        return $this->hasMany(BahanQuizItem::class, 'quiz_id');
    }
}
