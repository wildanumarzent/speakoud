<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalRequest;
use App\Services\Course\JadwalService;
use App\Services\Course\MataService;
use App\Services\KonfigurasiService;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    private $service, $serviceMata, $serviceKonfig;

    public function __construct(
        JadwalService $service,
        MataService $serviceMata,
        KonfigurasiService $serviceKonfig
    )
    {
        $this->service = $service;
        $this->serviceMata = $serviceMata;
        $this->serviceKonfig = $serviceKonfig;
    }

    public function index(Request $request)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['jadwal'] = $this->service->getJadwalList($request);
        $data['number'] = $data['jadwal']->firstItem();
        $data['jadwal']->withPath(url()->current().$p.$q);
        $data['mata'] = '';

        return view('backend.course_management.jadwal.index', compact('data'), [
            'title' => 'Jadwal Pelatihan',
            'breadcrumbsBackend' => [
                'Jadwal Pelatihan' => ''
            ],
        ]);
    }

    public function jadwalList()
    {
        $limit = $this->serviceKonfig->getValue('content_limit');

        $data['jadwal'] = $this->service->getJadwal($limit);

        return view('frontend.jadwal.index', compact('data'), [
            'title' => 'Jadwal Pelatihan',
            'breadcrumbsFrontend' => [
                'Program' => route('course.list'),
                'Jadwal' => '',
            ],
        ]);
    }

    public function jadwalDetail($id)
    {
        $data['read'] = $this->service->findJadwal($id);

        if ($data['read']->mata->publish == 0 || $data['read']->publish == 0) {
            return abort(404);
        }

        return view('frontend.jadwal.detail', compact('data'), [
            'title' => 'Jadwal Pelatihan - '.$data['read']->judul,
            'breadcrumbsFrontend' => [
                'Program' => route('course.list'),
                'Jadwal' => route('course.jadwal'),
                $data['read']->judul => '',
            ],
        ]);
    }

    public function create()
    {
        $data['mata'] = $this->serviceMata->getAllMata();

        return view('backend.course_management.jadwal.form', compact('data'), [
            'title' => 'Jadwal Pelatihan - Tambah',
            'breadcrumbsBackend' => [
                'Jadwal' => route('jadwal.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(JadwalRequest $request)
    {
        $this->service->storeJadwal($request);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal pelatihan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['jadwal'] = $this->service->findJadwal($id);
        $data['mata'] = $this->serviceMata->getAllMata();

        $this->checkCreator($id);

        return view('backend.course_management.jadwal.form', compact('data'), [
            'title' => 'Jadwal Pelatihan - Edit',
            'breadcrumbsBackend' => [
                'Jadwal' => route('jadwal.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(JadwalRequest $request, $id)
    {
        $this->checkCreator($id);

        $this->service->updateJadwal($request, $id);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal pelatihan berhasil diedit');
    }

    public function publish($id)
    {
        $this->checkCreator($id);

        $this->service->publishJadwal($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function destroy($id)
    {
        $this->service->deleteJadwal($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function checkCreator($id)
    {
        $jadwal = $this->service->findJadwal($id);

        if (auth()->user()->hasRole('mitra')) {
            if ($jadwal->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }
    }
}
