<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiInternal;
use Illuminate\Database\Eloquent\Model;

class Internal extends Model
{
    protected $table = 'internal';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiInternal::class, 'instansi_id');
    }
}
