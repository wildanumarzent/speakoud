<?php

namespace App\Models\Grades;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class GradesNilai extends Model
{
    protected $table = 'grades_nilai';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(GradesKategori::class, 'kategori_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}