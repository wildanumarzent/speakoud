<?php

namespace App\Models\Course\Bahan;

use App\Models\BankData;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanTugas extends Model
{
    protected $table = 'bahan_tugas';
    protected $guarded = [];

    protected $casts = [
        'bank_data_id' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class, 'materi_id');
    }

    public function bahan()
    {
        return $this->belongsTo(BahanPelatihan::class, 'bahan_id');
    }

    public function respon()
    {
        return $this->hasMany(BahanTugasRespon::class, 'tugas_id');
    }

    public function responByUser()
    {
        return $this->hasOne(BahanTugasRespon::class, 'tugas_id')->where('user_id', auth()->user()->id);
    }

    public function files($bankDataId)
    {
        return BankData::whereIn('id', $bankDataId)->get();
    }
}
