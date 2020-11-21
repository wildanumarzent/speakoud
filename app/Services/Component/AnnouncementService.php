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
        $query->where('id',$data);
        $result = $query->first();
        return $result;
    }

    public function annoSave($request){
        $query = Announcement::create($requset->only(['title','content','summary','attachment']));
        return true;
    }

    public function annoUpdate($request,$id){
        $anno = $this->annoGet($id);
        $anno->update($request->only(['title','content','summary','attachment']));
        return true;
    }

    public function annoDelete($id){
        $anno = $this->annoGet($id);
        $anno->delete();
        return true;
    }
}
