<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\BahanRequest;
use App\Services\Course\Bahan\BahanConferenceService;
use App\Services\Course\Bahan\BahanForumService;
use App\Services\Course\Bahan\BahanScormService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    private $service, $serviceMateri, $serviceMata, $serviceProgram, $serviceBahanForum,
        $serviceConference, $serviceEvaluasi;

    public function __construct(
        BahanService $service,
        MateriService $serviceMateri,
        MataService $serviceMata,
        ProgramService $serviceProgram,
        BahanForumService $serviceBahanForum,
        BahanConferenceService $serviceConference,
        BahanScormService $serviceScorm,
        EvaluasiService $serviceEvaluasi
    )
    {
        $this->service = $service;
        $this->serviceMateri = $serviceMateri;
        $this->serviceMata = $serviceMata;
        $this->serviceProgram = $serviceProgram;
        $this->serviceBahanForum = $serviceBahanForum;
        $this->serviceConference = $serviceConference;
        $this->serviceScorm = $serviceScorm;
        $this->serviceEvaluasi = $serviceEvaluasi;
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

        $this->service->checkInstruktur($materiId);
        $this->serviceProgram->checkAdmin($data['materi']->program_id);

        return view('backend.course_management.bahan.index', compact('data'), [
            'title' => 'Mata - Materi Pelatihan',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Mata' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Materi Pelatihan' => ''
            ],
        ]);
    }

    public function view($mataId, $id, $tipe)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['bahan'] = $this->service->findBahan($id);
        $data['materi'] = $this->serviceMateri->findMateri($data['bahan']->materi_id);
        $data['materi_lain'] = $this->serviceMateri->getMateriByMata($data['bahan']->mata_id);
        $data['jump'] = $this->service->bahanJump($id);
        $data['prev'] = $this->service->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'prev');
        $data['next'] = $this->service->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'next');

        //check data
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['bahan']->program->publish == 0 || $data['bahan']->mata->publish == 0 ||
                $data['bahan']->materi->publish == 0 || $data['bahan']->publish == 0) {
                return abort(404);
            }
            if (!empty($data['bahan']->publish_start) && !empty($data['bahan']->publish_end)) {
                if (now() < $data['bahan']->publish_start) {
                    return back()->with('warning', 'Materi dibuka tanggal '.$data['bahan']->publish_start->format('d F Y H:i'));
                }

                if (now() > $data['bahan']->publish_end) {
                    return back()->with('warning', 'Materi sudah ditutup tanggal '.$data['bahan']->publish_end->format('d F Y H:i'));
                }
            }
            if ($this->serviceMata->checkUserEnroll($mataId) == 0) {
                return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            }

            $this->service->recordActivity($id);
        }

        $this->serviceProgram->checkAdmin($data['mata']->program_id);
        $this->serviceProgram->checkPeserta($data['mata']->program_id);
        $this->service->checkInstruktur($data['bahan']->materi_id);

        if ($tipe == 'forum') {
            $data['topik'] = $this->serviceBahanForum->getTopikList($data['bahan']->forum->id);
        }

        if ($tipe == 'quiz') {

            if (!empty($data['bahan']->quiz->trackUserIn)) {
                $data['start_time'] = $data['bahan']->quiz->trackUserIn->start_time->format('l, j F Y H:i A');
                $startTime = $data['bahan']->quiz->trackUserIn->start_time;
                if (!empty($data['bahan']->quiz->trackUserIn->end_time)) {
                    $data['finish_time'] = $data['bahan']->quiz->trackUserIn->end_time->format('l, j F Y H:i A');
                    $finishTime = $data['bahan']->quiz->trackUserIn->end_time;
                    $totalDuration = $finishTime->diffInSeconds($startTime);
                    $menit = gmdate('i', $totalDuration);
                    $detik = gmdate('s', $totalDuration);
                    $data['total_duration'] = $menit.' Menit '.$detik.' Detik';
                }
            }
        }

        if ($tipe == 'scorm') {
            $data['checkpoint'] = $this->serviceScorm->checkpoint(auth()->user()->id,$data['bahan']->scorm->id);
            if(isset($data['checkpoint'])){
                $data['cpData'] = json_decode($data['checkpoint']->checkpoint,true);
            }
        }

        if ($tipe == 'evaluasi-pengajar') {
            $evaluasi = $data['bahan']->evaluasiPengajar->mataInstruktur;
            if (!empty($evaluasi->kode_evaluasi)) {
                $data['preview'] = $this->serviceEvaluasi->preview($evaluasi->kode_evaluasi)->data->evaluasi;
                if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
                    $data['apiUser'] = $this->serviceEvaluasi->checkUserPengajar($mataId, $id)->first();
                }
            } else {
                return abort(404);
            }
        }

        return view('frontend.course.bahan.'.$tipe, compact('data'), [
            'title' => 'Course - Bahan',
            'breadcrumbsBackend' => [
                'Course' => route('course.list'),
                'Detail' => route('course.detail', ['id' => $mataId]),
                'Preview' => '',
            ],
        ]);
    }

    public function create(Request $request, $materiId)
    {
        $data['scorm'] = $this->serviceScorm->getMaster();
        if ($request->type == null) {
            return abort(404);
        }

        $data['materi'] = $this->serviceMateri->findMateri($materiId);
        $data['instruktur'] = $this->serviceMata->getInstrukturEnroll($data['materi']->mata_id);

        $this->serviceProgram->checkAdmin($data['materi']->program_id);
        $this->service->checkInstruktur($materiId);

        return view('backend.course_management.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Materi Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Mata' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Materi' => route('bahan.index', ['id' => $data['materi']->id]),
                'Tambah' => '',
            ],
        ]);
    }

    public function store(BahanRequest $request, $materiId)
    {
        $data = $this->service->storeBahan($request, $materiId);
        if($data == false){
            return redirect()->back()->with('failed', 'This Package is not Scorm Compliant');
        }
        return redirect()->route('bahan.index', ['id' => $materiId])
            ->with('success', 'Materi pelatihan berhasil ditambahkan');
    }

    public function edit(Request $request, $materiId, $id)
    {
        if ($request->type == null) {
            return abort(404);
        }
        $data['scorm'] = $this->serviceScorm->getMaster();
        $data['bahan'] = $this->service->findBahan($id);
        $data['materi'] = $this->serviceMateri->findMateri($materiId);

        $this->service->checkInstruktur($materiId);

        return view('backend.course_management.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Materi Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Mata' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Materi' => route('bahan.index', ['id' => $data['materi']->id]),
                'Edit' => '',
            ],
        ]);
    }

    public function update(BahanRequest $request, $materiId, $id)
    {
        $this->service->updateBahan($request, $id);

        return redirect()->route('bahan.index', ['id' => $materiId])
            ->with('success', 'Materi pelatihan berhasil diedit');
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
