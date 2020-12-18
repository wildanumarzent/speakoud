<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];
    protected $table = 'logs';

    public function logable()
    {
        return $this->morphTo();
    }
}
