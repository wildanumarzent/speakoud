<?php

namespace App\Services\Course\Template;

use App\Models\BankData;
use App\Models\Course\Template\Bahan\TemplateBahanTugas;
use App\Services\BankDataService;
use Illuminate\Support\Facades\Storage;

class TemplateBahanTugasService
{
    private $model, $bankData;

    public function __construct(
        TemplateBahanTugas $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeTemplateTugas($request, $materi, $bahan)
    {
        if ($request->hasFile('files')) {

            $tugas = new TemplateBahanTugas;
            $tugas->template_mata_id = $materi->template_mata_id;
            $tugas->template_materi_id = $materi->id;
            $tugas->template_bahan_id = $bahan->id;
            $tugas->creator_id = auth()->user()->id;

            foreach ($request->file('files') as $file) {

                $fileName = str_replace(' ', '-', $file->getClientOriginalName());
                $extesion = $file->getClientOriginalExtension();

                if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
                    $path = 'personal/'.auth()->user()->id.'/tugas/'.$materi->judul.'/'.$request->judul.'/';
                } else {
                    $path = 'global/tugas/'.$materi->judul.'/'.$request->judul.'/'.auth()->user()->name.'/';
                }

                $bankData = new BankData;
                $bankData->file_path = $path.$fileName;
                $bankData->file_type = $extesion;
                $bankData->file_size = $file->getSize();
                $bankData->owner_id = auth()->user()->id;
                $bankData->is_video = 0;
                $bankData->save();

                $bankDataId[] = $bankData->id;

                Storage::disk('bank_data')->put($path.$fileName, file_get_contents($file));
            }

            $tugas->bank_data_id = $bankDataId;
            $tugas->approval = (bool)$request->approval;
            $tugas->save();

        } else {
            return false;
        }
    }

    public function updateTemplateTugas($request, $bahan)
    {
        $tugas = $bahan->tugas;
        $tugas->approval = (bool)$request->approval;
        $tugas->save();

        return $tugas;
    }
}
