<?php

namespace App\Services\Badge;
use App\Models\Badge\Badge;
use Illuminate\Support\Facades\File;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\Bahan\BahanForumService;
use App\Models\Badge\BadgePeserta;
class BadgeService
{
    private $model;

    public function __construct(Badge $model,BahanForumService $forum,BadgePeserta $badgePeserta)
    {
        $this->model = $model;
       $this->forum = $forum;
       $this->badgeP = $badgePeserta;
    }





    public function list($mataID = null,$mainType = null){
        $query = $this->model->query();
        if($mataID != null){
            $query->where('mata_id',$mataID);
        }
        if($mainType != null){
            $query->where('tipe_utama',$mainType);
        }
        $result = $query->get();
        return $result;
    }
    public function listMyBadge($pesertaId){
        $query = $this->badgeP->query();
        $query->where('peserta_id',$pesertaId);
        $result = $query->get();
        return $result;
    }
    public function countBadge($pesertaID){
        $data = $this->badgeP->query();
        $data->where('peserta_id',$pesertaID);
        $result = $data->count();
        return $result;
    }
    public function getBadgePeserta($pesertaID){
        $data = $this->badgeP->query();
        $data->where('peserta_id',$pesertaID);
        $result = $data->get();
        return $result;
    }

    public function get($id){
        $query = $this->model->query();
        $query->where('id',$id);
        $result = $query->first();
        return $result;
     }

    public function store($request){
        $data = $request;
        if(empty($data['tipe_id'])){
            $data['tipe_id'] = $data['mata_id'];
        }
        $filePath = 'userfile/badge/';
        $fileName = time().'.'.$data['icon']->extension();
        $data['icon']->move(public_path($filePath), $fileName);
        $data['icon'] = $filePath.$fileName;
        Badge::create($data);
        return true;
    }

    public function update($id,$request){
       if(isset($request['icon'])){
        if(isset($request['old_icon'])){
        $this->deleteFile($request['old_icon']);
        }
       $filePath = 'userfile/badge/';
       $fileName = time().'.'.$request['icon']->extension();
       $request['icon']->move(public_path($filePath), $fileName);
       }
       $data = $request->except(['old_icon','action']);
       if(isset($data['icon'])){
        $data['icon'] = $filePath.$fileName;
       }
       $query = $this->get($id);
        $query->update($data);
        return $query;
    }
    public function delete($id){
        $query = $this->get($id);
        $query->delete();
        return true;
    }

    public function unlink($id,$tipe){
        $query = new Badge;
        $query->where('tipe_id',$id);
        $query->where('tipe',$tipe);
        $query->get();
        $query->delete();
        return true;
    }

    public function deleteFile($path){
        if(File::exists(public_path($path))){

            File::delete(public_path($path));

          }
    }
}
