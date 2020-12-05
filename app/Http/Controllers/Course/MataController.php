<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\KomentarRequest;
use App\Http\Requests\MataInstrukturRequest;
use App\Http\Requests\MataPesertaRequest;
use App\Http\Requests\MataRequest;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\ProgramService;
use App\Services\KonfigurasiService;
use App\Services\Users\InstrukturService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;

class MataController extends Controller
{
    private $service, $serviceProgram, $serviceInstruktur, $servicePeserta, $serviceKonfig,
        $serviceEvaluasi;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        InstrukturService $serviceInstruktur,
        PesertaService $servicePeserta,
        KonfigurasiService $serviceKonfig,
        EvaluasiService $serviceEvaluasi
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceInstruktur = $serviceInstruktur;
        $this->servicePeserta = $servicePeserta;
        $this->serviceKonfig = $serviceKonfig;
        $this->serviceEvaluasi = $serviceEvaluasi;
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

        $collectInstruktur = collect($data['mata']->instruktur);
        $data['instruktur_id'] = $collectInstruktur->map(function($item, $key) {
            return $item->instruktur_id;
        })->all();
        $data['instruktur_list'] = $this->serviceInstruktur
            ->getInstrukturForMata($data['mata']->program->tipe, $data['instruktur_id']);

        $this->serviceProgram->checkInstruktur($data['mata']->program->id);

        return view('backend.course_management.mata.instruktur.index', compact('data'), [
            'title' => 'Program Pelatihan - Instruktur',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Instruktur' => '',
            ],
        ]);
    }

    public function peserta(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request, $mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['mata'] = $this->service->findMata($mataId);

        $collectPeserta = collect($data['mata']->peserta);
        $data['peserta_id'] = $collectPeserta->map(function($item, $key) {
            return $item->peserta_id;
        })->all();
        $data['peserta_list'] = $this->servicePeserta
            ->getPesertaForMata($data['mata']->program->tipe, $data['peserta_id']);

        $this->serviceProgram->checkInstruktur($data['mata']->program->id);

        return view('backend.course_management.mata.peserta.index', compact('data'), [
            'title' => 'Program Pelatihan - Peserta',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Peserta' => '',
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
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
            if ($this->service->checkUser($id) == 0) {
                return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            }
        }

        if (!empty($data['read']->kode_evaluasi)) {
            $data['preview'] = $this->serviceEvaluasi->previewSoal($id);
        }

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

    public function storeInstruktur(MataInstrukturRequest $request, $mataId)
    {
        $this->service->storeInstruktur($request, $mataId);

        return redirect()->route('mata.instruktur', ['id' => $mataId])
            ->with('success', 'Instruktur pelatihan berhasil ditambahkan');
    }

    public function storePeserta(MataPesertaRequest $request, $mataId)
    {
        $this->service->storePeserta($request, $mataId);

        return redirect()->route('mata.peserta', ['id' => $mataId])
            ->with('success', 'Peserta pelatihan berhasil ditambahkan');
    }

    public function edit($programId, $id)
    {
        $data['mata'] = $this->service->findMata($id);
        $data['program'] = $this->serviceProgram->findProgram($programId);

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

    public function giveRating(Request $request, $id)
    {
        $this->service->rating($request, $id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function giveComment(KomentarRequest $request, $id)
    {
        $this->service->comment($request, $id);

        return back()->with('success', 'Berhasil memberi komentar');
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

    public function destroyInstruktur($mataId, $id)
    {
        $delete = $this->service->deleteInstruktur($mataId, $id);

        if ($delete == false) {
            return response()->json([
                'success' => 0,
                'message' => 'Instruktur pelatihan gagal dihapus dikarenakan'.
                            ' masih memiliki bahan pelatihan'
            ], 200);
        } else {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    public function destroyPeserta($mataId, $id)
    {
        $delete = $this->service->deletePeserta($mataId, $id);

        if ($delete == false) {
            return response()->json([
                'success' => 0,
                'message' => 'Peserta pelatihan gagal dihapus dikarenakan'.
                            ' masih memiliki bahan pelatihan'
            ], 200);
        } else {

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
