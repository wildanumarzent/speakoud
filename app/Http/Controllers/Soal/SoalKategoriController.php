<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\SoalKategoriRequest;
use App\Services\Course\MataService;
use App\Services\Soal\SoalKategoriService;
use Illuminate\Http\Request;

class SoalKategoriController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        SoalKategoriService $service,
        MataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function index(Request $request, $mataId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['kategori'] = $this->service->getSoalKategoriList($request, $mataId);
        $data['no'] = $data['kategori']->firstItem();
        $data['kategori']->withPath(url()->current().$param);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.bank_soal.kategori.index', compact('data'), [
            'title' => 'Bank Soal - Kategori',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Kategori Soal' => '',
            ],
        ]);
    }

    public function mata(Request $request)
    {
        $data['mata'] = $this->serviceMata->getMata('urutan', 'ASC', 20);
        $data['number'] = $data['mata']->firstItem();

        return view('backend.bank_soal.kategori.mata', compact('data'), [
            'title' => 'Bank Soal',
            'breadcrumbsBackend' => [
                'Bank Soal' => ''
            ],
        ]);
    }

    public function create($mataId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);

        return view('backend.bank_soal.kategori.form', compact('data'), [
            'title' => 'Kategori Soal - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Kategori Soal' => route('soal.kategori', ['id' => $mataId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalKategoriRequest $request, $mataId)
    {
        $this->service->storeKategoriSoal($request, $mataId);

        return redirect()->route('soal.kategori', ['id' => $mataId])
            ->with('success', 'Kategori soal berhasil ditambahkan');
    }

    public function edit($mataId, $id)
    {
        $data['kategori'] = $this->service->findKategoriSoal($id);
        $data['mata'] = $this->serviceMata->findMata($mataId);

        $this->checkCreator($data['kategori']->creator_id);

        return view('backend.bank_soal.kategori.form', compact('data'), [
            'title' => 'Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Kategori Soal' => route('soal.kategori', ['id' => $mataId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalKategoriRequest $request, $mataId, $id)
    {
        $this->service->updateKategoriSoal($request, $id);

        return redirect()->route('soal.kategori', ['id' => $mataId])
            ->with('success', 'Kategori soal berhasil diedit');
    }

    public function destroy($mataId, $id)
    {
        $kategori = $this->service->findKategoriSoal($id);
        $this->checkCreator($kategori->creator_id);

        $delete = $this->service->deleteKategoriSoal($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Kategori tidak bisa dihapus dikarenakan masih memiliki soal didalamnya'
            ], 200);
        }
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
