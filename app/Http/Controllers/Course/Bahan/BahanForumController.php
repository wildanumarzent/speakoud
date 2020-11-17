<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumTopikRequest;
use App\Services\Course\Bahan\BahanForumService;
use Illuminate\Http\Request;

class BahanForumController extends Controller
{
    private $service;

    public function __construct(BahanForumService $service)
    {
        $this->service = $service;
    }

    public function createTopik($forumId)
    {
        $data['forum'] = $this->service->findForum($forumId);

        return view('frontend.course.bahan.form-forum', compact('data'), [
            'title' => 'Forum - Topik - Tambah',
            'breadcrumbsBackend' => [
                'Program Pelatihan' => route('course.list'),
                'Course' => route('course.detail', ['id' => $data['forum']->mata_id]),
                'Detail' => '',
                'Bahan Pelatihan' => route('course.bahan', [
                    'id' => $data['forum']->mata_id,
                    'bahanId' => $data['forum']->bahan_id,
                    'tipe' => 'forum'
                    ]),
                'Tambah Topik' => ''
            ],
        ]);
    }

    public function storeTopik(ForumTopikRequest $request, $forumId)
    {
        $forum = $this->service->findForum($forumId);

        $this->service->storeTopik($request, $forumId);

        return redirect()->route('course.bahan', [
            'id' => $forum->mata_id,'bahanId' => $forum->bahan_id,'tipe' => 'forum'])
            ->with('success', 'Berhasil menambahkan topik');
    }

    public function pinTopik($forumId, $id)
    {
        $this->service->pinTopik($id);

        return redirect()->back()->with('success', 'Pin berhasil diubah');
    }

    public function lockTopik($forumId, $id)
    {
        $this->service->lockTopik($id);

        return redirect()->back()->with('success', 'Lock berhasil diubah');
    }
}
