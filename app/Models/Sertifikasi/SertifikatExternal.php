<?php

namespace App\Models\Sertifikasi;

use App\Models\Course\MataPelatihan;
use App\Models\Users\Peserta;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SertifikatExternal extends Model
{
    protected $table = 'sertifikat_external';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
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
