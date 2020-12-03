<?php

namespace App\Http\Controllers;

use App\Services\Banner\BannerKategoriService;
use App\Services\Course\JadwalService;
use App\Services\Course\MataService;
use App\Services\PageService;
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
        $data['pageSix'] = $this->page->findPage(6);
        $data['mata'] = $this->mata->getMata('urutan', 'ASC', 8);
        $data['jadwal'] = $this->jadwal->getJadwal(6);

        return view('frontend.index', compact('data'));
    }

    public function dashboard(Request $request)
    {
        return view('backend.dashboard.index', [
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
