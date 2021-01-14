<?php

namespace App\Models\Kompetensi;


use App\Models\Course\MataPelatihan;
use App\Models\Kompetensi\KompetensiPeserta;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kompetensi\Kompetensi;
class KompetensiMata extends Model
{
    protected $table = 'kompetensi_mata';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }
     public function kompetensi()
     {
         return $this->belongsTo(Kompetensi::class, 'kompetensi_id');
     }

     public function kompetensiPeserta()
     {
         return $this->hasMany(KompetensiPeserta::class, 'kompetensi_id','kompetensi_id');
     }
}
