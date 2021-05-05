<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internal extends Model
{
    use SoftDeletes;

    protected $table = 'internal';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        Internal::observe(new LogObserver);
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
