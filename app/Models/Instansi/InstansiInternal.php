<?php

namespace App\Models\Instansi;

use App\Models\Users\Internal;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;

class InstansiInternal extends Model
{
    protected $table = 'instansi_internal';
    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();

        InstansiInternal::observe(new LogObserver);
    }

    public function internal()
    {
        return $this->hasMany(Internal::class, 'instansi_id');
    }

    public function logoSrc($value)
    {
        if (!empty($value)) {
            $photo = asset(config('custom.files.logo_instansi.path').$value);
        } else {
            $photo = asset(config('custom.files.logo_instansi.f'));
        }

        return $photo;
    }
}
