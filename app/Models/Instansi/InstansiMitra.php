<?php

namespace App\Models\Instansi;

use Illuminate\Database\Eloquent\Model;

class InstansiMitra extends Model
{
    protected $table = 'instansi_mitra';
    protected $guarded = [];

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
