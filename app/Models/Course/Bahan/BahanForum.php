<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Badge\Badge;

class BahanForum extends Model
{
    protected $table = 'bahan_forum';
    protected $guarded = [];

    public function badge()
    {
        return $this->hasMany(Badge::class, 'tipe_id', 'id')->where('tipe','forum');
    }
    public static function boot() {
        parent::boot();
        static::deleting(function($bahan) { // before delete() method call this
             $bahan->badge()->delete();
             // do the rest of the cleanup...
        });
    }

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

    public function topik()
    {
        return $this->hasMany(BahanForumTopik::class, 'forum_id');
    }

    public function topikByUser()
    {
        return $this->hasMany(BahanForumTopik::class, 'forum_id')->where('creator_id', auth()->user()->id);
    }
}
