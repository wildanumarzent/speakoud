<?php

namespace App\Models\Inquiry;

use Illuminate\Database\Eloquent\Model;

class InquiryContact extends Model
{
    protected $table = 'inquiry_contact';
    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'submit_time' => 'datetime'
    ];

    public static function boot(){
        parent::boot();
        InquiryContact::observe(new \App\Observers\LogObserver);
        }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }
}
