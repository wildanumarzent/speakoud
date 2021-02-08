<?php

namespace App\Models\Course;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Users\Instruktur;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Badge\Badge;

class MateriPelatihan extends Model
{
    protected $table = 'materi_pelatihan';
    protected $guarded = [];


    public static function boot(){
        parent::boot();
        MateriPelatihan::observe(new \App\Observers\LogObserver);
        static::deleting(function($bahan) { // before delete() method call this
            $bahan->badge()->delete();
            // do the rest of the cleanup...
       });
        }

        public function badge()
        {
        return $this->hasMany(Badge::class, 'tipe_id', 'id')->where('tipe','mata');
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

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }

    public function bahan()
    {
        return $this->hasMany(BahanPelatihan::class, 'materi_id')->whereNotNull('segmenable_id');
    }

    public function quiz()
    {
        return $this->hasMany(BahanQuiz::class, 'materi_id');
    }

    public function bahanPublish($tipe = null)
    {
        $query = $this->hasMany(BahanPelatihan::class, 'materi_id')->whereNotNull('segmenable_id');

        if ($tipe == 'jump') {
            $query->whereNotIn('id', [request()->segment(4)]);
        }
        $query->publish()->orderBy('urutan', 'ASC');

        return $query;
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
