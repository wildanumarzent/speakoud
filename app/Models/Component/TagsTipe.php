<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Component\Tags;
class TagsTipe extends Model
{
    protected $table = 'tags_tipe';
    protected $guarded = [];
    public function tagable()
    {
        return $this->morphTo();
    }
    public function parent()
    {
        return $this->belongsTo(Tags::class,'tag_id');
    }
}
