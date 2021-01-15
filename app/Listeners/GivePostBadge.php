<?php

namespace App\Listeners;

use App\Events\ForumSaved;
use App\Models\Badge\Badge;
use App\Models\Badge\BadgePeserta;
use App\Models\Course\Bahan\BahanForum;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanPelatihan;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class GivePostBadge
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
     * @param  ForumSaved  $event
     * @return void
     */
    public function handle(ForumSaved $event)
    {
       $pesertaId = Auth::user()->peserta->id;
       $jumlahPost = BahanForumTopik::where('mata_id',$event->forum['mata_id'])->where('creator_id',Auth::user()->id)->count();
       $badge = Badge::where('mata_id',$event->forum['mata_id'])->where('tipe_utama',0)->where('tipe','forum')->get();
       foreach($badge as $b){
        if($jumlahPost >= $b->nilai_minimal){
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
       if(!empty($data)){
        BadgePeserta::insert($data);
        }
    }
}
}
