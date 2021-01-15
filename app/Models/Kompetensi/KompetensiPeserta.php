<?php

namespace App\Models\Kompetensi;

use App\Models\Journey\JourneyPeserta;
use App\Models\Users\Peserta;
use App\Models\Kompetensi\Kompetensi;
use Illuminate\Database\Eloquent\Model;

class KompetensiPeserta extends Model
{
    protected $table = 'kompetensi_peserta';
    protected $guarded = [];

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class, 'kompetensi_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
    public function hasJourneyPeserta()
    {
        return $this->hasMany(JourneyPeserta::class,'peserta_id','peserta_id');
    }
    public function hasKompetensiMata()
    {
        return $this->hasMany(KompetensiMata::class,'kompetensi_id','kompetensi_id');
    }
}
