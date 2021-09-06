<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Traits\Creator;
class Komentar extends Model
{
    protected $table = 'komentar';
    protected $guarded = [];
    use Creator;

    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
