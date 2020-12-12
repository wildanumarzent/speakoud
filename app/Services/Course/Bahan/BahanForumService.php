<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanForum;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanForumTopikDiskusi;
use App\Models\Course\Bahan\BahanForumTopikStar;
use Illuminate\Support\Facades\File;
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
        if ($forum->tipe == 1) {
            $forum->limit_topik = $request->limit_topik ?? null;
        }
        $forum->save();

        return $forum;
    }

    public function updateForum($request, $bahan)
    {
        $forum = $bahan->forum;
        $forum->tipe = $request->tipe;
        if ($forum->tipe == 1) {
            $forum->limit_topik = $request->limit_topik ?? null;
        }
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

    public function findDiskusi(int $id)
    {
        return $this->modelDiskusi->findOrFail($id);
    }

    public function storeTopik($request, int $forumId)
    {
        $forum = $this->findForum($forumId);

        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', $request->file('attachment')
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
        $topik->limit_reply = $request->limit_reply ?? null;
        $topik->publish_start = (bool)$request->enable_start == 1 ? $request->publish_start : null;
        $topik->publish_end = (bool)$request->enable_end == 1 ? $request->publish_end : null;
        $topik->save();

        return $topik;
    }

    public function updateTopik($request, int $id)
    {
        $topik = $this->findTopik($id);

        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', $request->file('attachment')
                ->getClientOriginalName());

            $path = public_path('userfile/attachment/forum/'.$topik->forum_id.'/'.$request->old_attachment) ;
            File::delete($path);

            $request->file('attachment')->move(public_path('userfile/attachment/forum/'.$topik->forum_id), $fileName);
        }

        $topik->fill($request->only(['subject', 'message']));
        $topik->pin = (bool)$request->pin;
        $topik->attachment = !empty($request->attachment) ? $fileName : $topik->attachment;
        $topik->limit_reply = $request->limit_reply ?? null;
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

    public function deleteTopik(int $id)
    {
        $topik = $this->findTopik($id);

        if (!empty($topik->attachment)) {
            $path = public_path('userfile/attachment/forum/'.$topik->forum_id.'/'.$topik->attachment) ;
            File::delete($path);
        }

        $topik->diskusi()->delete();
        $topik->starUser()->delete();
        $topik->delete();

        return $topik;
    }

    //diskusi
    public function storeReply($request, int $forumId, int $topikId)
    {
        $topik = $this->findTopik($topikId);

        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', $request->file('attachment')
                ->getClientOriginalName());
            $request->file('attachment')->move(public_path('userfile/attachment/forum/'.$forumId.'/topik/'.$topikId), $fileName);
        }

        $reply = new BahanForumTopikDiskusi($request->only(['message']));
        $reply->program_id = $topik->program_id;
        $reply->mata_id = $topik->mata_id;
        $reply->materi_id = $topik->materi_id;
        $reply->bahan_id = $topik->bahan_id;
        $reply->forum_id = $forumId;
        $reply->forum_topik_id = $topikId;
        $reply->user_id = auth()->user()->id;
        $reply->parent = !empty($request->parent) ? $request->parent : 0;
        $reply->attachment = !empty($request->attachment) ? $fileName : null;
        $reply->save();

        return $reply;
    }

    public function updateReply($request, int $id)
    {
        $reply = $this->findDiskusi($id);

        if ($request->hasFile('attachment')) {
            $fileName = str_replace(' ', '-', $request->file('attachment')
                ->getClientOriginalName());

            $path = public_path('userfile/attachment/forum/'.$reply->forum_id.'/topik/'.$reply->topik_id.'/'.$request->old_attachment) ;
            File::delete($path);

            $request->file('attachment')->move(public_path('userfile/attachment/forum/'.$reply->forum_id.'/topik/'.$reply->topik_id), $fileName);
        }

        $reply->fill($request->only(['message']));
        $reply->attachment = !empty($request->attachment) ? $fileName : $reply->attachment;
        $reply->save();

        return $reply;
    }

    public function deleteReply(int $id)
    {
        $reply = $this->findDiskusi($id);

        if (!empty($reply->attachment)) {
            $path = public_path('userfile/attachment/forum/'.$reply->forum_id.'/topik/'.$reply->topik_id.'/'.$reply->attachment) ;
            File::delete($path);
        }

        $child = $this->modelDiskusi->where('parent', $id)->delete();
        $reply->delete();

        return $reply;
    }
}
