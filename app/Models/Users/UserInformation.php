<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $table = 'users_information';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
