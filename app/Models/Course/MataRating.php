<?php

namespace App\Models\Course;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MataRating extends Model
{
    protected $table = 'mata_rating';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
