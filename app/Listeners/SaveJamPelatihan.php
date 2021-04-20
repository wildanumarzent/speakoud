<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Course\MataPelatihan;
use App\Models\RecordTahunan;
use Carbon\Carbon;

class SaveJamPelatihan
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
        $done = ActivityCompletion::where('mata_id',$event->activity['mata_id'])->where('status',1)
        ->where('user_id',auth()->user()->id)->count();
        $total = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->where('publish',1)->count();
        $hasil = $total - $done;
        if($hasil <= 0){
            $tahun = Carbon::now()->year;
            $jamP = MataPelatihan::where('id',$event->activity['mata_id'])->first();
            $totalJam = $jamP->jam_pelatihan;
            $saved = RecordTahunan::where('user_id',auth()->user()->id)->where('tahun',$tahun)->first();
            if(isset($saved)){
                $totalJam = $jamP->jam_pelatihan + $saved->total_jam_pelatihan;
            }
            $RecordTahunan = RecordTahunan::updateOrCreate(
                ['user_id' => auth()->user()->id, 'tahun' => $tahun],
                ['total_jam_pelatihan' => $totalJam,'tahun' => $tahun]
            );
        }
    }
}
