<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\BahanRequest;
use App\Services\Course\Bahan\ActivityService;
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
        $serviceConference, $serviceEvaluasi, $serviceActivity;

    public function __construct(
        BahanService $service,
        MateriService $serviceMateri,
        MataService $serviceMata,
        ProgramService $serviceProgram,
        BahanForumService $serviceBahanForum,
        BahanConferenceService $serviceConference,
        BahanScormService $serviceScorm,
        EvaluasiService $serviceEvaluasi,
        ActivityService $serviceActivity
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
        $this->serviceActivity = $serviceActivity;
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
            //publish
            if ($data['bahan']->program->publish == 0 || $data['bahan']->mata->publish == 0 ||
                $data['bahan']->materi->publish == 0 || $data['bahan']->publish == 0) {
                return abort(404);
            }

            //enroll
            if ($this->serviceMata->checkUserEnroll($mataId) == 0) {
                return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            }

            //restrict
            if ($data['bahan']->restrict_access >= '0') {
                if ($data['bahan']->restrict_access == '0') {
                    $checkMateri = $this->serviceActivity->restrict($data['bahan']->requirement);
                    if ($checkMateri == 0) {
                        return back()->with('warning', 'Materi tidak bisa diakses sebelum anda menyelesaikan materi '.
                            $data['bahan']->restrictBahan($data['bahan']->requirement)->judul);
                    }
                }

                if ($data['bahan']->restrict_access == 1) {
                    if ($tipe == 'dokumen' || $tipe == 'scorm' || $tipe == 'audio' || $tipe == 'video') {
                        if (now() < $data['bahan']->publish_start) {
                            return back()->with('warning', 'Materi tidak bisa diakses karena belum memasuki tanggal yang sudah ditentukan');
                        }

                        if (now() > $data['bahan']->publish_end) {
                            return back()->with('warning', 'Materi tidak bisa diakses karena sudah melebihi tanggal yang sudah ditentukan');
                        }
                    }
                }
            }

            //record completion
            if (empty($data['bahan']->activityCompletionByUser) && $data['bahan']->completion_type > 0) {
                $this->serviceActivity->recordActivity($id);

                return redirect()->route('course.bahan', ['id' => $mataId, 'bahanId' => $id, 'tipe' => $data['bahan']->type($data['bahan'])['tipe']]);
            }

            //completion time
            if ($data['bahan']->completion_type == 3 && !empty($data['bahan']->completion_parameter) &&
                !empty($data['bahan']->activityCompletionByUser)) {

                $durasi = $data['bahan']->completion_parameter['timer'];
                $data['timer'] = $data['bahan']->activityCompletionByUser->track_start->addMinutes($durasi);
                $now = now()->format('is');
                $kurang = $data['timer']->diffInSeconds(now());
                $menit = floor($kurang/60);
                $detik = $kurang-($menit*60);
                $data['countdown'] = $menit.':'.$detik;
            }
        }

        //check user
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
        $data['bahan_list'] = $this->service->getBahan($materiId);

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
        $materi = $this->serviceMateri->findMateri($materiId);

        if ($request->type == 'quiz') {
            if ($request->kategori == 1) {
                $pre = $materi->quiz->where('kategori', 1)->count();
                if ($pre > 0) {
                    return back()->with('warning', 'Pre Test sudah ada, tidak bisa ditambahkan lagi');
                }
            }

            if ($request->kategori == 2) {
                $post = $materi->quiz->where('kategori', 2)->count();
                if ($post > 0) {
                    return back()->with('warning', 'Post Test sudah ada, tidak bisa ditambahkan lagi');
                }
            }
        }

        $this->service->storeBahan($request, $materiId);

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
        $data['bahan_list'] = $this->service->getBahan($materiId, $id);

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
        $delete = $this->service->deleteBahan($id);

        if ($delete == false) {

            return response()->json([
                'success' => 0,
                'message' => 'Materi pelatihan gagal dihapus dikarenakan'.
                            ' sudah memiliki aktifitas di pelatihan ini'
            ], 200);

        } else {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    //activity
    public function activityComplete(Request $request, $id)
    {
        $bahan = $this->service->findBahan($id);

        if ($bahan->type($bahan)['tipe'] == 'forum') {
            if (!empty($bahan->forum->limit_topik) && $bahan->forum->topikByUser->count() < $bahan->forum->limit_topik) {
                return back()->with('warning', 'Anda belum membuat '.$bahan->forum->limit_topik.' topik');
            }
        }

        if ($bahan->type($bahan)['tipe'] == 'conference') {
            if ($bahan->conference->status < 2) {
                return back()->with('warning', 'Anda harus mengikuti meeting sampai selesai');
            }

            if (empty($bahan->conference->trackByUser)) {
                return back()->with('warning', 'Anda tidak mengikuti meeting ini');
            }
        }

        if ($bahan->type($bahan)['tipe'] == 'quiz') {
            if (empty($bahan->quiz->trackUserIn)) {
                return back()->with('warning', 'Anda belum menyelesaikan quiz ini');
            }
        }

        if ($bahan->type($bahan)['tipe'] == 'tugas') {
            if (empty($bahan->tugas->responByUser)) {
                return back()->with('warning', 'Anda belum mengupload tugas');
            }

            if ($bahan->tugas->approval == 1 && $bahan->tugas->responByUser->approval == 0) {
                return back()->with('warning', 'Tugas anda belum di approve pengajar');
            }
        }

        $this->serviceActivity->complete($id);

        if ($request->is_ajax == 'yes') {
            return response()->json([
                'success' => 1,
                'message' => 'Activity Completed'
            ], 200);
        } else {
            return back()->with('success', 'Activity Completed');
        }
    }
}
