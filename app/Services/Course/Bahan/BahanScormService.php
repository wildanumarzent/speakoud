<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanScorm;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BahanScormService
{
    private $model;

    public function __construct(BahanScorm $model)
    {
        $this->model = $model;
    }

    public function get($id){
       $query = $this->model->query();
       $query->find($id);
       $result = $query->first();
       return $result;
    }

    public function storeScorm($request, $materi, $bahan)
    {
        if ($request->hasFile('package')) {

            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('package')
                ->getClientOriginalName());
            $request->file('package')->move(public_path('userfile/scorm/'.$materi->id), $fileName);

            $scorm = new BahanScorm;
            $scorm->program_id = $materi->program_id;
            $scorm->mata_id = $materi->mata_id;
            $scorm->materi_id = $materi->id;
            $scorm->bahan_id = $bahan->id;
            $scorm->creator_id = auth()->user()->id;
            $scorm->package = $fileName;
            $scorm->save();

            return $scorm;
        } else {
            return false;
        }
    }

    public function updateScorm($request, $bahan)
    {
        $scorm = $bahan->scorm;
        if ($request->hasFile('package')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('package')
                ->getClientOriginalName());

            $path = public_path('userfile/scorm/'.$scorm->materi_id.'/'.$request->old_package) ;
            File::delete($path);

            $request->file('package')->move(public_path('userfile/scorm/'.$scorm->materi_id), $fileName);

            $scorm->package = $fileName;
            $scorm->save();

            return $scorm;
        } else {
            return false;
        }
    }
}
