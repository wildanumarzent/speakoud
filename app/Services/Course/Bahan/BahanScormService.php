<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanScorm;
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

            $file = $request->file('package');
            $replace = str_replace(' ', '-', $file->getClientOriginalName());
            $generate = Str::random(5).'-'.$replace;

            $scorm = new BahanScorm;
            $scorm->program_id = $materi->program_id;
            $scorm->mata_id = $materi->mata_id;
            $scorm->materi_id = $materi->id;
            $scorm->bahan_id = $bahan->id;
            $scorm->creator_id = auth()->user()->id;
            $scorm->package = 'scorm/'.$materi->id.'/'.$generate;
            $scorm->save();

            Storage::disk('bank_data')->put('scorm/'.$materi->id.'/'.$generate, file_get_contents($file));

            return $scorm;
        } else {
            return false;
        }
    }

    public function updateScorm($request, $bahan)
    {
        $scorm = $bahan->scorm;
        if ($request->hasFile('package')) {
            $file = $request->file('package');
            $replace = str_replace(' ', '-', $file->getClientOriginalName());
            $generate = Str::random(5).'-'.$replace;

            $scorm->package = 'scorm/'.$scorm->materi_id.'/'.$generate;

            Storage::disk('bank_data')->delete($request->old_package);
            Storage::disk('bank_data')->put('scorm/'.$scorm->materi_id.'/'.$generate, file_get_contents($file));
        }
        $scorm->save();
        return $scorm;
    }
}
