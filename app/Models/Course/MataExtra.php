<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class MataExtra extends Model
{
    protected $table = 'mata_extra';
    protected $fillable = ['mata_id','user_id','persentase'];
}
