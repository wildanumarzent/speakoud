<?php

namespace App\models\Course;

use App\Models\Course\MataPelatihan;
use App\Models\Users\Peserta;
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
}
