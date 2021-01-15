<?php

namespace App\Models\Journey;

use App\Models\Kompetensi\KompetensiPeserta;
use App\Models\Journey\JourneyKompetensi;
use App\Traits\Creator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class Journey extends Model
{
    use Creator;
    protected $table = 'journey';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'creator_id');
    }
    public function journeyPeserta()
    {
        return $this->hasMany(JourneyPeserta::class, 'journey_id');
    }
    public function journeyKompetensi()
    {
        return $this->hasMany(JourneyKompetensi::class, 'journey_id');
    }
}
