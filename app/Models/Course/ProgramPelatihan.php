<?php

namespace App\Models\Course;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Users\Mitra;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProgramPelatihan extends Model
{
    protected $table = 'program_pelatihan';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function mata()
    {
        return $this->hasMany(MataPelatihan::class, 'program_id');
    }

    public function mataPublish()
    {
        $query = $this->hasMany(MataPelatihan::class, 'program_id');
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->whereHas('instruktur', function ($query) {
                $query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
            });
        }
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $query->publish()->orderBy('urutan', 'ASC')->where('publish_start', '<=', Carbon::now()->format('Y-m-d H:i'))
                ->where('publish_end', '>=', Carbon::now()->format('Y-m-d H:i'));
            $query->whereHas('program', function ($query) {
                $query->publish();
                if (auth()->user()->hasRole('peserta_mitra')) {
                    $query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
                } else {
                    $query->where('tipe', 0);
                }
            });
            $query->whereHas('peserta', function ($query) {
                $query->where('peserta_id', auth()->user()->peserta->id);
            });
        }

        return $query;
    }

    public function materi()
    {
        return $this->hasMany(MateriPelatihan::class, 'program_id');
    }

    public function bahan()
    {
        return $this->hasMany(BahanPelatihan::class, 'program_id');
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
