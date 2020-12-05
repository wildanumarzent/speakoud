<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    protected $table = 'instruktur';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function instansi($item)
    {
        if ($item->user->hasRole('instruktur_internal')) {
            return InstansiInternal::find($item->instansi_id);
        } else {
            return InstansiMitra::find($item->instansi_id);
        }
    }
}
