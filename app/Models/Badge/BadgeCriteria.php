<?php

namespace App\Models\Badge;

use Illuminate\Database\Eloquent\Model;
use App\Models\Badge\Badge;
class BadgeCriteria extends Model
{
    protected $guarded = [];
    protected $table = 'badge_criteria';

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }
}
