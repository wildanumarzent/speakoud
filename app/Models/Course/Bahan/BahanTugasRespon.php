<?php

namespace App\Models\Course\Bahan;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanTugasRespon extends Model
{
    protected $table = 'bahan_tugas_respon';
    protected $guarded = [];

    protected $casts = [
        'files' => 'array',
    ];

    public function tugas()
    {
        return $this->belongsTo(BahanTugas::class, 'tugas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
