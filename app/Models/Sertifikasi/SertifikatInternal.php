<?php

namespace App\Models\Sertifikasi;

use App\Models\Course\MataPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SertifikatInternal extends Model
{
    protected $table = 'sertifikat_internal';
    protected $guarded = [];

    protected $dates = [
        'tanggal',
    ];

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
        return $this->hasMany(SertifikatPeserta::class, 'sertifikat_id');
    }
}
