<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi\SertifikatPeserta;
use App\Services\ArtikelService;
use App\Services\Badge\BadgeService;
use App\Services\Banner\BannerKategoriService;
use App\Services\Course\Bahan\BahanConferenceService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\JadwalService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\LearningCompetency\JourneyService;
use App\Services\LearningCompetency\KompetensiService;
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
        JadwalService $jadwal,
        BadgeService $badge,
        KompetensiService $kompetensi
    )
    {
        $this->banner = $banner;
        $this->page = $page;
        $this->mata = $mata;
        $this->jadwal = $jadwal;
        $this->badge = $badge;
        $this->kompetensi = $kompetensi;

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
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $data['counter'] = [
                'peserta_badge' => app()->make(BadgeService::class)->countBadge(auth()->user()->peserta->id),
                'peserta_sertifikat' => SertifikatPeserta::where('peserta_id',auth()->user()->peserta->id)->count(),
                'peserta_mata' => app()->make(MataService::class)->countMataPeserta(auth()->user()->peserta->id),
                'peserta_journey' => app()->make(JourneyService::class)->countJourney(auth()->user()->peserta->id),
            ];
            $data['myBadge'] = $this->badge->getBadgePeserta(auth()->user()->peserta->id);
            $data['rekomendasi'] = $this->kompetensi->getRekomendasiMata(auth()->user()->peserta->id);
            $data['kompetensiMata'] = $this->kompetensi->getKompetensiMata();
            }
        $data['latestCourse'] = app()->make(MataService::class)->getLatestMata();
        $data['jadwalPelatihan'] = app()->make(JadwalService::class)->getJadwal(5);
        $data['videoConference'] = app()->make(BahanConferenceService::class)->latestConference();
        $data['latestArticle'] = app()->make(ArtikelService::class)->getLatestArticle();

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
