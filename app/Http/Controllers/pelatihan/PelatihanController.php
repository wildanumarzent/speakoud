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
        $data['mata'] = $this->service->getMata('urutan', 'ASC', 8);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
