<?php

namespace App\Listeners;

use App\Events\ReplySaved;
use App\Models\Badge\Badge;
use App\Models\Badge\BadgePeserta;
use App\Models\Course\Bahan\BahanForumTopikDiskusi;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
class GiveReplyBadge
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
     * @param  ReplySaved  $event
     * @return void
     */
    public function handle(ReplySaved $event)
    {
        $pesertaId = Auth::user()->peserta->id;
        $jumlahReply = BahanForumTopikDiskusi::where('mata_id',$event->reply['mata_id'])->where('user_id',Auth::user()->id)->count();
        $badge = Badge::where('mata_id',$event->reply['mata_id'])->where('tipe_utama',0)->where('tipe','topic')->get();
        foreach($badge as $b){
         if($jumlahReply >= $b->nilai_minimal){
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
