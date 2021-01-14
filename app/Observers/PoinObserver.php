<?php

namespace App\Observers;

use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Kompetensi\KompetensiMata;
use App\Models\Kompetensi\KompetensiPeserta;
use Illuminate\Support\Facades\Auth;
class PoinObserver
{

    // model = activity
    public function saved($model){

        $activityCount = ActivityCompletion::where('user_id',auth()->user()->id)->where('mata_id',$model['mata_id'])->count();
        $bahanCount = BahanPelatihan::where('mata_id',$model['mata_id'])->count();
        $sum = $activityCount - $bahanCount;

        $kompetensiMata = KompetensiMata::query();
        $kompetensiMata->where('mata_id',$model['mata_id'])->get();
        foreach($kompetensiMata as $k){
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        $checkVal = KompetensiPeserta::where('kompetensi_id',$k->kompetensi_id)->where('peserta_id',Auth::user()->peserta->id)->first();

        if(!empty($checkVal)){
            $poin = $checkVal->increment('poin');
        }else{
            $poin = 1;
        }

        if($sum == 0){
        $kompetensiPeserta = new KompetensiPeserta;
        $kompetensiPeserta->updateOrCreate(
            ['peserta_id' => Auth::user()->peserta->id,
            'kompetensi_id' => $k->kompetensi_id,
            ],
            [
            'peserta_id' => Auth::user()->peserta->id,
            'kompetensi_id' => $k->kompetensi_id,
            'poin' => $poin,
            ]);
        }
    }
    }

    }
}
