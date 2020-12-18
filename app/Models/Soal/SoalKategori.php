<?php

namespace App\Models\Soal;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SoalKategori extends Model
{
    protected $table = 'bank_soal_kategori';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        SoalKategori::observe(new \App\Observers\LogObserver);
        }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'kategori_id');
    }
}
