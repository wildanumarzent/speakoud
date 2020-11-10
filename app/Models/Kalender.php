<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
class Kalender extends Model
{
    protected $table = 'event';
    protected $guarded = [];
    use Creator; // menambahkan auth()->user->id setiap create
}
