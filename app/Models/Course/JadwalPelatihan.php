<?php

namespace App\Models\Course;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class JadwalPelatihan extends Model
{
    protected $table = 'jadwal_pelatihan';
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cover' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }

    public function getCover($value)
    {
        if (!empty($value)) {
            $cover = asset(config('addon.images.path.cover').$value);
        } else {
            $cover = asset(config('addon.images.cover'));
        }

        return $cover;
    }
}
