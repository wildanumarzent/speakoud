<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanScorm;
use ZanySoft\Zip\Zip;

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
        $package = Zip::open($request->file('package'));
        $package->extract(public_path('userfile/scorm/'.$fileName));
        $scorm->package = 'userfile/scorm/'.$fileName.'/';
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
