<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Models\Badge\Badge;
use App\Models\Badge\BadgePeserta;
use App\Models\Course\Bahan\BahanPelatihan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Badge\BadgeService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\Bahan\BahanService;
use Illuminate\Support\Facades\Auth;
use App\Models\Course\Bahan\ActivityCompletion;
use Carbon\Carbon;
class GiveBadge
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BadgeService $badge,BahanService $bahan,MataService $mata,MateriService $materi)
    {
        $this->badge = $badge;
        $this->bahan = $bahan;
        $this->mata = $mata;
        $this->materi = $materi;
    }

    /**
     * Handle the event.
     *
     * @param  CompleteBahan  $event
     * @return void
     */

    //  1.Program Mencari Badge yang Terkait dengan Mata ID
    //  2.Program Menghitung Completion Status Untuk Mata dan Materi.
    //  3.Program Mencari Badge yang sudah bisa di dapatkan Peserta
    //  4.Program Memberi Badges yang bisa didapatkan Peserta

     public function searchLinkedBadge(CompleteBahan $bahan){
        $data = $this->badge->list($bahan->mata_id,1); // 1 adalah tipe untuk badge completion
        return $data;
     }

     public function countCompletonStatus(){
     }

    public function handle(ActivitySaved $event)
    {
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        $pesertaId = Auth::user()->peserta->id;
        $total = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->where('publish',1)->count();


        $badge = Badge::where('mata_id',$event->activity['mata_id'])->where('tipe_utama',1)->get();
        foreach($badge as $b){
                    if($b['tipe'] == 'program'){
                    $done = ActivityCompletion::where('mata_id',$event->activity['mata_id'])->where('status',1)->where('user_id',Auth::user()->id)->count();
                    $hasilPersen = ($done/$total)*100;
                    }

                    if($b['tipe'] == 'mata'){
                    $done = ActivityCompletion::where('materi_id',$event->activity['materi_id'])->where('status',1)->where('user_id',Auth::user()->id)->count();
                    $hasilPersen = ($done/$total)*100;
                    }

                    if($b['tipe'] == 'materi'){
                    $done = ActivityCompletion::where('bahan_id',$event->activity['bahan_id'])->where('status',1)->where('user_id',Auth::user()->id)->count();
                    $hasilPersen = ($done/$total)*100;
                    }



        if($hasilPersen >= $b->nilai_minimal){
            $checkBadge = BadgePeserta::where('badge_id',$b->id)->where('peserta_id',$pesertaId)->first();
            if(empty($checkBadge->badge_id)){
                $data[] = [
                    'badge_id' => $b->id,
                    'peserta_id' => $pesertaId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }
        }
        if(!empty($data)){
            BadgePeserta::insert($data);
            }
    }
    }
}

