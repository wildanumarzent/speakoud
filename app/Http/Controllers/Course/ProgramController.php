<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramRequest;
use App\Services\Course\ProgramService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    private $service;

    public function __construct(ProgramService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['program'] = $this->service->getProgramList($request);
        $data['number'] = $data['program']->firstItem();
        $data['program']->withPath(url()->current().$p.$q);

        return view('backend.course_management.program.index', compact('data'), [
            'title' => 'Program Pelatihan',
            'breadcrumbsBackend' => [
                'Program Pelatihan' => '',
            ],
        ]);
    }

    public function create()
    {
        return view('backend.course_management.program.form', [
            'title' => 'Program Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Program Pelatihan' => route('program.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(ProgramRequest $request)
    {
        $this->service->storeProgram($request);

        return redirect()->route('program.index')
            ->with('succes', 'Program pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['program'] = $this->service->findProgram($id);

        return view('backend.course_management.program.form', compact('data'), [
            'title' => 'Program Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Program Pelatihan' => route('program.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(ProgramRequest $request, $id)
    {
        $this->service->updateProgram($request, $id);

        return redirect()->route('program.index')
            ->with('succes', 'Program pelatihan berhasil diedit');
    }

    public function publish($id)
    {
        $this->service->publishProgram($id);

        return back()->with('succes', 'Status berhasil diubah');
    }

    public function position()
    {
        $i = 0;

        foreach ($_POST['data'] as $value) {
            $i++;
            $this->service->positionProgram($value, $i);
        }
    }

    public function destroy($id)
    {
        $this->service->deleteProgram($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
