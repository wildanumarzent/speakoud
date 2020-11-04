<?php

namespace App\Models\Course;

use App\Models\Users\Mitra;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ProgramPelatihan extends Model
{
    protected $table = 'program_pelatihan';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function mata()
    {
        return $this->hasMany(MataPelatihan::class, 'program_id');
    }
}
