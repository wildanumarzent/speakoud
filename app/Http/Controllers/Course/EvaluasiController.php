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

    public function form(Request $request, $mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['preview'] = $this->service->previewSoal($mataId);
        $apiUser = $this->service->checkUser($mataId)->first();

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

    public function submit(Request $request, $mataId)
    {
        $this->service->submitAnswer($request, $mataId);

        return back()->with('success', 'Terima kasih');
    }
}
