<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class MataBobotNilai extends Model
{
    protected $table = 'mata_bobot_nilai';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }
}
