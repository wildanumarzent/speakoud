<?php

namespace App\Models\Banner;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        Banner::observe(new \App\Observers\LogObserver);
        }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function kategori()
    {
        return $this->belongsTo(BannerKategori::class, 'banner_kategori_id');
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
