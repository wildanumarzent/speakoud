<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoalRequest;
use App\Services\Soal\SoalKategoriService;
use App\Services\Soal\SoalService;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    private $service, $serviceKategori;

    public function __construct(
        SoalService $service,
        SoalKategoriService $serviceKategori
    )
    {
        $this->service = $service;
        $this->serviceKategori = $serviceKategori;
    }

    public function index(Request $request, $mataId, $kategoriId)
    {
        $t = '';
        $q = '';
        if (isset($request->t) || isset($request->q)) {
            $t = '?t='.$request->t;
            $q = '&q='.$request->q;
        }

        $data['soal'] = $this->service->getSoalList($request, $mataId, $kategoriId);
        $data['number'] = $data['soal']->firstItem();
        $data['soal']->withPath(url()->current().$t.$q);
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        return view('backend.bank_soal.index', compact('data'), [
            'title' => 'Bank Soal - Soal',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['kategori']->mata->program_id]),
                'Kategori' => route('soal.kategori', ['id' => $mataId]),
                'Soal' => '',
            ],
        ]);
    }

    public function create($mataId, $kategoriId)
    {
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        return view('backend.bank_soal.form', compact('data'), [
            'title' => 'Soal - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['kategori']->mata->program_id]),
                'Kategori' => route('soal.kategori', ['id' => $mataId]),
                'Soal' => route('soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalRequest $request, $mataId, $kategoriId)
    {
        $this->service->storeSoal($request, $mataId, $kategoriId);

        return redirect()->route('soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId])
            ->with('success', 'Soal berhasil ditambahkan');
    }

    public function edit($mataId, $kategoriId, $id)
    {
        $data['soal'] = $this->service->findSoal($id);
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        $this->checkCreator($data['soal']->creator_id);

        return view('backend.bank_soal.form-edit', compact('data'), [
            'title' => 'Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['kategori']->mata->program_id]),
                'Kategori' => route('soal.kategori', ['id' => $mataId]),
                'Soal' => route('soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalRequest $request, $mataId, $kategoriId, $id)
    {
        $this->service->updateSoal($request, $id);

        return redirect()->route('soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId])
            ->with('success', 'Soal berhasil diedit');
    }

    public function destroy($mataId, $kategoriId, $id)
    {
        $soal = $this->service->findSoal($id);
        $this->checkCreator($soal->creator_id);

        $this->service->deleteSoal($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function checkCreator($creatorId)
    {
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($creatorId != auth()->user()->id) {
                return abort(403);
            }
        }
    }
}
