<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanQuizUserTracker extends Model
{
    protected $table = 'quiz_user_tracker';
    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(BahanQuiz::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
