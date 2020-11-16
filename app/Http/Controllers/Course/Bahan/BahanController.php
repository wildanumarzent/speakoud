<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\BahanRequest;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    private $service, $serviceMateri, $serviceMata;

    public function __construct(
        BahanService $service,
        MateriService $serviceMateri,
        MataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMateri = $serviceMateri;
        $this->serviceMata = $serviceMata;
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
        $this->service->updateBahan($request, $id);

        return redirect()->route('bahan.index', ['id' => $materiId])
            ->with('success', 'Bahan pelatihan berhasil diedit');
    }

    public function publish($materiId, $id)
    {
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
        $this->service->deleteBahan($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
