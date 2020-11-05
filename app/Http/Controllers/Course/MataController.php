<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MataRequest;
use App\Services\Course\MataService;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class MataController extends Controller
{
    private $service, $serviceProgram;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
    }

    public function index(Request $request, $programId)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['mata'] = $this->service->getMataList($request, $programId);
        $data['number'] = $data['mata']->firstItem();
        $data['mata']->withPath(url()->current().$p.$q);
        $data['program'] = $this->serviceProgram->findProgram($programId);

        $this->checkTypeRole($data['program']);

        return view('backend.course_management.mata.index', compact('data'), [
            'title' => 'Program - Mata Pelatihan',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata Pelatihan' => ''
            ],
        ]);
    }

    public function create($programId)
    {
        $data['program'] = $this->serviceProgram->findProgram($programId);
        $this->checkTypeRole($data['program']);

        return view('backend.course_management.mata.form', compact('data'), [
            'title' => 'Mata Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata Pelatihan' => route('mata.index', ['id' => $programId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(MataRequest $request, $programId)
    {
        $program = $this->serviceProgram->findProgram($programId);
        $this->checkTypeRole($program);

        $this->service->storeMata($request, $programId);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Mata pelatihan berhasil ditambahkan');
    }

    public function edit($programId, $id)
    {
        $data['mata'] = $this->service->findMata($id);
        $data['program'] = $this->serviceProgram->findProgram($programId);

        return view('backend.course_management.mata.form', compact('data'), [
            'title' => 'Mata Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata Pelatihan' => route('mata.index', ['id' => $programId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(MataRequest $request, $programId, $id)
    {
        $this->service->updateMata($request, $id);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Mata pelatihan berhasil diedit');
    }

    public function publish($programId, $id)
    {
        $this->service->publishMata($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($programId, $id, $urutan)
    {
        $this->service->positionMata($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($programId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortMata($value, $i);
        }
    }

    public function destroy($programId, $id)
    {
        $this->service->deleteMata($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function checkTypeRole($tipe)
    {
        if (auth()->user()->hasRole('mitra|instruktur_mitra')) {
            if ($tipe->tipe == 0) {
                return abort(404);
            }

            if (auth()->user()->hasRole('mitra') && $tipe->mitra_id
                != auth()->user()->mitra->id || auth()->user()->hasRole('instruktur_mitra')
                && $tipe->mitra_id != auth()->user()->instruktur->mitra_id) {
                return abort(404);
            }
        }
    }
}
