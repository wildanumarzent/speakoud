<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataInstruktur;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanEvaluasiPengajar extends Model
{
    protected $table = 'bahan_evaluasi_pengajar';
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

    public function mataInstruktur()
    {
        return $this->belongsTo(MataInstruktur::class, 'mata_instruktur_id');
    }
}
