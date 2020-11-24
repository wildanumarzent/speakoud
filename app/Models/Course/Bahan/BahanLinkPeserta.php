<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanLinkPeserta extends Model
{
    protected $table = 'link_user_tracker';
    protected $guarded = [];

    protected $casts = [
        'join' => 'datetime',
        'check_in' => 'datetime',
    ];

    public function link()
    {
        return $this->belongsTo(BahanLink::class, 'link_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
