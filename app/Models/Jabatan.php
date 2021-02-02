<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Jabatan::observe(new \App\Observers\LogObserver);
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'jabatan_id');
    }
}
