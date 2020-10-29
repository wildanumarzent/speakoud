<?php

namespace App\Models\Course;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ProgramPelatihan extends Model
{
    protected $table = 'bank_data';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
