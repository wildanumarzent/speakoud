<?php

namespace App\models\Course;

use App\Models\Course\MataPelatihan;
use App\Models\Users\{Peserta, Instruktur};
use Illuminate\Database\Eloquent\Model;

class PelatihanKhusus extends Model
{
    protected $table = 'platihan_khusus';
    protected $guarded = [];

    public function pelatihan()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function peserta()
    {
        return $this->belongsTo(peserta::class, 'peserta_id');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }

    public function mataPelatihan()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }
}
