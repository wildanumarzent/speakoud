<?php

namespace App\Models;

use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        Jabatan::observe(new LogObserver);
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'jabatan_id');
    }
}
