<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'email_verified', 'active',
        'photo', 'ip_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active_at' => 'datetime',
        'first_access' => 'datetime',
        'last_login' => 'datetime',
        'last_access' => 'datetime',
        'photo' => 'array'
    ];

    public function userable()
    {
        return $this->morphTo();
    }

    public function information()
    {
        return $this->hasOne(UserInformation::class, 'user_id');
    }

    public function getPhoto($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.photo').$value);
        } else {
            $photo = asset(config('addon.images.photo'));
        }

        return $photo;
    }
}
