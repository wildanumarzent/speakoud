<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanAudio;
use App\Services\BankDataService;

class TemplateBahanAudioService
{
    private $model, $bankData;

    public function __construct(
        TemplateBahanAudio $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeTemplateAudio($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $audio = new TemplateBahanAudio;
        $audio->template_mata_id = $materi->template_mata_id;
        $audio->template_materi_id = $materi->id;
        $audio->template_bahan_id = $bahan->id;
        $audio->creator_id = auth()->user()->id;
        $audio->bank_data_id = $bankData->id;
        $audio->save();

        return $audio;
    }

    public function updateTemplateAudio($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $audio = $bahan->audio;
        $audio->bank_data_id = $bankData->id;
        $audio->save();

        return $audio;
    }
}
