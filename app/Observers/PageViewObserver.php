<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PageViewObserver
{
    public function retrieved(Model $model){
        $model->viewier = Auth::user()->id;
    }
}
