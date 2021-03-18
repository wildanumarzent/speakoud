<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreatorObserver
{
    public function creating(Model $model){
        $model->creator_id = Auth::user()->id;
    }
}
