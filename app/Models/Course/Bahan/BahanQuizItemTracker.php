<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanQuizItemTracker extends Model
{
    protected $table = 'quiz_item_tracker';
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(BahanQuiz::class, 'quiz_id');
    }

  
    public function item()
    {
        return $this->belongsTo(BahanQuizItem::class, 'quiz_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
