<?php

namespace App\Models\Course;

use App\Models\Component\Komentar;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Sertifikasi\SertifikatExternal;
use App\Models\Sertifikasi\SertifikatInternal;
use App\Models\Sertifikasi\SertifikatPeserta;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MataPelatihan extends Model
{
    protected $table = 'mata_pelatihan';
    protected $guarded = [];

    protected $casts = [
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
        'cover' => 'array',
    ];

    public static function boot(){
        parent::boot();
        MataPelatihan::observe(new \App\Observers\LogObserver);
        }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_id');
    }

    public function bobot()
    {
        return $this->hasOne(MataBobotNilai::class, 'mata_id');
    }

    public function sertifikatInternal()
    {
        return $this->hasOne(SertifikatInternal::class, 'mata_id');
    }

    public function sertifikatPeserta()
    {
        return $this->hasOne(SertifikatPeserta::class, 'mata_id')
            ->where('peserta_id', auth()->user()->peserta->id);
    }

    public function sertifikatExternalByUser()
    {
        return $this->hasMany(SertifikatExternal::class, 'mata_id')
            ->where('peserta_id', auth()->user()->peserta->id);
    }

    public function instruktur()
    {
        return $this->hasMany(MataInstruktur::class, 'mata_id');
    }

    public function peserta()
    {
        return $this->hasMany(MataPeserta::class, 'mata_id');
    }

    public function materi()
    {
        return $this->hasMany(MateriPelatihan::class, 'mata_id');
    }

    public function materiPublish()
    {
        return $this->hasMany(MateriPelatihan::class, 'mata_id')->publish()
            ->orderBy('urutan', 'ASC');
    }

    public function bahan()
    {
        return $this->hasMany(BahanPelatihan::class, 'mata_id');
    }

    public function evaluasiByUser()
    {
        return $this->hasMany(ApiEvaluasi::class, 'mata_id')->where('user_id', auth()->user()->id);
    }

    public function comment()
    {
        return $this->morphMany(Komentar::class, 'commentable');
    }

    public function rating()
    {
        return $this->hasMany(MataRating::class, 'mata_id');
    }

    public function ratingByUser()
    {
        return $this->hasOne(MataRating::class, 'mata_id')->where('user_id', auth()->user()->id);
    }

    public function getRating($type, $rate = null)
    {
        $mata = $this->hasMany(MataRating::class, 'mata_id');

        if ($type == 'review') {
            $rating = $mata->where('rating', '>', 0)->avg('rating');
        }

        if ($type == 'student_rating') {
            $rating = $mata->count();
        }

        if ($type == 'per_rating') {
            $rating = $mata->where('rating', $rate)->count();
        }

        return $rating;
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
