<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    private $service, $serviceMata, $serviceBahan;

    public function __construct(
        EvaluasiService $service,
        MataService $serviceMata,
        BahanService $serviceBahan
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
        $this->serviceBahan = $serviceBahan;
    }

    public function penyelenggara(int $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['preview'] = $this->service->preview($data['mata']->kode_evaluasi)->data->evaluasi;

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $data['apiUser'] = $this->service->checkUserPenyelenggara($mataId)->first();
        }

        return view('frontend.course.evaluasi.penyelenggara', compact('data'), [
            'title' => 'Course - Evalusi',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => '',
            ],
        ]);
    }

    public function formPenyelenggara(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['preview'] = $this->service->preview($data['mata']->kode_evaluasi)->data->evaluasi;
        $apiUser = $this->service->checkUserPenyelenggara($mataId)->first();

        if (empty($apiUser)) {
            $register = $this->service->register($mataId, $data['mata']->kode_evaluasi);

            if ($register->success == true) {
                return redirect()->route('evaluasi.penyelenggara.form', ['id' => $data['mata']->id]);
            } else {
                return back()->with('info', 'Anda sudah melaksanakan evaluasi ini');
            }
        }

        if (now() < $data['preview']->waktu_mulai) {
            return back()->with('warning', 'evaluasi tidak bisa dibuka dikarenakan belum memasuki waktu yang ditentukan');
        }

        if (now() > $data['preview']->waktu_selesai) {
            return back()->with('warning', 'evaluasi tidak bisa dibuka dikarenakan sudah melebihi waktu yang ditentukan');
        }

        if ($apiUser->is_complete == 1) {
            return back()->with('info', 'anda sudah menyelesaikan evaluasi ini');
        }

        if (empty($apiUser->start_time)) {
            $this->service->recordUserPenyelenggara($mataId);

            return redirect()->route('evaluasi.penyelenggara.form', ['id' => $mataId]);
        }

        if (!empty($apiUser->start_time) && !empty($data['preview']->lama_jawab)) {
            $start = $apiUser->start_time->addMinutes($data['preview']->lama_jawab);
            $now = now()->format('is');
            $kurang = $start->diffInSeconds(now());
            $menit = floor($kurang/60);
            $detik = $kurang-($menit*60);
            $data['countdown'] = $menit.':'.$detik;

            if (now() > $start) {
                return back()->with('info', 'Durasi telah habis');
            }
        }

        return view('frontend.course.evaluasi.form-penyelenggara', compact('data'), [
            'title' => 'Course - Evalusi',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => route('evaluasi.penyelenggara', ['id' => $mataId]),
                'Form' => ''
            ],
        ]);
    }

    public function formPengajar(Request $request, $mataId, $bahanId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['bahan'] = $this->serviceBahan->findBahan($bahanId);
        $data['preview'] = $this->service->preview($data['bahan']->evaluasiPengajar->mataInstruktur->kode_evaluasi)->data->evaluasi;
        $apiUser = $this->service->checkUserPengajar($mataId, $bahanId)->first();

        if (empty($apiUser)) {
            $register = $this->service->register($mataId, $data['bahan']->evaluasiPengajar->mataInstruktur->kode_evaluasi, $bahanId);

            if ($register->success == true) {
                return redirect()->route('evaluasi.pengajar.form', ['id' => $data['mata']->id, 'bahanId' => $data['bahan']->id]);
            } else {
                return back()->with('info', 'Anda sudah melaksanakan evaluasi ini');
            }
        }

        if (now() < $data['preview']->waktu_mulai) {
            return back()->with('warning', 'evaluasi tidak bisa dibuka dikarenakan belum memasuki waktu yang ditentukan');
        }

        if (now() > $data['preview']->waktu_selesai) {
            return back()->with('warning', 'evaluasi tidak bisa dibuka dikarenakan sudah melebihi waktu yang ditentukan');
        }

        if ($apiUser->is_complete == 1) {
            return back()->with('info', 'anda sudah menyelesaikan evaluasi ini');
        }

        if (empty($apiUser->start_time)) {
            $this->service->recordUserPengajar($mataId, $bahanId);

            return redirect()->route('evaluasi.pengajar.form', ['id' => $mataId, 'bahanId' => $bahanId]);
        }

        if (!empty($apiUser->start_time) && !empty($data['preview']->lama_jawab)) {
            $start = $apiUser->start_time->addMinutes($data['preview']->lama_jawab);
            $now = now()->format('is');
            $kurang = $start->diffInSeconds(now());
            $menit = floor($kurang/60);
            $detik = $kurang-($menit*60);
            $data['countdown'] = $menit.':'.$detik;

            if (now() > $start) {
                return back()->with('info', 'Durasi telah habis');
            }
        }

        return view('frontend.course.evaluasi.form-pengajar', compact('data'), [
            'title' => 'Course - Evalusi',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => route('course.bahan', ['id' => $mataId, 'bahanId' => $bahanId, 'tipe' => 'evaluasi-pengajar']),
                'Form' => ''
            ],
        ]);
    }

    public function rekapPenyelenggara(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['result'] = $this->service->result($data['mata']->kode_evaluasi);

        return view('frontend.course.evaluasi.rekap-penyelenggara', compact('data'), [
            'title' => 'Course - Evalusi - Rekap',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => '',
                'Rekap' => '',
            ],
        ]);
    }

    public function rekapPengajar(Request $request, $mataId, $bahanId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['bahan'] = $this->serviceBahan->findBahan($bahanId);
        $data['result'] = $this->service->result($data['bahan']->evaluasiPengajar->mataInstruktur->kode_evaluasi);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($data['bahan']->materi->instruktur_id != auth()->user()->instruktur->id) {
                return abort(403);
            }
        }

        return view('frontend.course.evaluasi.rekap-pengajar', compact('data'), [
            'title' => 'Course - Evalusi - Rekap',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => route('course.bahan', ['id' => $mataId, 'bahanId' => $bahanId, 'tipe' => 'evaluasi-pengajar']),
                'Rekap' => '',
            ],
        ]);
    }

    public function submitPenyelenggara(Request $request, $mataId)
    {
        $submit = $this->service->submitAnswerPenyelenggara($request, $mataId);

        if ($submit == true) {
            if ($request->get('submit') == 'yes') {
                return redirect()->route('evaluasi.penyelenggara', ['id' => $mataId])->with('success', 'Terima kasih telah mengisi evaluasi ini');
            } else {
                return response()->json([
                    'success' => 1,
                    'message' => ''
                ], 200);
            }
        } else {
            return redirect()->route('evaluasi.penyelenggara', ['id' => $mataId])->with('warning', 'Token tidak valid');
        }
    }

    public function submitPengajar(Request $request, $mataId, $bahanId)
    {
        $submit = $this->service->submitAnswerPengajar($request, $mataId, $bahanId);

        if ($submit == true) {
            if ($request->get('submit') == 'yes') {
                return redirect()->route('course.bahan', ['id' => $mataId, 'bahanId' => $bahanId, 'tipe' => 'evaluasi-pengajar'])->with('success', 'Terima kasih telah mengisi evaluasi ini');
            } else {
                return response()->json([
                    'success' => 1,
                    'message' => ''
                ], 200);
            }
        } else {
            return redirect()->route('course.bahan', ['id' => $mataId, 'bahanId' => $bahanId, 'tipe' => 'evaluasi-pengajar'])->with('warning', 'Token tidak valid');
        }
    }
}
