<?php

namespace App\Models\Badge;

use App\Models\Course\Bahan\BahanForum;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Creator;
class Badge extends Model
{
    protected $table = 'badge';
    protected $guarded = [];
    use Creator;

    public static function boot(){
        parent::boot();
        Badge::observe(new \App\Observers\LogObserver);
        }
    public function program()
    {
        return $this->belongsTo(MataPelatihan::class, 'tipe_id');
    }
    public function mata()
    {
        return $this->belongsTo(MateriPelatihan::class, 'tipe_id');
    }
    public function materi()
    {
        return $this->belongsTo(BahanPelatihan::class, 'tipe_id');
    }
    public function topic()
    {
        return $this->belongsTo(BahanForumTopik::class, 'tipe_id');
    }
    public function forum()
    {
        return $this->belongsTo(BahanForum::class, 'tipe_id');
    }

}
