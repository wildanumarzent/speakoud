<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoalRequest;
use App\Services\Course\Template\TemplateSoalKategoriService;
use App\Services\Course\Template\TemplateSoalService;
use Illuminate\Http\Request;

class TemplateSoalController extends Controller
{
    private $service, $serviceKategori;

    public function __construct(
        TemplateSoalService $service,
        TemplateSoalKategoriService $serviceKategori
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

        $data['soal'] = $this->service->getTemplateSoalList($request, $mataId, $kategoriId);
        $data['number'] = $data['soal']->firstItem();
        $data['soal']->withPath(url()->current().$t.$q);
        $data['kategori'] = $this->serviceKategori->findTemplateSoalKategori($kategoriId);

        return view('backend.course_management.template.bank_soal.index', compact('data'), [
            'title' => 'Template - Bank Soal - Soal',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => route('template.soal.kategori', ['id' => $mataId]),
                'Soal' => '',
            ],
        ]);
    }

    public function soalByKategori(Request $request, $quizId)
    {
        return response()->json($this->service->getTemplateSoalForQuiz($request, $quizId));
    }

    public function create($mataId, $kategoriId)
    {
        $data['kategori'] = $this->serviceKategori->findTemplateSoalKategori($kategoriId);

        return view('backend.course_management.template.bank_soal.form', compact('data'), [
            'title' => 'Template - Soal - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => route('template.soal.kategori', ['id' => $mataId]),
                'Soal' => route('template.soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(SoalRequest $request, $mataId, $kategoriId)
    {
        $this->service->storeTemplateSoal($request, $mataId, $kategoriId);

        return redirect()->route('template.soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId])
            ->with('success', 'Soal berhasil ditambahkan');
    }

    public function edit($mataId, $kategoriId, $id)
    {
        $data['soal'] = $this->service->findTemplateSoal($id);
        $data['kategori'] = $this->serviceKategori->findTemplateSoalKategori($kategoriId);

        return view('backend.course_management.template.bank_soal.form-edit', compact('data'), [
            'title' => 'Kategori Soal - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Kategori Soal' => route('template.soal.kategori', ['id' => $mataId]),
                'Soal' => route('template.soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(SoalRequest $request, $mataId, $kategoriId, $id)
    {
        $this->service->updateTemplateSoal($request, $id);

        return redirect()->route('template.soal.index', ['id' => $mataId, 'kategoriId' => $kategoriId])
            ->with('success', 'Soal berhasil diedit');
    }

    public function destroy($mataId, $kategoriId, $id)
    {
        $delete = $this->service->deleteTemplateSoal($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Soal tidak bisa dihapus dikarenakan sudah terpakai di quiz'
            ], 200);
        }
    }
}
