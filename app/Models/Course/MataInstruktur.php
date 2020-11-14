<?php

namespace App\Models\Course;

use App\Models\Users\Instruktur;
use Illuminate\Database\Eloquent\Model;

class MataInstruktur extends Model
{
    protected $table = 'mata_instruktur';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }
}
