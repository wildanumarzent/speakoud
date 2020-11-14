<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';
    protected $guarded = [];

    protected $casts = [
        'cover' => 'array',
        'meta_data' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function childs()
    {
        $query = $this->hasMany(Page::class, 'parent', 'id');

        if (!empty(request()->get('s'))) {
            $query->where('publish', request()->get('s'));
        }

        return $query->orderBy('urutan', 'ASC');
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
