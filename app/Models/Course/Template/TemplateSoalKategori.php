<?php

namespace App\Models\Course\Template;

use App\Models\Users\User;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class TemplateSoalKategori extends Model
{
    protected $table = 'template_soal_kategori';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        TemplateSoalKategori::observe(new LogObserver);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(TemplateMata::class, 'template_mata_id');
    }

    public function soal()
    {
        return $this->hasMany(TemplateSoal::class, 'template_kategori_id');
    }
}
