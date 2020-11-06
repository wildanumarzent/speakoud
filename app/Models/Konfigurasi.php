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

    public function scopeUpload($query)
    {
        return $query->where('is_upload', 1);
    }

    static function value($name)
    {
        return Konfigurasi::select('value')->where('name', $name)->first()['value'];
    }
}
