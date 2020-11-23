<?php

namespace App\Services\Component;

use App\Models\Component\Announcement;
use App\Model\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Component\NotificationService;
use Illuminate\Support\Str;
class AnnouncementService{

    public function __construct(NotificationService $notifikasi)
    {
        $this->notifikasi = $notifikasi;
    }

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

    public function annoStore($request){
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('attachment')
                ->getClientOriginalName());
            $request->file('attachment')->move(public_path('userfile/announcement/attachment'), $fileName);
            $filePath = 'userfile/announcement/attachment/'.$fileName;
        }

        $query = Announcement::create(
            [
                'title' => $request['title'],
                'content' => $request['content'],
                'sub_content' => $request['sub_content'],
                'status' => $request['status'],
                'attachment' => $filePath,
            ]
        );
        if($request['status'] == 1){
        $this->notifikasi->make($model = $query,
        $title = 'New Announcement - '.$query['title'],
        $description = $query->sub_content,
        $special = '',
        $to = '');
        }
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

        $anno->update([
            'title' => $request['title'],
            'content' => $request['content'],
            'sub_content' => $request['sub_content'],
            'status' => $request['status'],
            'attachment' => $filePath,

        ]);
        if($anno->status == 0){
            $this->notifikasi->destroy($anno);
            }else{
                $this->notifikasi->make($model = $anno,
                $title = 'New Announcement - '.$anno['title'],
                $description = $anno->sub_content,
                $special = '',
                $to = '');
                }
        return true;
    }

    public function annoDestroy($id){
        $anno = $this->annoGet($id);
        $this->notifikasi->destroy($anno);
        $this->deleteAttachment($anno->attachment);
        $anno->delete();
        return $anno;
    }

    public function publish($id){
        $anno = $this->annoGet($id);
        if($anno->status == 0){
            $this->notifikasi->make($model = $anno,
            $title = 'New Announcement - '.$anno['title'],
            $description = $anno->sub_content,
            $special = '',
            $to = '');
            }else{
                $this->notifikasi->destroy($anno);
            }
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
