<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\BahanRequest;
use App\Services\Course\Bahan\BahanForumService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    private $service, $serviceMateri, $serviceMata, $serviceProgram, $serviceBahanForum;

    public function __construct(
        BahanService $service,
        MateriService $serviceMateri,
        MataService $serviceMata,
        ProgramService $serviceProgram,
        BahanForumService $serviceBahanForum
    )
    {
        $this->service = $service;
        $this->serviceMateri = $serviceMateri;
        $this->serviceMata = $serviceMata;
        $this->serviceProgram = $serviceProgram;
        $this->serviceBahanForum = $serviceBahanForum;
    }

    public function index(Request $request, $materiId)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['bahan'] = $this->service->getBahanList($request, $materiId);
        $data['number'] = $data['bahan']->firstItem();
        $data['bahan']->withPath(url()->current().$p.$q);
        $data['materi'] = $this->serviceMateri->findMateri($materiId);
        $data['check_role'] = auth()->user()->hasRole('instruktur_internal|instruktur_mitra');

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
            $data['materi']->mata->instruktur()->where('instruktur_id', auth()->user()->instruktur->id)
                ->count() == 0) {
            return abort(404);
        }

        return view('backend.course_management.bahan.index', compact('data'), [
            'title' => 'Materi - Bahan Pelatihan',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Bahan Pelatihan' => ''
            ],
        ]);
    }

    public function view($mataId, $id, $tipe)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['bahan'] = $this->service->findBahan($id);
        $data['materi'] = $this->serviceMateri->findMateri($data['bahan']->materi_id);
        $data['jump'] = $this->service->bahanJump($id);
        $data['prev'] = $this->service->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'prev');
        $data['next'] = $this->service->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'next');
        $data['path'] = asset($data['bahan']->scorm->package);
        if ($tipe == 'forum') {
            $data['topik'] = $this->serviceBahanForum->getTopikList($data['bahan']->forum->id);
        }

        $this->serviceProgram->checkInstruktur($data['mata']->program_id);
        $this->serviceProgram->checkPeserta($data['mata']->program_id);

        return view('frontend.course.bahan.'.$tipe, compact('data'), [
            'title' => 'Course - Bahan',
            'breadcrumbsBackend' => [
                'Program Pelatihan' => route('course.list'),
                'Course' => route('course.detail', ['id' => $mataId]),
                'Detail' => '',
                'Bahan Pelatihan' => '',
            ],
        ]);
    }

    public function create(Request $request, $materiId)
    {
        if ($request->type == null) {
            return abort(404);
        }

        $data['materi'] = $this->serviceMateri->findMateri($materiId);

        return view('backend.course_management.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Bahan Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['materi']->id]),
                'Tambah' => '',
            ],
        ]);
    }

    public function store(BahanRequest $request, $materiId)
    {
        $this->service->storeBahan($request, $materiId);

        return redirect()->route('bahan.index', ['id' => $materiId])
            ->with('success', 'Bahan pelatihan berhasil ditambahkan');
    }

    public function edit(Request $request, $materiId, $id)
    {
        if ($request->type == null) {
            return abort(404);
        }

        $data['bahan'] = $this->service->findBahan($id);
        $data['materi'] = $this->serviceMateri->findMateri($materiId);

        $this->checkCreator($data['bahan']->creator_id);

        return view('backend.course_management.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Bahan Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['materi']->id]),
                'Edit' => '',
            ],
        ]);
    }

    public function update(BahanRequest $request, $materiId, $id)
    {
        $bahan = $this->service->findBahan($id);
        $this->checkCreator($bahan->creator_id);

        $this->service->updateBahan($request, $id);

        return redirect()->route('bahan.index', ['id' => $materiId])
            ->with('success', 'Bahan pelatihan berhasil diedit');
    }

    public function publish($materiId, $id)
    {
        $bahan = $this->service->findBahan($id);
        $this->checkCreator($bahan->creator_id);

        $this->service->publishBahan($id);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    public function position($materiId, $id, $urutan)
    {
        $this->service->positionBahan($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($materiId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortBahan($value, $i);
        }
    }

    public function destroy($materiId, $id)
    {
        $bahan = $this->service->findBahan($id);
        $this->checkCreator($bahan->creator_id);

        $this->service->deleteBahan($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function checkCreator($creatorId)
    {
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($creatorId != auth()->user()->id) {
                return abort(404);
            }
        }
    }
}
