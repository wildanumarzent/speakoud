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

    public function index(Request $request, $kategoriId)
    {
        $t = '';
        $q = '';
        if (isset($request->t) || isset($request->q)) {
            $t = '?t='.$request->t;
            $q = '&q='.$request->q;
        }

        $data['soal'] = $this->service->getSoalList($request, $kategoriId);
        $data['number'] = $data['soal']->firstItem();
        $data['soal']->withPath(url()->current().$t.$q);
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        return view('backend.bank_soal.index', compact('data'), [
            'title' => 'Bank Soal - Soal',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => route('soal.kategori'),
                'Soal' => '',
            ],
        ]);
    }

    public function create($kategoriId)
    {
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        return view('backend.bank_soal.form', compact('data'), [
            'title' => 'Soal - Tambah',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => route('soal.kategori'),
                'Soal' => route('soal.index', ['id' => $kategoriId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalRequest $request, $kategoriId)
    {
        $this->service->storeSoal($request, $kategoriId);

        return redirect()->route('soal.index', ['id' => $kategoriId])->with('success', 'Soal berhasil ditambahkan');
    }

    public function edit($kategoriId, $id)
    {
        $data['soal'] = $this->service->findSoal($id);
        $data['kategori'] = $this->serviceKategori->findKategoriSoal($kategoriId);

        return view('backend.bank_soal.form-edit', compact('data'), [
            'title' => 'Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => route('soal.kategori'),
                'Soal' => route('soal.index', ['id' => $kategoriId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalRequest $request, $kategoriId, $id)
    {
        $this->service->updateSoal($request, $id);

        return redirect()->route('soal.index', ['id' => $kategoriId])->with('success', 'Soal berhasil diedit');
    }

    public function destroy($kategoriId, $id)
    {
        $this->service->deleteSoal($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
