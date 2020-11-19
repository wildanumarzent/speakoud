<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
use App\Models\Users\User;
use App\Models\Component\TagsTipe;
class Tags extends Model
{
    protected $table = 'tags';
    protected $guarded = [];
    use Creator; // menambahkan auth()->user->id setiap create

    public function tagsTipe(){
        return $this->hasMany(TagsTipe::class,'tag_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
