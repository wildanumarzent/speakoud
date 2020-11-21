<?php

namespace App\Models\Banner;

use App\Models\Konfigurasi;
use Illuminate\Database\Eloquent\Model;

class BannerKategori extends Model
{
    protected $table = 'banner_kategori';
    protected $guarded = [];

    public function banner()
    {
        return $this->hasMany(Banner::class, 'banner_kategori_id')->publish()
            ->orderBy('urutan', 'ASC')->limit(Konfigurasi::value('banner_limit'));
    }
}
