<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahanForum;

class TemplateBahanForumService
{
    private $model;

    public function __construct(
        TemplateBahanForum $model
    )
    {
        $this->model = $model;
    }

    public function findTemplateForum(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateForum($request, $materi, $bahan)
    {
        $forum = new TemplateBahanForum;
        $forum->template_mata_id = $materi->template_mata_id;
        $forum->template_materi_id = $materi->id;
        $forum->template_bahan_id = $bahan->id;
        $forum->creator_id = auth()->user()->id;
        $forum->tipe = $request->tipe;
        $forum->limit_topik = ($forum->tipe == 1) ? $request->limit_topik : null;
        $forum->save();

        return $forum;
    }

    public function updateTemplateForum($request, $bahan)
    {
        $forum = $bahan->forum;
        $forum->tipe = $request->tipe;
        $forum->limit_topik = ($forum->tipe == 1) ? $request->limit_topik : null;
        $forum->save();

        return $forum;
    }
}
