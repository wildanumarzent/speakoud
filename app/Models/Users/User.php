<?php

namespace App\Models\Users;

use App\Models\RecordTahunan;
use App\Models\Course\MataPelatihan;
use App\Observers\LogObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

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
        'active' => 'boolean',
        'photo' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        
        User::observe(new LogObserver);
    }

    public function mataPelatihan()
    {
        return $this->hasMany(MataPelatihan::class, 'creator_id');
    }
    public function userable()
    {
        return $this->morphTo();
    }

    public function information()
    {
        return $this->hasOne(UserInformation::class, 'user_id');
    }

    public function internal()
    {
        return $this->hasOne(Internal::class, 'user_id');
    }

    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'user_id');
    }

    public function instruktur()
    {
        return $this->hasOne(Instruktur::class, 'user_id');
    }

    public function peserta()
    {
        return $this->hasOne(Peserta::class, 'user_id');
    }

    public function getDataByRole($user)
    {
        $data = $user;

        if ($user->internal()->count() > 0) {
            $data = $user->internal;
        }

        if ($user->mitra()->count() > 0) {
            $data = $user->mitra;
        }

        if ($user->instruktur()->count() > 0) {
            $data = $user->instruktur;
        }

        if ($user->peserta()->count() > 0) {
            $data = $user->peserta;
        }

        return $data;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getPhoto($value)
    {
        if (!empty($value)) {
            $photo = asset(config('custom.files.photo.path').$value);
        } else {
            $photo = asset(config('custom.files.photo.f'));
        }

        return $photo;
    }
    
    public function totalJP()
    {
        return $this->hasOne(RecordTahunan::class,'user_id');
    }
}
