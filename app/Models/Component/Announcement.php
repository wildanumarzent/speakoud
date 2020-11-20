<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
class Announcement extends Model
{
    protected $table = 'announcements';
    protected $guarded = [];
    use Creator;
}
