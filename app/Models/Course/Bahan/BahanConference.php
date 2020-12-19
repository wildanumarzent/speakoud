<?php

namespace App\Models\Course\Bahan;

use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\ProgramPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BahanConference extends Model
{
    protected $table = 'bahan_conference';
    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'api' => 'array'
    ];
    protected $dates = [
        'tanggal',
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

    public function trackByUser()
    {
        return $this->hasOne(BahanConferencePeserta::class, 'conference_id')
            ->where('user_id', auth()->user()->id);
    }
}
