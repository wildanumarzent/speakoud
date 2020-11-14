<?php

namespace App\Models\Banner;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function kategori()
    {
        return $this->belongsTo(BannerKategori::class, 'banner_kategori_id');
    }
}
