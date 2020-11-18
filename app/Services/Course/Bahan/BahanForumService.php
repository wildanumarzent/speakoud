<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanForum;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanForumTopikDiskusi;
use App\Models\Course\Bahan\BahanForumTopikStar;
use Illuminate\Support\Str;

class BahanForumService
{
    private $model, $modelTopik, $modelDiskusi, $modelStar;

    public function __construct(
        BahanForum $model,
        BahanForumTopik $modelTopik,
        BahanForumTopikDiskusi $modelDiskusi,
        BahanForumTopikStar $modelStar
    )
    {
        $this->model = $model;
        $this->modelTopik = $modelTopik;
        $this->modelDiskusi = $modelDiskusi;
        $this->modelStar = $modelStar;
    }

    public function findForum(int $id)
    {
        return $this->model->findOrFail($id);
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

    //topik
    public function getTopikList($forumId)
    {
        $query = $this->modelTopik->query();

        $query->where('forum_id', $forumId);

        $result = $query->orderBy('pin', 'DESC')->get();

        return $result;
    }

    public function findTopik(int $id)
    {
        return $this->modelTopik->findOrFail($id);
    }

    public function storeTopik($request, int $forumId)
    {
        $forum = $this->findForum($forumId);

        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('attachment')
                ->getClientOriginalName());
            $request->file('attachment')->move(public_path('userfile/attachment/forum/'.$forumId), $fileName);
        }

        $topik = new BahanForumTopik($request->only(['subject', 'message']));
        $topik->program_id = $forum->program_id;
        $topik->mata_id = $forum->mata_id;
        $topik->materi_id = $forum->materi_id;
        $topik->bahan_id = $forum->bahan_id;
        $topik->forum_id = $forumId;
        $topik->creator_id = auth()->user()->id;
        $topik->pin = (bool)$request->pin;
        $topik->attachment = !empty($request->attachment) ? $fileName : null;
        $topik->publish_start = (bool)$request->enable_start == 1 ? $request->publish_start : null;
        $topik->publish_end = (bool)$request->enable_end == 1 ? $request->publish_end : null;
        $topik->save();

        return $topik;
    }

    public function pinTopik(int $id)
    {
        $topik = $this->findTopik($id);
        $topik->pin = !$topik->pin;
        $topik->save();

        return $topik;
    }

    public function lockTopik(int $id)
    {
        $topik = $this->findTopik($id);
        $topik->lock = !$topik->lock;
        $topik->save();

        return $topik;
    }

    public function starTopik(int $forumId, int $id)
    {
        $check = $this->modelStar->where('forum_id', $forumId)->where('topik_id', $id)
            ->where('user_id', auth()->user()->id);

        if ($check->count() == 0) {

            $star = new BahanForumTopikStar;
            $star->forum_id = $forumId;
            $star->topik_id = $id;
            $star->user_id = auth()->user()->id;
            $star->save();

            return $star;

        } else {

            $star = $check->first();
            $star->delete();

            return $star;
        }

    }
}
