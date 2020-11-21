<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
use App\Models\Users\User;
class KomentarBalasan extends Model
{
    protected $table = 'komentar_balasan';
    protected $guarded = [];
    use Creator;

    public function komentar()
    {
        return $this->belongsTo(Komentar::class, 'komentar_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
