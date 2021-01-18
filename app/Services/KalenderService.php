<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KalenderService{

    public function makeEvent($title,
    $description,$start,$end,
    $startTime = '00:00:00',$endTime = '00:00:00',$link = null,
    $jadwalId = null){

        if($start == $end){
            $end = $end->addDays(1);
        }

        $startDate = date('Y-m-d H:i:s', strtotime("$start $startTime"));
        $endDate = date('Y-m-d H:i:s', strtotime("$end $endTime"));
       $event =  Event::Create(
            [
                'title' => $title,
                'description' => $description,
                'start' => $startDate,
                'end' => $endDate,
                'link' => $link,
                'className' => 'fc-event-danger',
                'jadwal_id' => $jadwalId,
                'allDay' => 1,
            ]
        );
        return $event;
    }

    public function drop($id){
        $query = Event::where('jadwal_id',$id);
        $query->delete();
        return true;
    }
}


