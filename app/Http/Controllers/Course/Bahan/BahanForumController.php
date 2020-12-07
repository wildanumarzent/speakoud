<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumTopikDiskusiRequest;
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
        $data['forum'] = $this->service->findForum($forumId);
        $data['topik'] = $this->service->findTopik($id);

        $this->serviceProgram->checkInstruktur($data['topik']->program_id);
        $this->serviceProgram->checkPeserta($data['topik']->program_id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['forum']->program->publish == 0 || $data['forum']->bahan->publish == 0) {
                return abort(404);
            }
        }

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

    //topik
    public function createTopik($forumId)
    {
        $data['forum'] = $this->service->findForum($forumId);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['forum']->program->publish == 0 || $data['forum']->bahan->publish == 0) {
                return abort(404);
            }
            if ($data['forum']->tipe == 0) {
                return back()->with('warning', 'Peserta tidak diberi akses untuk membuat topik');
            }
            if ($data['forum']->tipe == 1 && !empty($data['forum']->limit_topik)) {
                if ($data['forum']->topikByUser()->count() >= $data['forum']->limit_topik) {
                    return back()->with('warning', 'Forum dilimit '.$data['forum']->limit_topik.' Topik');
                }
            }
        }

        return view('frontend.course.forum.form', compact('data'), [
            'title' => 'Forum - Topik - Tambah',
            'breadcrumbsBackend' => [
                'Course' => route('course.list'),
                'Detail' => route('course.detail', ['id' => $data['forum']->mata_id]),
                'Forum' => route('course.bahan', [
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

    public function editTopik($forumId, $id)
    {
        $data['forum'] = $this->service->findForum($forumId);
        $data['topik'] = $this->service->findTopik($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && $data['topik']->creator_id != auth()->user()->id) {
            return abort(404);
        }

        return view('frontend.course.forum.form', compact('data'), [
            'title' => 'Forum - Topik - Edit',
            'breadcrumbsBackend' => [
                'Course' => route('course.list'),
                'Detail' => route('course.detail', ['id' => $data['forum']->mata_id]),
                'Forum' => route('course.bahan', [
                    'id' => $data['forum']->mata_id,
                    'bahanId' => $data['forum']->bahan_id,
                    'tipe' => 'forum'
                    ]),
                'Edit Topik' => ''
            ],
        ]);
    }

    public function updateTopik(ForumTopikRequest $request, $forumId, $id)
    {
        $forum = $this->service->findForum($forumId);

        $this->service->updateTopik($request, $id);

        return redirect()->route('course.bahan', [
            'id' => $forum->mata_id,'bahanId' => $forum->bahan_id,'tipe' => 'forum'])
            ->with('success', 'Berhasil mengedit topik');
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

    public function destroyTopik($forumId, $id)
    {
        $this->service->deleteTopik($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    //reply
    public function createReply(Request $request, $forumId, $topikId)
    {
        $data['forum'] = $this->service->findForum($forumId);
        $data['topik'] = $this->service->findTopik($topikId);
        if ($request->parent != '0') {
            $data['diskusi'] = $this->service->findDiskusi($request->parent);
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['forum']->program->publish == 0 || $data['forum']->bahan->publish == 0) {
                return abort(404);
            }

            if (!empty($data['topik']->limit_reply) && $data['topik']->diskusiByUser()->count() >= $data['topik']->limit_reply) {
                return back()->with('warning', 'Topik dilimit '.$data['topik']->limit_reply.' Reply');
            }
        }

        return view('frontend.course.forum.form-reply', compact('data'), [
            'title' => 'Forum - Topik - Reply',
            'breadcrumbsBackend' => [
                'Forum' => route('course.bahan', [
                    'id' => $data['topik']->mata_id,
                    'bahanId' => $data['topik']->bahan_id,
                    'tipe' => 'forum'
                ]),
                'Topik' => route('forum.topik.room', ['id' => $forumId, 'topikId' => $topikId]),
                'Reply' => ''
            ],
        ]);
    }

    public function storeReply(ForumTopikDiskusiRequest $request, $forumId, $topikId)
    {
        $forum = $this->service->findForum($forumId);
        $topik = $this->service->findTopik($topikId);

        try {
            //code...
            $this->service->storeReply($request, $forumId, $topikId);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        return redirect()->route('forum.topik.room', ['id' => $forumId, 'topikId' => $topikId])
            ->with('success', 'Berhasil mereply topik');
    }

    public function editReply($forumId, $topikId, $id)
    {
        $data['forum'] = $this->service->findForum($forumId);
        $data['topik'] = $this->service->findTopik($topikId);
        $data['diskusi'] = $this->service->findDiskusi($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra') && $data['diskusi']->user_id != auth()->user()->id) {
            return abort(404);
        }

        return view('frontend.course.forum.form-reply', compact('data'), [
            'title' => 'Forum - Topik - Reply',
            'breadcrumbsBackend' => [
                'Forum' => route('course.bahan', [
                    'id' => $data['topik']->mata_id,
                    'bahanId' => $data['topik']->bahan_id,
                    'tipe' => 'forum'
                ]),
                'Topik' => route('forum.topik.room', ['id' => $forumId, 'topikId' => $topikId]),
                'Reply' => '',
                'Edit' => ''
            ],
        ]);
    }

    public function updateReply(ForumTopikDiskusiRequest $request, $forumId, $topikId, $id)
    {
        $forum = $this->service->findForum($forumId);
        $topik = $this->service->findTopik($topikId);

        $this->service->updateReply($request, $id);

        return redirect()->route('forum.topik.room', ['id' => $forumId, 'topikId' => $topikId])
            ->with('success', 'Berhasil mengedit reply topik');
    }

    public function destroyReply($forumId, $topikId, $id)
    {
        $this->service->deleteReply($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
