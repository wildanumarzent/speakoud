<?php

namespace App\Models\Instansi;

use App\Models\Users\Mitra;
use Illuminate\Database\Eloquent\Model;

class InstansiMitra extends Model
{
    protected $table = 'instansi_mitra';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        InstansiMitra::observe(new \App\Observers\LogObserver);
        }

    public function mitra()
    {
        return $this->hasMany(Mitra::class, 'instansi_id');
    }

    public function getLogo($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.logo_instansi').$value);
        } else {
            $photo = asset(config('addon.images.logo_instansi'));
        }

        return $photo;
    }
}
