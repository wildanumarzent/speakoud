<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanConferencePeserta extends Model
{
    protected $table = 'conference_user_tracker';
    protected $guarded = [];

    protected $casts = [
        'join' => 'datetime',
        'check_in' => 'datetime',
        'leave' => 'datetime',
    ];

    public function link()
    {
        return $this->belongsTo(BahanConference::class, 'link_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
