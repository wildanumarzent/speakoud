<?php

namespace App\Models\Sertifikasi;

use App\Models\Course\MataPelatihan;
use App\Models\Users\Peserta;
use Illuminate\Database\Eloquent\Model;

class SertifikatPeserta extends Model
{
    protected $table = 'sertifikat_peserta';
    protected $guarded = [];

    public function sertifikat()
    {
        return $this->belongsTo(SertifikatInternal::class, 'sertifikat_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
