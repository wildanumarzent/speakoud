<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grades\GradesKategoriRequest;
use App\Services\Grades\GradesKategoriService;
use Illuminate\Http\Request;

class GradesKategoriController extends Controller
{
    private $service;

    public function __construct(GradesKategoriService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['kategori'] = $this->service->getGradesKategoriList($request);
        $data['no'] = $data['kategori']->firstItem();
        $data['kategori']->withPath(url()->current().$param);

        return view('backend.grades_management.kategori.index', compact('data'), [
            'title' => 'Grades - Kategori',
            'breadcrumbsBackend' => [
                'Grades' => '#!',
                'Kategori' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.grades_management.kategori.form', [
            'title' => 'Grades - Kategori - Tambah',
            'breadcrumbsBackend' => [
                'Grades' => '#!',
                'Kategori' => route('grades.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(GradesKategoriRequest $request)
    {
        $this->service->storeGradesKategori($request);

        return redirect()->route('grades.index')
            ->with('success', 'Grades berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['kategori'] = $this->service->findGradesKategori($id);

        return view('backend.grades_management.kategori.form', compact('data'), [
            'title' => 'Grades - Kategori - Edit',
            'breadcrumbsBackend' => [
                'Grades' => '#!',
                'Kategori' => route('grades.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(GradesKategoriRequest $request, $id)
    {
        $this->service->updateGradesKategori($request, $id);

        return redirect()->route('grades.index')
            ->with('success', 'Grades berhasil diedit');
    }

    public function destroy($id)
    {
        $delete = $this->service->deleteGradesKategori($id);

        if ($delete == true) {
            
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Kategori masih memiliki list nilai'
            ], 200);
        }
    }
}
