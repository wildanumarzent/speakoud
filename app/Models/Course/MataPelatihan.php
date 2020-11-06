<?php

namespace App\Models\Course;

use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MataPelatihan extends Model
{
    protected $table = 'mata_pelatihan';
    protected $guarded = [];

    protected $casts = [
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
        'cover' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_id');
    }

    public function materi()
    {
        return $this->hasMany(MateriPelatihan::class, 'mata_id');
    }

    public function getCover($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.cover').$value);
        } else {
            $photo = asset(config('addon.images.cover'));
        }

        return $photo;
    }

    public function bahan()
    {
        return $this->hasMany(BahanPelatihan::class, 'mata_id');
    }
}
