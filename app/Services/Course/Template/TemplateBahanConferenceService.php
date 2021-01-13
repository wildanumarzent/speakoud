<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanConference;

class TemplateBahanConferenceService
{
    private $model;

    public function __construct(
        TemplateBahanConference $model
    )
    {
        $this->model = $model;
    }

    public function storeTemplateConference($request, $materi, $bahan)
    {
        $conference = new TemplateBahanConference;
        $conference->template_mata_id = $materi->template_mata_id;
        $conference->template_materi_id = $materi->id;
        $conference->template_bahan_id = $bahan->id;
        $conference->creator_id = auth()->user()->id;
        $conference->tipe = (bool)$request->tipe;
        $conference->save();

        return $conference;

    }

    public function updateTemplateConferece($request, $bahan)
    {
        $conference = $bahan->conference;
        $conference->tipe = (bool)$request->tipe;
        $conference->save();

        return $conference;
    }
}
