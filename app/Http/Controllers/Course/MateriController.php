<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MateriRequest;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    private $service, $serviceMata, $serviceProgram;

    public function __construct(
        MateriService $service,
        MataService $serviceMata,
        ProgramService $serviceProgram
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
        $this->serviceProgram = $serviceProgram;
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
        $data['hasRole'] = auth()->user()->hasRole('developer|administrator|internal|mitra');

        $this->serviceProgram->checkInstruktur($data['mata']->program_id);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra') &&
            $data['mata']->instruktur()->where('instruktur_id', auth()->user()->instruktur->id)
                ->count() == 0) {
            return abort(404);
        }

        return view('backend.course_management.materi.index', compact('data'), [
            'title' => 'Program - Materi Pelatihan',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Mata Pelatihan' => ''
            ],
        ]);
    }

    public function create($mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $this->serviceProgram->checkInstruktur($data['mata']->program_id);

        return view('backend.course_management.materi.form', compact('data'), [
            'title' => 'Mata Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Mata Pelatihan' => route('materi.index', ['id' => $data['mata']->id]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(MateriRequest $request, $mataId)
    {
        $mata = $this->serviceMata->findMata($mataId);

        $this->service->storeMateri($request, $mataId);

        return redirect()->route('materi.index', ['id' => $mata->id])
            ->with('success', 'Mata pelatihan berhasil ditambahkan');
    }

    public function edit($mataId, $id)
    {
        $data['materi'] = $this->service->findMateri($id);
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $this->serviceProgram->checkInstruktur($data['mata']->program_id);

        $this->checkCreator($id);

        return view('backend.course_management.materi.form', compact('data'), [
            'title' => 'Mata Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Mata Pelatihan' => route('materi.index', ['id' => $data['mata']->id]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(MateriRequest $request, $mataId, $id)
    {
        $this->checkCreator($id);

        $this->service->updateMateri($request, $id);

        return redirect()->route('materi.index', ['id' => $mataId])
            ->with('success', 'Mata pelatihan berhasil diedit');
    }

    public function publish($mataId, $id)
    {
        $this->checkCreator($id);

        $this->service->publishMateri($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($mataId, $id, $urutan)
    {
        $this->checkCreator($id);

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
        $materi = $this->service->findMateri($id);
        $this->checkCreator($id);

        if ($materi->bahan()->count() > 0) {
            return response()->json([
                'success' => 0,
                'message' => 'Mata pelatihan gagal dihapus dikarenakan'.
                            ' masih ada bahan pelatihan didalamnya'
            ], 200);
        } else {
            $this->service->deleteMateri($id);

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    public function checkCreator($id)
    {
        $materi = $this->service->findMateri($id);

        if (auth()->user()->hasRole('mitra')) {
            if ($materi->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }
    }
}
