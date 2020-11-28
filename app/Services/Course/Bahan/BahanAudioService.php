<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanAudio;
use App\Services\BankDataService;

class BahanAudioService
{
    private $model, $bankData;

    public function __construct(
        BahanAudio $model,
        BankDataService $bankData
    )
    {
        $this->model = $model;
        $this->bankData = $bankData;
    }

    public function storeAudio($request, $materi, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $audio = new BahanAudio;
        $audio->program_id = $materi->program_id;
        $audio->mata_id = $materi->mata_id;
        $audio->materi_id = $materi->id;
        $audio->bahan_id = $bahan->id;
        $audio->creator_id = auth()->user()->id;
        $audio->bank_data_id = $bankData->id;
        $audio->save();

        return $audio;
    }

    public function updateAudio($request, $bahan)
    {
        $bankData = $this->bankData->findFileByPath($request->file_path);

        $audio = $bahan->audio;
        $audio->bank_data_id = $bankData->id;
        $audio->save();

        return $audio;
    }
}
