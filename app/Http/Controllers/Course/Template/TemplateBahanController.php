<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateBahanRequest;
use App\Services\Course\Template\TemplateBahanService;
use App\Services\Course\Template\TemplateMataService;
use App\Services\Course\Template\TemplateMateriService;
use Illuminate\Http\Request;

class TemplateBahanController extends Controller
{
    private $service, $serviceMata, $serviceMateri;

    public function __construct(
        TemplateBahanService $service,
        TemplateMataService $serviceMata,
        TemplateMateriService $serviceMateri
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
        $this->serviceMateri = $serviceMateri;
    }

    public function index(Request $request, $materiId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['bahan'] = $this->service->getTemplateBahanList($request, $materiId);
        $data['number'] = $data['bahan']->firstItem();
        $data['bahan']->withPath(url()->current().$q);
        $data['materi'] = $this->serviceMateri->findTemplateMateri($materiId);

        return view('backend.course_management.template.bahan.index', compact('data'), [
            'title' => 'Template - Bahan',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['materi']->template_mata_id]),
                'Materi' => '',
            ],
        ]);
    }

    public function create(Request $request, $materiId)
    {
        $data['materi'] = $this->serviceMateri->findTemplateMateri($materiId);
        $data['bahan_list'] = $this->service->getTemplateBahan($materiId);

        return view('backend.course_management.template.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Template - Bahan - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['materi']->template_mata_id]),
                'Materi' => route('template.bahan.index', ['id' => $materiId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(TemplateBahanRequest $request, $materiId)
    {
        $materi = $this->serviceMateri->findTemplateMateri($materiId);
        $mata = $this->serviceMata->findTemplateMata($materi->template_mata_id);

        if ($request->type == 'quiz') {
            if ($request->kategori == 1) {
                $pre = $mata->quiz->where('kategori', 1)->count();
                if ($pre > 0) {
                    return back()->with('warning', 'Pre Test sudah ada, tidak bisa ditambahkan lagi');
                }
            }

            if ($request->kategori == 2) {
                $post = $mata->quiz->where('kategori', 2)->count();
                if ($post > 0) {
                    return back()->with('warning', 'Post Test sudah ada, tidak bisa ditambahkan lagi');
                }
            }
        }

        $this->service->storeTemplateBahan($request, $materiId);

        return redirect()->route('template.bahan.index', ['id' => $materiId])
            ->with('success', 'Template Materi berhasil ditambahkan');
    }

    public function edit(Request $request, $materiId, $id)
    {
        if ($request->type == null) {
            return abort(404);
        }

        $data['bahan'] = $this->service->findTemplateBahan($id);
        $data['materi'] = $this->serviceMateri->findTemplateMateri($materiId);
        $data['bahan_list'] = $this->service->getTemplateBahan($materiId, $id);

        return view('backend.course_management.template.bahan.tipe.'.$request->type, compact('data'), [
            'title' => 'Template - Bahan - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['materi']->template_mata_id]),
                'Materi' => route('template.bahan.index', ['id' => $materiId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(TemplateBahanRequest $request, $materiId, $id)
    {
        $this->service->updateTemplateBahan($request, $id);

        return redirect()->route('template.bahan.index', ['id' => $materiId])
            ->with('success', 'Template Materi berhasil diedit');
    }

    public function destroy($materiId, $id)
    {
        $delete = $this->service->deleteTemplateBahan($id);

        if ($delete == false) {

            return response()->json([
                'success' => 0,
                'message' => 'Template Materi gagal dihapus dikarenakan'.
                            'masih memiliki data yang bersangkutan'
            ], 200);
        } else {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }
}
