<?php

namespace App\Services\Component;

use App\Models\Component\Announcement;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnnouncementService{

    public function annoList($request){

        $anno = Announcement::query();
        $anno->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('komentar', 'like', '%'.$q.'%');
            });
        });
        $result = $anno->paginate(20);
        return $result;
    }

    public function annoGet($data){
        $query = Announcement::query();
        $query->where('receiver','like','%,'.Auth::id().',%');
        $query->where('id',$data);


        $result = $query->first();
        return $result;
    }

    public function annoSave($data){
        $query = Announcement::create($data);
        return true;
    }

    public function annoUpdate($id,$data){
        $anno = $this->annoGet($id);
        $anno->update($data);
        return true;
    }

    public function annoDelete($id){
        $anno = $this->annoGet($id);
        $anno->delete();
        return true;
    }
}
