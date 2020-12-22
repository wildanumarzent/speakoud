<?php

namespace App\Models\Badge;

use Illuminate\Database\Eloquent\Model;
use App\Models\Badge\Badge;
use App\Models\Course\MataPelatihan;

class BadgeMata extends Model
{
    protected $guarded = [];
    protected $table = 'badge_mata';

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }
}
