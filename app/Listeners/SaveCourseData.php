<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use MataExtra;

class SaveCourseData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActivitySaved  $event
     * @return void
     */
    public function handle(ActivitySaved $event)
    {
        $total = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->where('publish',1)->count();
        $done = ActivityCompletion::where('mata_id',$event->activity['mata_id'])->where('status',1)->where('user_id',auth()->user()->id)->count();
        $hasilPersen = ($done/$total)*100;
        $flight = MataExtra::updateOrCreate(
            ['mata_id' => $event->activity['mata_id'], 'user_id' => auth()->user()->id],
            ['persentase' => $hasilPersen]
        );
    }
}
