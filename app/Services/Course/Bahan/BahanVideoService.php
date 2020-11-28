<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanVideo;
use App\Services\BankDataService;

class BahanVideoService
{
    private $model, $bankData;

    public function __construct(
        BahanVideo $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeVideo($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $video = new BahanVideo;
        $video->program_id = $materi->program_id;
        $video->mata_id = $materi->mata_id;
        $video->materi_id = $materi->id;
        $video->bahan_id = $bahan->id;
        $video->creator_id = auth()->user()->id;
        $video->bank_data_id = $bankData->id;
        $video->save();

        return $video;
    }

    public function updateVideo($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $video = $bahan->video;
        $video->bank_data_id = $bankData->id;
        $video->save();

        return $video;
    }
}
