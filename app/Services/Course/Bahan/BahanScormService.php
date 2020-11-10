<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanScorm;
use Illuminate\Support\Facades\Storage;

class BahanScormService
{
    private $model;

    public function __construct(BahanScorm $model)
    {
        $this->model = $model;
    }

    public function storeScorm($request, $materi, $bahan)
    {
        $scorm = new BahanScorm;
        $scorm->program_id = $materi->program_id;
        $scorm->mata_id = $materi->mata_id;
        $scorm->materi_id = $materi->id;
        $scorm->bahan_id = $bahan->id;
        $fileName = str_replace(' ', '-', $request->file('package')->getClientOriginalName());
        Storage::disk('bank_data')->makeDirectory('scorm/'.$scorm->materi_id);
        Storage::disk('bank_data')->putFileAs('bank_data/scorm/'.$scorm->materi_id,$request->file('package'),$fileName);
        $filePath = storage_path('bank_data/scorm/'.$scorm->materi_id,$request->file('package'),$fileName);
        // $zip = Zip::open($fileName);
        // $zip->extract($filePath);
        $scorm->package = 'bank_data/scorm/'.$scorm->materi_id.'/'.$fileName.'';
        $scorm->save();
        return $scorm;
    }

    public function updateScorm($request, $bahan)
    {
        $scorm = $bahan->scorm;
        $scorm->save();
        return $scorm;
    }
}
