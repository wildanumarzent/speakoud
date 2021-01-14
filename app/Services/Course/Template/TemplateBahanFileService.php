<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanFile;

use App\Services\BankDataService;

class TemplateBahanFileService
{
    private $model, $bankData;

    public function __construct(
        TemplateBahanFile $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeTemplateFile($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $file = new TemplateBahanFile;
        $file->template_mata_id = $materi->template_mata_id;
        $file->template_materi_id = $materi->id;
        $file->template_bahan_id = $bahan->id;
        $file->creator_id = auth()->user()->id;
        $file->bank_data_id = $bankData->id;
        $file->save();

        return $file;
    }

    public function updateTemplateFile($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $file = $bahan->dokumen;
        $file->bank_data_id = $bankData->id;
        $file->save();

        return $file;
    }
}
