<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
use App\Models\Users\User;
class Announcement extends Model
{
    protected $table = 'announcements';
    protected $guarded = [];
    use Creator;

    public static function boot(){
        parent::boot();
        Announcement::observe(new \App\Observers\LogObserver);
        }

    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
