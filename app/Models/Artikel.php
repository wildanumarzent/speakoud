<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Traits\Blameable;
use App\Models\Component\TagsTipe;
class Artikel extends Model
{
    use Blameable; // auto created_by & updated_by
    protected $table = 'artikel';
    protected $guarded = [];

    protected $casts = [
        'cover' => 'array',
        'meta_data' => 'array',
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCover($value)
    {
        if (!empty($value)) {
            $photo = asset(config('addon.images.path.cover').$value);
        } else {
            $photo = asset(config('addon.images.cover_article'));
        }

        return $photo;
    }

    public function tags()
    {
        return $this->morphMany(TagsTipe::class, 'tagable');
    }

    public function scopePublish($query)
    {
        return $query->where('publish', 1);
    }
}
