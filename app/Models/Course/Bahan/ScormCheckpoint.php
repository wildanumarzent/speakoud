<?php

namespace App\Models\Course\Bahan;

use Illuminate\Database\Eloquent\Model;

class ScormCheckpoint extends Model
{
    protected $table = 'scorm_checkpoint';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
