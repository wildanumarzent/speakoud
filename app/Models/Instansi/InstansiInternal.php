<?php

namespace App\Models\Instansi;

use App\Models\Users\Internal;
use Illuminate\Database\Eloquent\Model;

class InstansiInternal extends Model
{
    protected $table = 'instansi_internal';
    protected $guarded = [];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];

    public function internal()
    {
        return $this->hasMany(Internal::class, 'instansi_id');
    }

    public function getLogo($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.logo_instansi').$value);
        } else {
            $photo = asset(config('addon.images.logo_instansi'));
        }

        return $photo;
    }
}
