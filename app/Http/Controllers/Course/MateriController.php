<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MateriRequest;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\Users\InstrukturService;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    private $service, $serviceMata, $serviceProgram, $serviceInstruktur;

    public function __construct(
        MateriService $service,
        MataService $serviceMata,
        ProgramService $serviceProgram,
        InstrukturService $serviceInstruktur
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
        $this->serviceProgram = $serviceProgram;
        $this->serviceInstruktur = $serviceInstruktur;
    }

    public function index(Request $request, $mataId)
    {
        $i = '';
        $p = '';
        $q = '';
        if (isset($request->i) || isset($request->p) || isset($request->q)) {
            $i = '?i='.$request->i;
            $p = '&p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['materi'] = $this->service->getMateriList($request, $mataId);
        $data['number'] = $data['materi']->firstItem();
        $data['materi']->withPath(url()->current().$i.$p.$q);
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['instruktur'] = $this->serviceMata->getInstrukturList($request, $mataId);

        $this->serviceProgram->checkAdmin($data['mata']->program_id);

        return view('backend.course_management.materi.index', compact('data'), [
            'title' => 'Program - Materi Pelatihan',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Mata Pelatihan' => ''
            ],
        ]);
    }

    public function create(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        // $data['instruktur'] = $this->serviceInstruktur->getInstrukturByTypeProgram($data['mata']->program_id);
        $data['instruktur'] = $this->serviceMata->getInstrukturList($request, $mataId);

        $this->serviceProgram->checkAdmin($data['mata']->program_id);

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
        $this->service->storeMateri($request, $mataId);

        return redirect()->route('materi.index', ['id' => $mataId])
            ->with('success', 'Mata pelatihan berhasil ditambahkan');
    }

    public function edit(Request $request, $mataId, $id)
    {
        $data['materi'] = $this->service->findMateri($id);
        $data['mata'] = $this->serviceMata->findMata($mataId);
        // $data['instruktur'] = $this->serviceInstruktur->getInstrukturByTypeProgram($data['mata']->program_id);
        $data['instruktur'] = $this->serviceMata->getInstrukturList($request, $mataId);

        $this->serviceProgram->checkAdmin($data['mata']->program_id);
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

        $this->service->updateMateri($request, $id);

        return redirect()->route('materi.index', ['id' => $mataId])
            ->with('success', 'Mata pelatihan berhasil diedit');
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
        $materi = $this->service->findMateri($id);

        $delete = $this->service->deleteMateri($id);

        if ($delete == true) {
            
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {
            
            return response()->json([
                'success' => 0,
                'message' => 'Mata pelatihan gagal dihapus dikarenakan'.
                            ' masih memiliki materi pelatihan'
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
