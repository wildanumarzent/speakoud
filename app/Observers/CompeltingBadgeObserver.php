<?php

namespace App\Observers;

use App\Models\Badge\Badge;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanPelatihan;

class CompeltingBadgeObserver
{
    public function saved($model){
       $badge = Badge::where('mata_id',$model['mata_id'])->get();
       $jumlahBahan = BahanPelatihan::where('mata_id',$model['mata_id'])->count();
       $jumlahAktivitas = ActivityCompletion::where('mata_id',$mata['id'])->count();

       foreach($badge as $key => $b){
           if($jumlahBahan)
           $data = array(
               ''
           );
       }
    }
}
