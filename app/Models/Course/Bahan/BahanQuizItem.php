<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanQuizItem extends Model
{
    protected $table = 'bahan_quiz_item';
    protected $guarded = [];

    protected $casts = [
        'pilihan' => 'array',
        'jawaban' => 'array',
    ];

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

    public function quiz()
    {
        return $this->belongsTo(BahanQuiz::class, 'quiz_id');
    }

    public function track($userId)
    {
        return $this->hasOne(BahanQuizItemTracker::class,'quiz_item_id')->where('user_id',$userId);
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
