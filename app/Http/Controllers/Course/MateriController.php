<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MateriRequest;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        MateriService $service,
        MataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function index(Request $request, $mataId)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['materi'] = $this->service->getMateriList($request, $mataId);
        $data['number'] = $data['materi']->firstItem();
        $data['materi']->withPath(url()->current().$p.$q);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.course_management.materi.index', compact('data'), [
            'title' => 'Mata - Materi Pelatihan',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Materi Pelatihan' => ''
            ],
        ]);
    }

    public function create($mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.course_management.materi.form', compact('data'), [
            'title' => 'Materi Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Materi Pelatihan' => route('materi.index', ['id' => $data['mata']->id]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(MateriRequest $request, $mataId)
    {
        $mata = $this->serviceMata->findMata($mataId);

        $this->service->storeMateri($request, $mataId);

        return redirect()->route('materi.index', ['id' => $mata->id])
            ->with('success', 'Materi pelatihan berhasil ditambahkan');
    }

    public function edit($mataId, $id)
    {
        $data['materi'] = $this->service->findMateri($id);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.course_management.materi.form', compact('data'), [
            'title' => 'Materi Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Materi Pelatihan' => route('materi.index', ['id' => $data['mata']->id]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(MateriRequest $request, $mataId, $id)
    {
        $this->service->updateMateri($request, $id);

        return redirect()->route('materi.index', ['id' => $mataId])
            ->with('success', 'Materi pelatihan berhasil diedit');
    }

    public function publish($mataId, $id)
    {
        $this->service->publishMateri($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($mataId, $id, $urutan)
    {
        $this->service->positionMateri($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($mataId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortMateri($value, $i);
        }
    }

    public function destroy($mataId, $id)
    {
        $this->service->deleteMateri($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
