<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateMateriRequest;
use App\Services\Course\Template\TemplateMataService;
use App\Services\Course\Template\TemplateMateriService;
use Illuminate\Http\Request;

class TemplateMateriController extends Controller
{
    private $service, $serviceMata;

    public function __construct(
        TemplateMateriService $service,
        TemplateMataService $serviceMata
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
    }

    public function index(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['materi'] = $this->service->getTemplateMateriList($request, $mataId);
        $data['number'] = $data['materi']->firstItem();
        $data['materi']->withPath(url()->current().$q);
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.materi.index', compact('data'), [
            'title' => 'Template - Materi',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => '',
            ],
        ]);
    }

    public function create($mataId)
    {
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.materi.form', compact('data'), [
            'title' => 'Template - Materi - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $mataId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(TemplateMateriRequest $request, $mataId)
    {
        $this->service->storeTemplateMateri($request, $mataId);

        return redirect()->route('template.materi.index', ['id' => $mataId])
            ->with('success', 'Template Mata berhasil ditambahkan');
    }

    public function edit($mataId, $id)
    {
        $data['materi'] = $this->service->findTemplateMateri($id);
        $data['mata'] = $this->serviceMata->findTemplateMata($mataId);

        return view('backend.course_management.template.materi.form', compact('data'), [
            'title' => 'Template - Materi - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $mataId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(TemplateMateriRequest $request, $mataId, $id)
    {
        $this->service->updateTemplateMateri($request, $id);

        return redirect()->route('template.materi.index', ['id' => $mataId])
            ->with('success', 'Template Mata berhasil diedit');
    }

    public function position($mataId, $id, $urutan)
    {
        $this->service->positionTemplateMateri($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort($mataId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortTemplateMateri($value, $i);
        }
    }

    public function destroy($mataId, $id)
    {
        $delete = $this->service->deleteTemplateMateri($id);

        if ($delete == false) {

            return response()->json([
                'success' => 0,
                'message' => 'Template Mata gagal dihapus dikarenakan'.
                            ' masih memiliki template materi & data yang bersangkutan'
            ], 200);
        } else {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }
}
