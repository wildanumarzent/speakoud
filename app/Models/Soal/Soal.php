<?php

namespace App\Models\Soal;

use App\Models\Course\MataPelatihan;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'bank_soal';
    protected $guarded = [];

    protected $casts = [
        'pilihan' => 'array',
        'jawaban' => 'array',
    ];

    public static function boot(){
        parent::boot();
        Soal::observe(new \App\Observers\LogObserver);
        }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function mata()
    {
        return $this->belongsTo(MataPelatihan::class, 'mata_id');
    }

    public function kategori()
    {
        return $this->belongsTo(SoalKategori::class, 'kategori_id');
    }

    public function tipe($item)
    {
        if ($item == 0) {
            $tipe = [
                'title' => 'Multiple Choice',
                'color' => 'success'
            ];
        } elseif ($item == 1) {
            $tipe = [
                'title' => 'Exact',
                'color' => 'primary'
            ];
        } elseif ($item == 2) {
            $tipe = [
                'title' => 'Essay',
                'color' => 'danger'
            ];
        } elseif ($item == 3) {
            $tipe = [
                'title' => 'True / False',
                'color' => 'secondary'
            ];
        }

        return $tipe;
    }
}
