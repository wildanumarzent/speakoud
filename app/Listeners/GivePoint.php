<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Kompetensi\KompetensiMata;
use App\Models\Kompetensi\KompetensiPeserta;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class GivePoint
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
     * @param  CompleteBahan  $event
     * @return void
     */
    public function handle(ActivitySaved $event)
    {
        $data = [];
        $globalUid = Auth::user()->id;
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $uId = Auth::user()->peserta->id;
        }else{
            $uId = $event->activity['user_id'];
        }
        if(isset($uId)){
        $done = ActivityCompletion::where('mata_id',$event->activity['mata_id'])->where('status',1)
        ->where('user_id',$globalUid)->count();
        $total = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->where('publish',1)->count();
        $hasil = $done - $total;
        if($hasil <= 0){

        $kMata = KompetensiMata::where('mata_id',$event->activity['mata_id'])->get();
        foreach($kMata as $k){
            $checkVal = KompetensiPeserta::where('kompetensi_id',$k->kompetensi_id)->where('peserta_id',$uId)->first();
            if(!empty($checkVal)){
                $poin = $checkVal->increment('poin');
                $kPeserta = new KompetensiPeserta();
                $kPeserta->update([
                    'kompetensi_id' => $checkVal->kompetensi_id,
                    'peserta_id' => $checkVal->peserta->id,
                    'poin' => $poin,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }else{
                // $poin = 1;
                $data[] = [
                    'kompetensi_id' => $k->kompetensi_id,
                    'peserta_id' => $uId,
                    'poin' => $poin,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

        }
        if(isset($data)){
        KompetensiPeserta::insert($data);
        }
        }
    }

}
}
