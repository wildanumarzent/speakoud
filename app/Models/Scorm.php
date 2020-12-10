<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class Scorm extends Model
{
    protected $table = 'scorm';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    }
}
