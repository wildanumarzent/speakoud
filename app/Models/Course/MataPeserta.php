<?php

namespace App\Models\Course;

use App\Models\Users\Peserta;
use Illuminate\Database\Eloquent\Model;

class MataPeserta extends Model
{
    protected $table = 'mata_peserta';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function scopeApprove($query)
    {
        return $query->where('status', 1);
    }
}
