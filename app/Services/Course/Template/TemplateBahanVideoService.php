<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanVideo;
use App\Services\BankDataService;

class TemplateBahanVideoService
{
    private $model, $bankData;

    public function __construct(
        TemplateBahanVideo $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeTemplateVideo($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $video = new TemplateBahanVideo;
        $video->template_mata_id = $materi->template_mata_id;
        $video->template_materi_id = $materi->id;
        $video->template_bahan_id = $bahan->id;
        $video->creator_id = auth()->user()->id;
        $video->bank_data_id = !empty($bankData) ? $bankData->id : null;
        $video->save();

        return $video;
    }

    public function updateTemplateVideo($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $video = $bahan->video;
        $video->bank_data_id = !empty($bankData) ? $bankData->id : null;
        $video->save();

        return $video;
    }
}
