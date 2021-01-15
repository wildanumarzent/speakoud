<?php

namespace App\Models\Journey;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Peserta;
use App\Models\Journey\Journey;
class JourneyPeserta extends Model
{
    protected $table = 'journey_peserta';
    protected $guarded = [];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class, 'journey_id');
    }


}
