<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
        'surat_ijin_atasan' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
