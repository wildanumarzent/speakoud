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

    public function list($userId){
        $query = $this->notif->query();
        $query->whereJsonContains('receiver',$userId);
        $query->whereJsonDoesntContain('read_by',$userId);
        $query->orderBy('created_at','desc');
        $result = $query->take(10)->get();
        return $result;
    }

    public function unread($userId){
        $list = $this->list($userId)->pluck('id');
        $query = $this->notif->query();
        $query->whereIn('id',$list);
        $query->whereJsonContains('receiver',$userId);
        $query->whereJsonDoesntContain('read_by',$userId);
        $result = $query->get();
        return $result;
    }

    public function get($id){
        $query = $this->notif->findOrFail($id);
        return $query;
    }

    public function make($model,$title,
    $description = 'Intro Not Found,lorem ipsum dolor sit amet',
    $to = null,
    $url = null
    ){

       $to = json_encode($to);
       $notif = new Notification;
       $readby = [0];
        $model = $notif->notifable()->associate($model);
        $notif->create(
        [
            'title' => $title,
            'description' => $description,
            'receiver' => $to,
            'read_by' => json_encode($readby),
            'notifable_id' => $model['notifable_id'],
            'notifable_type' => $model['notifable_type'],
            'url' => $url
        ]);

        return $notif;
    }

    public function update($userID,$id){

        $notifikasi = $this->get($id);
        $readby = [];
        if(!empty($notifikasi->read_by)){
        $readby = json_decode($notifikasi->read_by);
        }
        if(!in_array($userID,$readby)){
            array_push($readby,$userID);
        }
        // $save = implode(";",$readby);
        $notifikasi->update(['read_by' => $readby]);
        $this->deleteIfAllRead($id);
    }
    public function deleteIfAllRead($id){
        $notif = $this->get($id);
        $read = json_decode($notif->read_by);
        $sent = json_decode($notif->receiver);
        if($read > $sent){
            $notif->delete();
        }
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
