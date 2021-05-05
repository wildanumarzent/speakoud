<?php

namespace App\Models\Instansi;

use App\Models\Users\Mitra;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class InstansiMitra extends Model
{
    protected $table = 'instansi_mitra';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        InstansiInternal::observe(new LogObserver);
    }

    public function mitra()
    {
        return $this->hasMany(Mitra::class, 'instansi_id');
    }

    public function logoSrc($value)
    {
        if (!empty($value)) {
            $photo = asset(config('custom.files.logo_instansi.path').$value);
        } else {
            $photo = asset(config('custom.files.logo_instansi.f'));
        }

        return $photo;
    }
}
