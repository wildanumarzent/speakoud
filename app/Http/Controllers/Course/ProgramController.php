<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramRequest;
use App\Services\Course\ProgramService;
use App\Services\Users\MitraService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    private $service, $serviceMitra;

    public function __construct(
        ProgramService $service,
        MitraService $serviceMitra
    )
    {
        $this->service = $service;
        $this->serviceMitra = $serviceMitra;
    }

    public function index(Request $request)
    {
        $p = '';
        $t = '';
        $q = '';
        if (isset($request->p) || isset($request->t) || isset($request->q)) {
            $p = '?p='.$request->p;
            $t = '&t='.$request->t;
            $q = '&q='.$request->q;
        }
        // dd(auth()->user());
        // if (auth()->user()->hasRole('instruktur_internal')) {  
        //     $data['program'] = $this->service->getProgramListByCreatorId($request);
        // }else{
        // }
        $data['program'] = $this->service->getProgramList($request);
        $data['number'] = $data['program']->firstItem();
        $data['program']->withPath(url()->current().$p.$t.$q);
        return view('backend.course_management.program.index', compact('data'), [
            'title' => 'Course - Kategori Pelatihan',
            'breadcrumbsBackend' => [
                'Kategori Pelatihan' => '',
            ],
        ]);
    }

    public function create()
    {
        $data['mitra'] = $this->serviceMitra->getMitraAll();

        return view('backend.course_management.program.form', compact('data'), [
            'title' => 'Kategori Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Kategori Pelatihan' => route('program.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(ProgramRequest $request)
    {
        // return $request;
        $this->service->storeProgram($request);

        return redirect()->route('program.index')
            ->with('success', 'Kategori pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['program'] = $this->service->findProgram($id);
        $data['mitra'] = $this->serviceMitra->getMitraAll();

        $this->checkRole($data['program']);

        return view('backend.course_management.program.form', compact('data'), [
            'title' => 'Kategori Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Kategori Pelatihan' => route('program.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(ProgramRequest $request, $id)
    {
        $program = $this->service->findProgram($id);
        $this->checkRole($program);

        $this->service->updateProgram($request, $id);

        return redirect()->route('program.index')
            ->with('success', 'Kategori pelatihan berhasil diedit');
    }

    public function publish($id)
    {
        $program = $this->service->findProgram($id);
        $this->checkRole($program);

        // $materi = $program->materi;
        // $bahan = [];
        // foreach ($materi as $key) {
        //     $bahan = $key->bahan->count();
        // }

        // if ($bahan == 0) {
        //     return back()->with('warning', 'Sebelum di publish, Tiap materi harus memiliki bahan.');
        // }

        $this->service->publishProgram($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($id, $urutan)
    {
        $program = $this->service->findProgram($id);
        $this->checkRole($program);

        $this->service->positionProgram($id, $urutan);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function sort()
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortProgram($value, $i);
        }
    }

    public function destroy($id)
    {
        // dd($id);
        // $program = $this->service->findProgram($id);
        // $this->checkRole($program);

        // $delete = $this->service->deleteProgram($id);

        // if ($delete == false) {

        //     return response()->json([
        //         'success' => 0,
        //         'message' => 'Kategori pelatihan gagal dihapus dikarenakan'.
        //                     ' masih memiliki program pelatihan didalamnya'
        //     ], 200);
        // } else {

        //     return response()->json([
        //         'success' => 1,
        //         'message' => ''
        //     ], 200);
        // }

    }

    public function checkRole($program)
    {
        if (auth()->user()->hasRole('internal') || auth()->user()->hasRole('mitra')) {
            if (auth()->user()->hasRole('internal')) {
                $check = ($program->mitra_id != null);
            }

            if (auth()->user()->hasRole('mitra')) {
                $check = ($program->mitra_id != auth()->user()->mitra->id);
            }

            if ($check) {
                return abort(403);
            }
        }
    }
}
