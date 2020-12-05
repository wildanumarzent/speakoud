<?php

namespace App\Models\Grades;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class GradesKategori extends Model
{
    protected $table = 'grades_kategori';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
