<?php

namespace App\Models\Course;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MateriPelatihan extends Model
{
    protected $table = 'materi_pelatihan';
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

    public function bahan()
    {
        return $this->hasMany(BahanPelatihan::class, 'materi_id');
    }

    public function bahanPublish($tipe = null)
    {
        $query = $this->hasMany(BahanPelatihan::class, 'materi_id');

        if ($tipe == 'jump') {
            $query->whereNotIn('id', [request()->segment(4)]);
        }
        $query->where('publish', 1)->orderBy('urutan', 'ASC');

        return $query;
    }
}
