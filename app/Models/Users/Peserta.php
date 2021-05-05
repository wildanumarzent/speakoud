<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use App\Models\Instansi\InstansiMitra;
use App\Models\Jabatan;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;

    protected $table = 'peserta';
    protected $guarded = [];

    protected $casts = [
        'sk_cpns' => 'array',
        'sk_pengangkatan' => 'array',
        'sk_golongan' => 'array',
        'sk_jabatan' => 'array',
        'surat_ijin_atasan' => 'array',
        'tanggal_lahir' => 'date',
    ];

    public static function boot()
    {
        parent::boot();

        Peserta::observe(new LogObserver);
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
        if ($item->user->hasRole('peserta_internal')) {
            return InstansiInternal::find($item->instansi_id);
        } else {
            return InstansiMitra::find($item->instansi_id);
        }
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function getFotoSertifikat($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.photo').'sertifikat/'.$value);
        } else {
            $photo = asset(config('addon.images.photo'));
        }

        return $photo;
    }

}
