<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
class Tags extends Model
{
    protected $table = 'tags';
    protected $guarded = [];
    use Creator; // menambahkan auth()->user->id setiap create
}
