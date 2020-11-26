<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MataRequest;
use App\Services\Course\MataService;
use App\Services\Course\ProgramService;
use App\Services\KonfigurasiService;
use App\Services\Users\InstrukturService;
use Illuminate\Http\Request;

class MataController extends Controller
{
    private $service, $serviceProgram, $serviceInstruktur, $serviceKonfig;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        InstrukturService $serviceInstruktur,
        KonfigurasiService $serviceKonfig
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceInstruktur = $serviceInstruktur;
        $this->serviceKonfig = $serviceKonfig;
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
        $data['hasRole'] = auth()->user()->hasRole('developer|administrator|internal|mitra');

        $this->serviceProgram->checkInstruktur($programId);

        return view('backend.course_management.mata.index', compact('data'), [
            'title' => 'Course - Program Pelatihan',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => ''
            ],
        ]);
    }

    public function instruktur(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['instruktur'] = $this->service->getInstrukturList($request, $mataId);
        $data['number'] = $data['instruktur']->firstItem();
        $data['instruktur']->withPath(url()->current().$q);
        $data['mata'] = $this->service->findMata($mataId);

        return view('backend.course_management.mata.instruktur', compact('data'), [
            'title' => 'Program Pelatihan - Instruktur',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Instruktur' => '',
            ],
        ]);
    }

    public function courseList()
    {
        $limit = $this->serviceKonfig->getValue('content_limit');

        $data['mata'] = $this->service->getMata('urutan', 'ASC', $limit);

        return view('frontend.course.index', compact('data'), [
            'title' => 'Program Pelatihan',
            'breadcrumbsFrontend' => [
                'List Program' => '',
            ],
        ]);
    }

    public function courseRegister($id)
    {
        $data['mata'] = $this->service->findMata($id);

        return view('frontend.course.register', compact('data'), [
            'title' => 'Course - Register',
            'breadcrumbsFrontend' => [
                $data['mata']->program->judul => '',
                $data['mata']->judul => '',
                'Register' => '',
            ],
        ]);
    }

    public function courseDetail($id)
    {
        $data['read'] = $this->service->findMata($id);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['read']->program->publish == 0 || $data['read']->publish == 0) {
                return abort(404);
            }
        }

        $this->serviceProgram->checkInstruktur($data['read']->program_id);
        $this->serviceProgram->checkPeserta($data['read']->program_id);

        return view('frontend.course.detail', compact('data'), [
            'title' => $data['read']->judul,
            'breadcrumbsBackend' => [
                'Course' => route('course.list'),
                'Detail' => '',
            ],
        ]);
    }

    public function create($programId)
    {
        $data['program'] = $this->serviceProgram->findProgram($programId);
        $data['instruktur'] = $this->serviceInstruktur->getInstrukturForMata($data['program']->tipe);

        $this->serviceProgram->checkInstruktur($programId);

        return view('backend.course_management.mata.form', compact('data'), [
            'title' => 'Program Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $programId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(MataRequest $request, $programId)
    {
        $this->serviceProgram->checkInstruktur($programId);

        $this->service->storeMata($request, $programId);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Program pelatihan berhasil ditambahkan');
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

        $this->checkCreator($id);

        return view('backend.course_management.mata.form', compact('data'), [
            'title' => 'Program Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $programId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(MataRequest $request, $programId, $id)
    {
        $this->checkCreator($id);

        $this->service->updateMata($request, $id);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Program pelatihan berhasil diedit');
    }

    public function publish($programId, $id)
    {
        $this->checkCreator($id);

        $this->service->publishMata($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($programId, $id, $urutan)
    {
        $this->checkCreator($id);

        $this->service->positionMata($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($programId)
    {
        if (auth()->user()->hasRole('mitra')) {
            $mata = $this->service->findMata($id);
            $this->checkCreator($mata->creator_id);
        }

        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortMata($value, $i);
        }
    }

    public function giveRating(Request $request, $id)
    {
        $this->service->rating($request, $id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function destroy($programId, $id)
    {
        $mata = $this->service->findMata($id);
        $this->checkCreator($id);

        if ($mata->bahan()->count() > 0) {
            return response()->json([
                'success' => 0,
                'message' => 'Program pelatihan gagal dihapus dikarenakan'.
                            ' masih ada bahan pelatihan didalamnya'
            ], 200);
        } else {
            $this->service->deleteMata($id);

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    public function checkCreator($id)
    {
        $mata = $this->service->findMata($id);

        if (auth()->user()->hasRole('mitra')) {
            if ($mata->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }
    }
}
