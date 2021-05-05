<?php

namespace App\Models\Soal;

use App\Models\Course\MataPelatihan;
use App\Models\Users\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class SoalKategori extends Model
{
    protected $table = 'bank_soal_kategori';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        SoalKategori::observe(new LogObserver);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'kategori_id');
    }
}
