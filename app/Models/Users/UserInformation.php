<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $table = 'users_information';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        UserInformation::observe(new \App\Observers\LogObserver);
        }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
