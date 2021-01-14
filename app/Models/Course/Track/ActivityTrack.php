<?php

namespace App\Models\Course\Track;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Users\User;
class ActivityTrack extends Model
{
    protected $table = 'track_aktivitas';
    protected $guarded = [''];

   

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class, 'materi_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

}
