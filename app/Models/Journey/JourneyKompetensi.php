<?php

namespace App\Models\Journey;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kompetensi\Kompetensi;
use App\Models\Journey\Journey;
use App\Models\Kompetensi\KompetensiPeserta;

class JourneyKompetensi extends Model
{
    protected $table = 'journey_kompetensi';
    protected $guarded = [];

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class,'kompetensi_id');
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class,'journey_id');
    }
    public function journeyPeserta()
    {
        return $this->hasMany(JourneyPeserta::class, 'journey_id', 'journey_id');
    }
    public function kompetensiPeserta()
    {
        return $this->hasMany(KompetensiPeserta::class, 'kompetensi_id', 'kompetensi_id');
    }

}
