<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\SoalKategoriRequest;
use App\Services\Course\Template\TemplateMataService;
use App\Services\Course\Template\TemplateSoalKategoriService;
use Illuminate\Http\Request;

class TemplateSoalKategoriController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        TemplateSoalKategoriService $service,
        TemplateMataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function index(Request $request, $mataId)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['kategori'] = $this->service->getTemplateSoalKategoriList($request, $mataId);
        $data['number'] = $data['kategori']->firstItem();
        $data['kategori']->withPath(url()->current().$param);
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.bank_soal.kategori.index', compact('data'), [
            'title' => 'Template - Bank Soal - Kategori',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => '',
            ],
        ]);
    }

    public function create($mataId)
    {
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.bank_soal.kategori.form', compact('data'), [
            'title' => 'Template - Kategori Soal - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => route('template.soal.kategori', ['id' => $mataId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalKategoriRequest $request, $mataId)
    {
        $this->service->storeTemplateSoalKategori($request, $mataId);

        return redirect()->route('template.soal.kategori', ['id' => $mataId])
            ->with('success', 'Kategori soal berhasil ditambahkan');
    }

    public function edit($mataId, $id)
    {
        $data['kategori'] = $this->service->findTemplateSoalKategori($id);
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.bank_soal.kategori.form', compact('data'), [
            'title' => 'Template - Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => route('template.soal.kategori', ['id' => $mataId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalKategoriRequest $request, $mataId, $id)
    {
        $this->service->updateTemplateSoalKategori($request, $id);

        return redirect()->route('template.soal.kategori', ['id' => $mataId])
            ->with('success', 'Kategori soal berhasil diedit');
    }

    public function destroy($mataId, $id)
    {
        $delete = $this->service->deleteTemplateSoalKategori($id);

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
}
