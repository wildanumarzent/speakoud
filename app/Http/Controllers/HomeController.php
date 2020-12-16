<?php

namespace App\Http\Controllers;

use App\Services\Banner\BannerKategoriService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\JadwalService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\PageService;
use App\Services\Users\InstrukturService;
use App\Services\Users\InternalService;
use App\Services\Users\MitraService;
use App\Services\Users\PesertaService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $banner, $page, $mata, $jadwal;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BannerKategoriService $banner,
        PageService $page,
        MataService $mata,
        JadwalService $jadwal
    )
    {
        $this->banner = $banner;
        $this->page = $page;
        $this->mata = $mata;
        $this->jadwal = $jadwal;

        if (request()->segment(1) != null) {
            $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['banner'] = $this->banner->findBannerKategori(1);
        $data['pageOne'] = $this->page->findPage(1);
        $data['pageSix'] = $this->page->findPage(4);
        $data['mata'] = $this->mata->getMata('urutan', 'ASC', 8);
        $data['jadwal'] = $this->jadwal->getJadwal(6);

        return view('frontend.index', compact('data'));
    }

    public function dashboard(Request $request)
    {
        $data['counter'] = [
            'user_internal' => app()->make(InternalService::class)->countInternal(),
            'user_mitra' =>app()->make(MitraService::class)->countMitra(),
            'user_instruktur' => app()->make(InstrukturService::class)->countInstruktur(),
            'user_peserta' => app()->make(PesertaService::class)->countPeserta(),
            'course_kategori' => app()->make(ProgramService::class)->countProgram(),
            'course_program' => app()->make(MataService::class)->countMata(),
            'course_mata' => app()->make(MateriService::class)->countMateri(),
            'course_materi' => app()->make(BahanService::class)->countBahan(),
        ];
        $data['latestCourse'] = app()->make(MataService::class)->getLatestMata();

        return view('backend.dashboard.index', compact('data'), [
            'title' => 'Dashboard',
        ]);
    }

    public function denide()
    {
        return view('components.errors.denide', [
            'title' => 'Access Denide',
            'breadcrumbsFrontend' => [
                'Acccss Denide' => '',
            ],
        ]);
    }
}
