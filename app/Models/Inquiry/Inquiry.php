<?php

namespace App\Models\Inquiry;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiry';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        Inquiry::observe(new \App\Observers\LogObserver);
        }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
