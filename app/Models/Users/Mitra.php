<?php

namespace App\Models\Users;

use App\Models\Instansi\InstansiMitra;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
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
        return $this->belongsTo(InstansiMitra::class, 'instansi_id');
    }
}
