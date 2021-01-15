<?php

namespace App\Services;

use App\Models\Artikel;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Kompetensi\Kompetensi;
use App\Models\Kompetensi\KompetensiMata;
use App\Services\Component\NotificationService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Services\Component\TagsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use KompetensiPeserta;
use App\Models\Course\MataPelatihan;
class PoinService
{
    public function addPoin($model){

        $activityCount = ActivityCompletion::where('user_id',auth()->user()->id)->where('mata_id',$model['mata_id'])->count();
        $bahanCount = BahanPelatihan::where('mata_id',$model['mata_id'])->count();
        $sum = $activityCount - $bahanCount;

        $kompetensiMata = KompetensiMata::query();
        $kompetensiMata->where('mata_id',$model['mata_id'])->get();

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        $checkVal = KompetensiPeserta::where('kompetensi_id',$k->kompetensi_id)->where('peserta_id',Auth::user()->peserta->id)->first();

        if(!empty($checkVal)){
            $poin = $checkVal->increment('poin');
        }else{
            $poin = 1;
        }

        if($sum <=  0){
        $mata = Mata::find($model['mata_id']);
        $kompetensiPeserta = new KompetensiPeserta;
        $kompetensiPeserta->peserta_id = Auth::user()->peserta->id;
        $kompetensiPeserta->mata_id = $k->kompetensi_id;
        $kompetensiPeserta->poin = $poin;
        $kompetensiPeserta->save();
        unset($kompetensiPeserta);
        }
    }

    }
}
