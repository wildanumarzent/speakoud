<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanForumTopikDiskusi extends Model
{
    protected $table = 'bahan_forum_topik_diskusi';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function forum()
    {
        return $this->belongsTo(BahanForum::class, 'forum_id');
    }

    public function topik()
    {
        return $this->belongsTo(BahanForumTopik::class, 'forum_topik_id');
    }

    public function parent()
    {
        return $this->belongsTo(BahanForumTopikDiskusi::class, 'parent');
    }
}
