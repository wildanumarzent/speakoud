<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        EvaluasiService $service,
        MataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function formPenyelenggara(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['preview'] = $this->service->previewSoal($mataId);
        $apiUser = $this->service->checkUser($mataId)->first();

        if ($data['mata']->apiEvaluasiByUser()->count() == 0) {
            return back()->with('info', 'anda belum terdaftar di evaluasi ini');
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
            $this->service->recordUser($mataId);

            return redirect()->route('evaluasi.form', ['id' => $mataId]);
        }

        if (!empty($apiUser->start_time)) {
            $start = $apiUser->start_time->addMinutes($data['preview']->lama_jawab);
            $now = now()->format('is');
            $kurang = $start->diffInSeconds(now());
            $menit = floor($kurang/60);
            $detik = $kurang-($menit*60);
            $data['countdown'] = $menit.':'.$detik;
        }

        return view('frontend.course.evaluasi.form', compact('data'), [
            'title' => 'Course - Evalusi',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => '',
            ],
        ]);
    }

    public function rekapPenyelenggara(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['result'] = $this->service->resultSubmit($mataId);

        return view('frontend.course.evaluasi.rekap', compact('data'), [
            'title' => 'Course - Evalusi - Rekap',
            'breadcrumbsBackend' => [
                'Course' => route('course.detail', ['id' => $mataId]),
                'Evaluasi' => '',
                'Rekap' => '',
            ],
        ]);
    }

    public function submitPenyelenggara(Request $request, $mataId)
    {
        $submit = $this->service->submitAnswer($request, $mataId);

        if ($submit == true) {
            if ($request->submit == 'yes') {
                return back()->with('success', 'Terima kasih');
            } else {
                return response()->json([
                    'success' => 1,
                    'message' => ''
                ], 200);
            }
        } else {
            return redirect()->route('course.detail', ['id' => $mataId])->with('warning', 'Token tidak valid');
        }
    }
}
