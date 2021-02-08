<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\Users\PesertaController;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Kompetensi\KompetensiMata;
use App\Models\Kompetensi\KompetensiPeserta;
use App\Services\Component\NotificationService;
use App\Services\Course\MataService;
use App\Services\Users\PesertaService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;

class GivePoint
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notifikasi,PesertaService $peserta,MataService $mata)
    {
        $this->notifikasi = $notifikasi;
        $this->peserta = $peserta;
        $this->mata = $mata;
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
        $url = action([JourneyController::class, 'index']);

        $globalUid = Auth::user()->id;
        $uId = $event->activity['user_id'];
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $uId = Auth::user()->peserta->id;
            $urlPeserta = action([JourneyController::class, 'peserta'],['id' => $uId]);
            $this->notifikasi->make(
                $model = $event->activity,
                $title = 'Peserta Telah Menyelesaikan Seluruh Aktivitas',
                $description = 'Peserta '.$this->peserta->findPeserta($uId)->user->name.' Telah Menyelesaikan Seluruh Aktivitas Pada Pelatihan '.$this->mata->findMata($event->activity['mata_id'])->judul,
                $to = User::role(['internal','mitra','administrator'])->pluck('id'),
                $urlPeserta
            );
        }

        $done = ActivityCompletion::where('user_id',$globalUid)
        ->where('mata_id',$event->activity['mata_id'])
        ->where('status',1)
        ->where('user_id',Auth::user()->id)->count();

        $bahanCount = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->count();
        $sum = $bahanCount - $done;

        if(isset($uId)){
        $done = ActivityCompletion::where('mata_id',$event->activity['mata_id'])->where('status',1)
        ->where('user_id',$globalUid)->count();
        $total = BahanPelatihan::where('mata_id',$event->activity['mata_id'])->where('publish',1)->count();
        $hasil = $done - $total;
        if($hasil <= 0){
        $kMata = KompetensiMata::where('mata_id',$event->activity['mata_id'])->get();

        if($sum <= 0){
        foreach($kMata as $k){
            $checkVal = KompetensiPeserta::where('kompetensi_id',$k->kompetensi_id)
            ->where('peserta_id',$uId)->first();

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
                $poin = 1;
                $data[] = [
                    'kompetensi_id' => $k->kompetensi_id,
                    'peserta_id' => $uId,
                    'poin' => $poin,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $this->notifikasi->make(
                $model = $k,
                $title = 'Poin Kompetensi Didapatkan',
                $description = 'Anda Telah Mendapatkan '.$poin.' Poin pada Kompetensi : '.$k->kompetensi->judul,
                $to = auth()->user()->id,
                $url
                );

        }
        }
        if(isset($data)){
        KompetensiPeserta::insert($data);
        }

        }

    }

}
}
