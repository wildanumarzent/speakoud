<?php

namespace App\Services\Component;

use App\Models\Component\Notification;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
class NotificationService{

    public function __construct(Notification $notif)
    {
        $this->notif = $notif;
    }

    public function list(){
        $query = $this->notif->query();
        $result = $query->get();;
        return $result;
    }

    public function get($id){
        $query = $this->notif->findOrFail($id);
        return $query;
    }

    public function make($model,$title,$description,$special = null,$to = null){

        if(is_array($to)){
            $to = implode(';',$to);
        }

        $notif = new Notification;
        $model = $notif->notifable()->associate($model);
        $notif->updateOrCreate([ 'notifable_id' => $model['notifable_id'],
        'notifable_type' => $model['notifable_type']],[
            'title' => $title,
            'description' => $description,
            'to' => $to,
            'special' => $special,
            'notifable_id' => $model['notifable_id'],
            'notifable_type' => $model['notifable_type'],
        ]);

        return $notif;
    }

    public function update($id,$userID){

    }

    public function destroy($model){
        $notif = new Notification;
        $model = $notif->notifable()->associate($model);
        $query = $this->notif->where('notifable_id',$notif['notifable_id'])
                             ->where('notifable_type',$notif['notifable_type']);
        $query->delete();
    }
    public function wipe(){

    }
}
