<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    protected $table = 'konfigurasi';
    protected $primaryKey = 'name';
    protected $guarded = [];

    public $incrementing = false;
    public $timestamps = false;

    // logging 15 data sekaligus?
    
    // public static function boot(){
    //     parent::boot();
    //     Konfigurasi::observe(new \App\Observers\LogObserver);
    //     }

    public function scopeUpload($query)
    {
        return $query->where('is_upload', 1);
    }

    static function value($name)
    {
        $value = Konfigurasi::select('value')->where('name', $name)->first();
        if (!empty($value->value)) {
            $val = $value->value;
        } else {
            $val = '';
        }

        return $val;
    }

    static function banner()
    {
        $file = Konfigurasi::select('value')->where('name', 'banner_default')->first();

        if (!empty($file->value)) {
            $banner = asset(config('addon.images.path.banner').$file->value);
        } else {
            $banner = asset(config('addon.images.banner_default'));
        }

        return $banner;
    }
}
