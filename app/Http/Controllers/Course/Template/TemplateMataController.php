<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\Template\TemplateMataRequest;
use App\Services\Course\Template\TemplateMataService;
use Illuminate\Http\Request;

class TemplateMataController extends Controller
{
    private $service;

    public function __construct(
        TemplateMataService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['mata'] = $this->service->getTemplateMataList($request);
        $data['number'] = $data['mata']->firstItem();
        $data['mata']->withPath(url()->current().$param);

        return view('backend.course_management.template.mata.index', compact('data'), [
            'title' => 'Template - Program',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => '',
            ],
        ]);
    }

    public function create()
    {
        return view('backend.course_management.template.mata.form', [
            'title' => 'Template - Program - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(TemplateMataRequest $request)
    {
        $bobot = ($request->join_vidconf + $request->activity_completion +
            $request->forum_diskusi + $request->webinar + $request->progress_test +
            $request->quiz + $request->tugas_mandiri + $request->post_test);

        if ($bobot < 100 || $bobot > 100) {
            return back()->with('warning', 'Bobot nilai harus memiliki jumlah 
                keseluruhan 100%, tidak boleh kurang / lebih');
        }

        $this->service->storeTemplateMata($request);

        return redirect()->route('template.mata.index')
            ->with('success', 'Template Program berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['mata'] = $this->service->findTemplateMata($id);

        return view('backend.course_management.template.mata.form', compact('data'), [
            'title' => 'Template - Program - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(TemplateMataRequest $request, $id)
    {
        $bobot = ($request->join_vidconf + $request->activity_completion +
            $request->forum_diskusi + $request->webinar + $request->progress_test +
            $request->quiz + $request->tugas_mandiri + $request->post_test);

        if ($bobot < 100 || $bobot > 100) {
            return back()->with('warning', 'Bobot nilai harus memiliki jumlah 
                keseluruhan 100%, tidak boleh kurang / lebih');
        }
        
        $this->service->updateTemplateMata($request, $id);

        return redirect()->route('template.mata.index')
            ->with('success', 'Template Program berhasil diedit');
    }

    public function position($id, $urutan)
    {
        $this->service->positionTemplateMata($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort()
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortTemplateMata($value, $i);
        }
    }

    public function publish($id)
    {
        $mata = $this->service->findTemplateMata($id);

        if ($mata->bahan->count() == 0) {
            return back()->with('warning', 'Template program belum memiliki mata & materi');
        }

        $this->service->publishTemplateMata($id);

        return back()->with('success', 'Berhasil merubah status template');
    }

    public function destroy($id)
    {
        $delete = $this->service->deleteTemplateMata($id);

        if ($delete == false) {

            return response()->json([
                'success' => 0,
                'message' => 'Template Program gagal dihapus dikarenakan'.
                            ' masih memiliki template mata & data yang bersangkutan'
            ], 200);
            
        } else {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }
}
