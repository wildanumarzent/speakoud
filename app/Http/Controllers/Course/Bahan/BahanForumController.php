<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumTopikRequest;
use App\Services\Course\Bahan\BahanForumService;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class BahanForumController extends Controller
{
    private $service, $serviceProgram;

    public function __construct(
        BahanForumService $service,
        ProgramService $serviceProgram
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
    }

    public function room($forumId, $id)
    {
        $data['topik'] = $this->service->findTopik($id);

        $this->serviceProgram->checkInstruktur($data['topik']->program_id);
        $this->serviceProgram->checkPeserta($data['topik']->program_id);

        return view('frontend.course.forum.room', compact('data'), [
            'title' => 'Forum - Topik - Room',
            'breadcrumbsBackend' => [
                'Forum' => route('course.bahan', [
                    'id' => $data['topik']->mata_id,
                    'bahanId' => $data['topik']->bahan_id,
                    'tipe' => 'forum'
                ]),
                'Topik' => ''
            ],
        ]);
    }

    public function createTopik($forumId)
    {
        $data['forum'] = $this->service->findForum($forumId);

        return view('frontend.course.forum.form', compact('data'), [
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

    public function starTopik($forumId, $id)
    {
        $this->service->starTopik($forumId, $id);

        return redirect()->back();
    }
}
