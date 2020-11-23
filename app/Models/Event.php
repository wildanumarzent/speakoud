<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
class Event extends Model
{
    protected $table = 'event';
    protected $guarded = [];
    use Creator; // menambahkan auth()->user->id setiap create
}
