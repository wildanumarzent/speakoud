<?php

namespace App\Models\Grades;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class GradesKategori extends Model
{
    protected $table = 'grades_kategori';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        GradesKategori::observe(new \App\Observers\LogObserver);
        }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function nilai()
    {
        return $this->hasMany(GradesNilai::class, 'kategori_id');
    }
}
