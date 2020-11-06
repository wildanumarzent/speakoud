<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanFile;
use App\Services\BankDataService;

class BahanFileService
{
    private $model, $bankData;

    public function __construct(
        BahanFile $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeFile($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $file = new BahanFile;
        $file->program_id = $materi->program_id;
        $file->mata_id = $materi->mata_id;
        $file->materi_id = $materi->id;
        $file->bahan_id = $bahan->id;
        $file->creator_id = auth()->user()->id;
        $file->bank_data_id = $bankData->id;
        $file->save();

        return $file;
    }

    public function updateFile($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $file = $bahan->dokumen;
        $file->bank_data_id = $bankData->id;
        $file->save();

        return $file;
    }
}
