<?php

namespace App\Services\Component;

use App\Models\Component\Announcement;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Component\NotificationService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class AnnouncementService{

    public function __construct(NotificationService $notifikasi)
    {
        $this->notifikasi = $notifikasi;
    }

    public function annoList($request,$sortExpired = false){

        $anno = Announcement::query();
        $anno->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title', 'like', '%'.$q.'%');
            });
        });
        if($sortExpired == true){
        $anno->whereDate('end_date','>',Carbon::now());
        }
        $result = $anno->orderby('created_at','desc')->paginate(20);
        return $result;
    }

    public function annoDashboard(){
        $anno = Announcement::query();
        $result = $anno->limit(3)->where('status',1)->orderby('created_at','desc')->get();
        return $result;
    }

    public function annoGet($data,$withRole = false){
        $query = Announcement::query();
        $query->where('id',$data);
        $result = $query->first();
        if($withRole == true){
        if (auth()->user()->hasRole($result['receiver'])){

        }else{
            return false;
        }

    }
    return $result;
    }

    public function annoStore($request){
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('attachment')
                ->getClientOriginalName());
            $request->file('attachment')->move(public_path('userfile/announcement/attachment'), $fileName);
            $filePath = 'userfile/announcement/attachment/'.$fileName;
        }
        if($request['receiver'] == 'all'){
            $data = Role::get()->pluck('name')->toArray();
        }else{
            $data = $request['receiver'];
        }

        $receiver = implode('|',$data);
        $query = Announcement::create(
            [
                'title' => $request['title'],
                'content' => $request['content'],
                'sub_content' => $request['sub_content'],
                'status' => $request['status'],
                'attachment' => $filePath,
                'receiver' => $receiver,
                'end_date' => $request['end_date'],
            ]
        );
        // if($request['status'] == 1){
        // $this->notifikasi->make($model = $query,
        // $title = 'New Announcement - '.$query['title'],
        // $description = $query->sub_content,

        // $to = '');
        // }
        return true;
    }

    public function annoUpdate($request,$id){
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('attachment')
                ->getClientOriginalName());
            $this->deleteAttachment($request->old_attachment);
            $request->file('attachment')->move(public_path('userfile/announcement/attachment'), $fileName);
            $request['attachment'] = $fileName;
            $filePath = 'userfile/announcement/attachment/'.$fileName;
        }

        $anno = $this->annoGet($id);
        $receiver = implode('|',$request['receiver']);
        $anno->update([
            'title' => $request['title'],
            'content' => $request['content'],
            'sub_content' => $request['sub_content'],
            'status' => $request['status'],
            'attachment' => $filePath,
            'receiver' => $receiver,
            'end_date' => $request['end_date'],

        ]);
        // if($anno->status == 0){
        //     // $this->notifikasi->destroy($anno);
        //     }else{
        //         $this->notifikasi->make(
        //         $model = $anno,
        //         $title = 'New Announcement - '.$anno['title'],
        //         $description = $anno->sub_content,
        //         $to = '');
        //         }
        return true;
    }

    public function annoDestroy($id){
        $anno = $this->annoGet($id);
        // $this->notifikasi->destroy($anno);
        $this->deleteAttachment($anno->attachment);
        $anno->delete();
        return $anno;
    }

    public function publish($id){
        $anno = $this->annoGet($id);
        // if($anno->status == 0){
        //     // $this->notifikasi->make($model = $anno,
        //     // $title = 'New Announcement - '.$anno['title'],
        //     // $description = $anno->sub_content,

        //     // $to = '');
        //     }else{
        //         $this->notifikasi->destroy($anno);
        //     }
        $anno->status = !$anno->status;
        $anno->save();
    }


    public function deleteAttachment($fileName)
    {
        $path = public_path('userfile/announcement/attachment/'.$fileName) ;
        File::delete($path);
        return $path;
    }
}
