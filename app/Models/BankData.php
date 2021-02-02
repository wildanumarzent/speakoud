<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    protected $table = 'bank_data';
    protected $guarded = [];

    public static function boot(){
        parent::boot();
        BankData::observe(new \App\Observers\LogObserver);
        }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeVideo($query)
    {
        return $query->where('is_video', 1);
    }

    public function NameFile($name)
    {
        $filename = $name->filename ?? collect(explode("/", $name->file_path))->last();

        return $filename;
    }

    public function icon($type)
    {
        if ($type == 'jpg' || $type == 'jpeg' || $type == 'png' ||
            $type == 'svg' || $type == 'jpg') {
            $ext = 'image';
        } elseif ($type == 'mp4' || $type == 'webm') {
            $ext = 'video';
        } elseif ($type == 'mp3') {
            $ext = 'audio';
        } elseif ($type == 'pdf') {
            $ext = 'pdf';
        } elseif ($type == 'doc' || $type == 'docx') {
            $ext = 'word';
        } elseif ($type == 'ppt' || $type == 'pptx') {
            $ext = 'powerpoint';
        } elseif ($type == 'xls' || $type == 'xlsx') {
            $ext = 'excel';
        } else {
            $ext = 'alt';
        }

        return $ext;
    }
}
