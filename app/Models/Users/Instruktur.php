<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruktur extends Model
{
    use SoftDeletes;

    protected $table = 'instruktur';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
    ];

    public static function boot(){
        parent::boot();
        Instruktur::observe(new \App\Observers\LogObserver);
        }

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
