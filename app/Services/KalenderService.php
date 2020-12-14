
<?php

namespace App\Services\Component;

use App\Models\Event;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
class KalenderService{

    public function __construct(Notification $notif)
    {
        $this->notif = $notif;
    }


    public function makeEvent($title,
    $description,$start,$end,
    $startTime = '00:00:00',$endTime = '00:00:00',$link = '#'){
        $startDate = date('Y-m-d H:i:s', strtotime("$start $startTime"));
        $endDate = date('Y-m-d H:i:s', strtotime("$end $endTime"));
       $event =  Event::Create(
            [
                'title' => $title,
                'description' => $description,
                'start' => $startDate,
                'end' => $endDate,
                'link' => $link,
            ]
        );
        return $event;
    }
}


