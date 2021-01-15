<?php

namespace App\Models\Badge;

use App\Events\BadgeSaved;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Peserta;
use App\Models\Badge\Badge;
class BadgePeserta extends Model
{
    protected $guarded = [];
    protected $table = 'badge_peserta';


    protected $dispatchesEvents = [
        'created' => BadgeSaved::class,
    ];


    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

}
