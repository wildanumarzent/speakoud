<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoalKategoriRequest;
use App\Services\Soal\SoalKategoriService;
use Illuminate\Http\Request;

class SoalKategoriController extends Controller
{
    private $service;

    public function __construct(SoalKategoriService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['kategori'] = $this->service->getSoalKategoriList($request);
        $data['number'] = $data['kategori']->firstItem();
        $data['kategori']->withPath(url()->current().$q);

        return view('backend.bank_soal.kategori.index', compact('data'), [
            'title' => 'Bank Soal - Kategori',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => '',
            ],
        ]);
    }

    public function create()
    {
        return view('backend.bank_soal.kategori.form', [
            'title' => 'Kategori Soal - Tambah',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => route('soal.kategori'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalKategoriRequest $request)
    {
        $this->service->storeKategoriSoal($request);

        return redirect()->route('soal.kategori')->with('success', 'Kategori soal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['kategori'] = $this->service->findKategoriSoal($id);

        return view('backend.bank_soal.kategori.form', compact('data'), [
            'title' => 'Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Bank Soal' => '',
                'Kategori' => route('soal.kategori'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalKategoriRequest $request, $id)
    {
        $this->service->updateKategoriSoal($request, $id);

        return redirect()->route('soal.kategori')->with('success', 'Kategori soal berhasil diedit');
    }

    public function destroy($id)
    {
        $this->service->deleteKategoriSoal($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
