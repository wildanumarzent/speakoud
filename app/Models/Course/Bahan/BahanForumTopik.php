<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanForumTopik extends Model
{
    protected $table = 'bahan_forum_topik';
    protected $guarded = [];

    protected $casts = [
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
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

    public function forum()
    {
        return $this->belongsTo(BahanForum::class, 'forum_id');
    }

    public function diskusi()
    {
        return $this->hasMany(BahanForumTopikDiskusi::class, 'forum_id');
    }

    public function lastPost()
    {
        return $this->hasMany(BahanForumTopikDiskusi::class, 'forum_id')
            ->orderBy('created_at', 'DESC')->limit(1);
    }

    public function starPerUser()
    {
        return $this->hasMany(BahanForumTopikStar::class, 'topik_id')
            ->where('user_id', auth()->user()->id);
    }

    public function starUser()
    {
        return $this->hasMany(BahanForumTopikStar::class, 'topik_id');
    }
}
