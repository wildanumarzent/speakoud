<?php

namespace App\Models\Kompetensi;

use App\Traits\Creator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
class Kompetensi extends Model
{
    use Creator;
    protected $table = 'kompetensi';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function kompetensiMata(){
        return $this->hasMany(KompetensiMata::class, 'kompetensi_id','id');
    }
}
