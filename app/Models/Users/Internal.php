<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use Illuminate\Database\Eloquent\Model;

class Internal extends Model
{
    protected $table = 'internal';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
    ];

    public static function boot(){
        parent::boot();
        Internal::observe(new \App\Observers\LogObserver);
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
        return $this->belongsTo(InstansiInternal::class, 'instansi_id');
    }
}
