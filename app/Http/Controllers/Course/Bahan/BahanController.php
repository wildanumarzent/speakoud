<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MateriService;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    private $service, $serviceMateri;

    public function __construct(
        BahanService $service,
        MateriService $serviceMateri
    )
    {
        $this->service = $service;
        $this->serviceMateri = $serviceMateri;
    }

    public function index(Request $request, $materiId)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        // $data['bahan'] = $this->service->getBahanList($request, $materiId);
        // $data['number'] = $data['bahan']->firstItem();
        // $data['bahan']->withPath(url()->current().$p.$q);
        $data['materi'] = $this->serviceMateri->findMateri($materiId);

        return view('backend.course_management.bahan.index', compact('data'), [
            'title' => 'Materi - Bahan Pelatihan',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['materi']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['materi']->mata_id]),
                'Bahan' => ''
            ],
        ]);
    }
}
