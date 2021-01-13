<?php

namespace App\Models\Course\Template;

use Illuminate\Database\Eloquent\Model;

class TemplateMataBobot extends Model
{
    protected $table = 'template_mata_bobot';
    protected $guarded = [];

    public function mata()
    {
        return $this->belongsTo(TemplateMata::class, 'template_mata_id');
    }
}
