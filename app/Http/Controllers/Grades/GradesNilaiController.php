<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradesNilaiRequest;
use App\Services\Grades\GradesKategoriService;
use App\Services\Grades\GradesNilaiService;
use Illuminate\Http\Request;

class GradesNilaiController extends Controller
{
    private $service, $serviceKategori;

    public function __construct(
        GradesNilaiService $service,
        GradesKategoriService $serviceKategori
    )
    {
        $this->service = $service;
        $this->serviceKategori = $serviceKategori;
    }

    public function index(Request $request, $kategoriId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['nilai'] = $this->service->getGradesNilaiList($request, $kategoriId);
        $data['number'] = $data['nilai']->firstItem();
        $data['nilai']->withPath(url()->current().$q);
        $data['kategori'] = $this->serviceKategori->findGradesKategori($kategoriId);

        return view('backend.grades_management.index', compact('data'), [
            'title' => 'Grades - Nilai',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Kategori' => route('grades.index'),
                'Nilai' => ''
            ],
        ]);
    }

    public function create($kategoriId)
    {
        $data['kategori'] = $this->serviceKategori->findGradesKategori($kategoriId);

        return view('backend.grades_management.form', compact('data'), [
            'title' => 'Grades - Nilai - Tambah',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Nilai' => route('grades.nilai', ['id' => $kategoriId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(GradesNilaiRequest $request, $kategoriId)
    {
        $this->service->storeGradesNilai($request, $kategoriId);

        return redirect()->route('grades.nilai', ['id' => $kategoriId])
            ->with('success', 'Nilai Grades berhasil ditambahkan');
    }

    public function edit($kategoriId, $id)
    {
        $data['nilai'] = $this->service->findGradesNilai($id);
        $data['kategori'] = $this->serviceKategori->findGradesKategori($kategoriId);

        return view('backend.grades_management.form', compact('data'), [
            'title' => 'Grades - Nilai - Edit',
            'breadcrumbsBackend' => [
                'Grades' => '',
                'Nilai' => route('grades.nilai', ['id' => $kategoriId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(GradesNilaiRequest $request, $kategoriId, $id)
    {
        $this->service->updateGradesNilai($request, $id);

        return redirect()->route('grades.nilai', ['id' => $kategoriId])
            ->with('success', 'Nilai Grades berhasil diedit');
    }

    public function destroy($kategoriId, $id)
    {
        $this->service->deleteGradesNilai($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
