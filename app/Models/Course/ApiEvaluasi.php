<?php

namespace App\Models\Course;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ApiEvaluasi extends Model
{
    protected $table = 'api_evaluasi';
    protected $guarded = [];

    protected $casts = [
        'evaluasi' => 'array',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'start_time' => 'datetime',
    ];

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeComplete($query)
    {
        return $query->where('is_complete', 1);
    }
}
