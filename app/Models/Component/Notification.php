<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = [];

    public function notifable()
    {
        return $this->morphTo();
    }
}
