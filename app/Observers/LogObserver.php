<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
class LogObserver
{
    public function saved($model){
        $log = new Log;
        $data = $log->logable()->associate($model);
        if ($model->wasRecentlyCreated == true) {
            $event = 'created';
        } else {
            $event = 'updated';
        }
        if (Auth::check()) {
        Log::create([
            'creator' => Auth::user()->name,
            'creator_id' => Auth::user()->id,
            'event' => $event,
            'logable_id' => $data['logable_id'],
            'logable_type' => $data['logable_type'],
            'logable_name' => $model->getTable(),
            'ip_address' => request()->ip(),
        ]);
        }
    }
    public function deleting($model){
        $log = new Log;
        $data = $log->logable()->associate($model);
        if (Auth::check()) {
            Log::create([
                'creator' => Auth::user()->name,
                'creator_id' => Auth::user()->id,
                'event' => 'deleted',
                'logable_id' => $data['logable_id'],
                'logable_type' => $data['logable_type'],
                'logable_name' => $model->getTable(),
                'ip_address' => request()->ip(),
            ]);
            }
    }
}
