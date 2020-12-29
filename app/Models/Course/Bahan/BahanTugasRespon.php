<?php

namespace App\Models\Course\Bahan;

use App\Models\BankData;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanTugasRespon extends Model
{
    protected $table = 'bahan_tugas_respon';
    protected $guarded = [];

    protected $casts = [
        'bank_data_id' => 'array',
        'approval_time' => 'datetime'
    ];

    public function tugas()
    {
        return $this->belongsTo(BahanTugas::class, 'tugas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files($bankDataId)
    {
        return BankData::whereIn('id', $bankDataId)->get();
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approval_by');
    }
}
