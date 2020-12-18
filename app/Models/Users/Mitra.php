<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiMitra;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
    ];

    public static function boot(){
        parent::boot();
        Mitra::observe(new \App\Observers\LogObserver);
        }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiMitra::class, 'instansi_id');
    }
}
