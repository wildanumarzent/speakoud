<?php

namespace App\Models\Grades;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class PersenNilai extends Model
{
    protected $table = 'persen_nilai';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
