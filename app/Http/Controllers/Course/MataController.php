<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\KodeEvaluasiInstrukturRequest;
use App\Http\Requests\KomentarRequest;
use App\Http\Requests\MataInstrukturRequest;
use App\Http\Requests\MataPesertaRequest;
use App\Http\Requests\MataRequest;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\KonfigurasiService;
use App\Services\Users\InstrukturService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MataController extends Controller
{
    private $service, $serviceProgram, $serviceMateri, $serviceInstruktur,
        $servicePeserta, $serviceKonfig, $serviceEvaluasi;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        MateriService $serviceMateri,
        InstrukturService $serviceInstruktur,
        PesertaService $servicePeserta,
        KonfigurasiService $serviceKonfig,
        EvaluasiService $serviceEvaluasi
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceMateri = $serviceMateri;
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

        $this->serviceProgram->checkAdmin($programId);

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

        $this->serviceProgram->checkAdmin($data['mata']->program->id);

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

        $this->serviceProgram->checkAdmin($data['mata']->program->id);

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

    public function courseDetail($id)
    {
        $data['read'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriByMata($id);

        //rating
        $data['numberRating'] = [1, 2, 3, 4, 5];
        $data['numberProgress'] = [1, 2, 3, 4, 5];
        rsort($data['numberProgress']);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['read']->program->publish == 0 || $data['read']->publish == 0) {
                return abort(404);
            }

            if (now() < $data['read']->publish_start) {
                return abort(404);
            }
        }

        $this->serviceProgram->checkAdmin($data['read']->program_id);
        $this->serviceProgram->checkPeserta($data['read']->program_id);
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
            if ($this->service->checkUserEnroll($id) == 0) {
                return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            }
        }

        if (!empty($data['read']->kode_evaluasi)) {
            $preview = $this->serviceEvaluasi->preview($data['read']->kode_evaluasi);
            $data['checkKode'] = $preview->success;
            if ($preview->success == true) {
                $data['preview'] = $preview->data->evaluasi;
                if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
                    $data['apiUser'] = $this->serviceEvaluasi->checkUserPenyelenggara($id)->first();
                }
            }
        }

        return view('frontend.course.detail', compact('data'), [
            'title' => $data['read']->judul,
            'breadcrumbsBackend' => [
                'Course' => route('course.list'),
                'Detail' => '',
            ],
        ]);
    }

    public function history(Request $request)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['mata'] = $this->service->getMataHistory($request);
        $data['number'] = $data['mata']->firstItem();
        $data['mata']->withPath(url()->current().$p.$q);

        return view('backend.course_management.mata.history', compact('data'), [
            'title' => 'Histori - Program Pelatihan',
            'breadcrumbsBackend' => [
                'Histori' => route('mata.history'),
                'Program Pelatihan' => ''
            ],
        ]);
    }

    public function create($programId)
    {
        $data['program'] = $this->serviceProgram->findProgram($programId);

        $this->serviceProgram->checkAdmin($programId);

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
        if (!empty($request->kode_evaluasi)) {
            $cekApi = $this->serviceEvaluasi->preview($request->kode_evaluasi);
            if ($cekApi->success == false) {
                return back()->with('warning', $cekApi->error_message[0]);
            }
        }

        $bobot = ($request->join_vidconf + $request->activity_completion +
            $request->forum_diskusi + $request->webinar + $request->progress_test +
            $request->quiz + $request->post_test);

        if ($bobot < 100 || $bobot > 100) {
            return back()->with('warning', 'Bobot nilai harus memiliki jumlah keseluruhan 100%, tidak boleh kurang / lebih');
        }

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

    public function kodeEvaluasiInstruktur(KodeEvaluasiInstrukturRequest $request, $mataId, $id)
    {
        if (!empty($request->kode_evaluasi)) {
            $cekApi = $this->serviceEvaluasi->preview($request->kode_evaluasi);
            if ($cekApi->success == false) {
                return back()->with('warning', $cekApi->error_message[0]);
            }
        }

        $this->service->kodeEvaluasiInstruktur($request, $mataId, $id);

        return redirect()->route('mata.instruktur', ['id' => $mataId])
            ->with('success', 'kode evaluasi berhasil dimasukan');
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

        if (!empty($request->kode_evaluasi)) {
            $cekApi = $this->serviceEvaluasi->preview($request->kode_evaluasi);
            if ($cekApi->success == false) {
                return back()->with('warning', $cekApi->error_message[0]);
            }
        }

        $bobot = ($request->join_vidconf + $request->activity_completion +
            $request->forum_diskusi + $request->webinar + $request->progress_test +
            $request->quiz + $request->post_test);

        if ($bobot < 100 || $bobot > 100) {
            return back()->with('warning', 'Bobot nilai harus memiliki jumlah keseluruhan 100%, tidak boleh kurang / lebih');
        }

        $this->service->updateMata($request, $id);

        return redirect()->route('mata.index', ['id' => $programId])
            ->with('success', 'Program pelatihan berhasil diedit');
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

        $delete = $this->service->deleteMata($id);

        if ($delete == false) {

            return response()->json([
                'success' => 0,
                'message' => 'Program pelatihan gagal dihapus dikarenakan'.
                            ' masih memiliki mata pelatihan & data yang bersangkutan'
            ], 200);
        } else {

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
                            ' masih memiliki materi pelatihan'
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
                            ' sudah memiliki aktifitas di pelatihan ini'
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
