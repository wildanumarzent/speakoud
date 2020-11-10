<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MataRequest;
use App\Services\Course\MataService;
use App\Services\Course\ProgramService;
use App\Services\Users\InstrukturService;
use Illuminate\Http\Request;

class MataController extends Controller
{
    private $service, $serviceProgram, $serviceInstruktur;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        InstrukturService $serviceInstruktur
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceInstruktur = $serviceInstruktur;
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
        $data['check_role'] = auth()->user()->hasRole('developer|administrator|internal|mitra');

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
        $data['instruktur'] = $this->serviceInstruktur->getInstrukturForMata($data['program']->tipe);

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
        $data['instruktur'] = $this->serviceInstruktur->getInstrukturForMata($data['program']->tipe);

        $collectInstruktur = collect($data['mata']->instruktur);
        $data['instruktur_id'] = $collectInstruktur->map(function($item, $key) {
            return $item->instruktur_id;
        })->all();

        if (auth()->user()->hasRole('mitra')) {
            $this->checkCreatorMitra($data['mata']->creator_id);
        }

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
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreatorMitra($mata->creator_id);
        }

        $this->service->updateMata($request, $id);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Mata pelatihan berhasil diedit');
    }

    public function publish($programId, $id)
    {
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreatorMitra($mata->creator_id);
        }

        $this->service->publishMata($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($programId, $id, $urutan)
    {
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreatorMitra($mata->creator_id);
        }

        $this->service->positionMata($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($programId)
    {
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreatorMitra($mata->creator_id);
        }

        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortMata($value, $i);
        }
    }

    public function destroy($programId, $id)
    {
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreatorMitra($mata->creator_id);
        }

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

    public function checkCreatorMitra($creatorId)
    {
        if ($creatorId != auth()->user()->id) {
            return abort(404);
        }
    }
}
