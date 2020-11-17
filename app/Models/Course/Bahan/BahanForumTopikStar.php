<?php

namespace App\Models\Course\Bahan;

use Illuminate\Database\Eloquent\Model;

class BahanForumTopikStar extends Model
{
    protected $table = 'bahan_forum_topik_star';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function forum()
    {
        return $this->belongsTo(BahanForum::class, 'forum_id');
    }

    public function topik()
    {
        return $this->belongsTo(BahanForumTopik::class, 'topik_id');
    }
}
