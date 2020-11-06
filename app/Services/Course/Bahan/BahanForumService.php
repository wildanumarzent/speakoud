<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanForum;

class BahanForumService
{
    private $model;

    public function __construct(BahanForum $model)
    {
        $this->model = $model;
    }

    public function storeForum($request, $materi, $bahan)
    {
        $forum = new BahanForum;
        $forum->program_id = $materi->program_id;
        $forum->mata_id = $materi->mata_id;
        $forum->materi_id = $materi->id;
        $forum->bahan_id = $bahan->id;
        $forum->creator_id = auth()->user()->id;
        $forum->tipe = $request->tipe;
        $forum->save();

        return $forum;
    }

    public function updateForum($request, $bahan)
    {
        $forum = $bahan->forum;
        $forum->tipe = $request->tipe;
        $forum->save();

        return $forum;
    }
}
