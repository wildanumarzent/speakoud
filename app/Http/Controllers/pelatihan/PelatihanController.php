<?php

namespace App\Http\Controllers\pelatihan;

use App\Http\Controllers\Controller;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\KonfigurasiService;
use App\Services\Users\InstrukturService;
use App\Services\Users\PesertaService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
   private $service, $serviceProgram, $serviceMateri, $serviceInstruktur,
        $servicePeserta, $serviceKonfig, $serviceEvaluasi, $serviceTemplate;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        MateriService $serviceMateri,
        InstrukturService $serviceInstruktur,
        PesertaService $servicePeserta,
        KonfigurasiService $serviceKonfig,
        EvaluasiService $serviceEvaluasi
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceMateri = $serviceMateri;
        $this->serviceInstruktur = $serviceInstruktur;
        $this->servicePeserta = $servicePeserta;
        $this->serviceKonfig = $serviceKonfig;
        $this->serviceEvaluasi = $serviceEvaluasi;
    }
    public function index(Request $request)
    {
        $data['mata'] = $this->service->getMataFree('urutan', 'ASC', 8);
        // $data['program'] = $this->program->programListNoRole($request);
        return view('frontend.pelatihan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        // return $data['program'] = $this->program->findProgram($id);
       
        $data['mata'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriNoRole($id);
        $data['peserta'] = $this->servicePeserta->findPesertaByUserId(auth()->user()->id);
        // $data['other_mata'] = $this->service->getOtherMata($id);
    //    return $data['read'] = $this->service->findMata($id);
        $data['numberRating'] = [1, 2, 3, 4, 5];
        $data['numberProgress'] = [1, 2, 3, 4, 5];
        rsort($data['numberProgress']);
     
        $start = Carbon::parse( $data['mata']->publish_start);
        $start_end = Carbon::parse( $data['mata']->publish_end);
        $data['duration'] = $start->diff($start_end);
        // return $data['mata']->program->mata;
        return view("frontend.pelatihan.detail", compact('data'));
    }

    public function courseDetail($id)
    {
        $data['read'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriByMata($id);
        $data['other_mata'] = $this->service->getOtherMata($id);

        //rating
        $data['numberRating'] = [1, 2, 3, 4, 5];
        $data['numberProgress'] = [1, 2, 3, 4, 5];
        rsort($data['numberProgress']);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['read']->program->publish == 0 || $data['read']->publish == 0) {
                return abort(404);
            }

            if (now() < $data['read']->publish_start) {
                return abort(404);
            }
        }

        $this->serviceProgram->checkAdmin($data['read']->program_id);
        $this->serviceProgram->checkPeserta($data['read']->program_id);
        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
            if ($this->service->checkUserEnroll($id) == 0) {
                return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            }
        }

        if (!empty($data['read']->kode_evaluasi)) {
            $preview = $this->serviceEvaluasi->preview($data['read']->kode_evaluasi);
            $data['checkKode'] = $preview->success;
            if ($preview->success == true) {
                $data['preview'] = $preview->data->evaluasi;
                if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
                    $data['apiUser'] = $this->serviceEvaluasi->checkUserPenyelenggara($id)->first();
                }
            }
        }

        return view('frontend.pelatihan.pelatihan', compact('data'), [
            'title' => $data['read']->judul,
            // 'breadcrumbsBackend' => [
            //     'Course' => route('course.list'),
            //     'Detail' => '',
            // ],
        ]);
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
