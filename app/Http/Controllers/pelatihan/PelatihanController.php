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
        $data['mata'] = $this->service->getMataFree('id', 'DESC', 12,$request);
        // dd($data['mata']);
        return view('frontend.pelatihan.index', compact('data'));
    }

    
    public function show($id)
    {
        // return $id;
        // return $data['program'] = $this->program->findProgram($id);
       
        $data['mata'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriNoRole($id);
        if(auth()->user() != null)
        {
            $data['peserta'] = $this->servicePeserta->findPesertaByUserId(auth()->user()->id);
        }else{
            $data['peserta'] ='';
        }
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
        // return $id;
        $data['read'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriByMata($id);
        $data['other_mata'] = $this->service->getOtherMata($id);

        //rating
        $data['numberRating'] = [1, 2, 3, 4, 5];
        $data['numberProgress'] = [1, 2, 3, 4, 5];
        rsort($data['numberProgress']);
         
        // if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        //     if ($data['read']->program->publish == 0 || $data['read']->publish == 0) {
        //         return abort(404);
        //     }

        //     if (now() < $data['read']->publish_start) {
        //         return abort(404);
        //     }
        // }
// dd("test");
        $this->serviceProgram->checkAdmin($data['read']->program_id);
        $this->serviceProgram->checkPeserta($data['read']->program_id);
        // if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
        //     if ($this->service->checkUserEnroll($id) == 0) {
        //         return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
        //     }
        // }

        // if (!empty($data['read']->kode_evaluasi)) {
        //     $preview = $this->serviceEvaluasi->preview($data['read']->kode_evaluasi);
        //     $data['checkKode'] = $preview->success;
        //     if ($preview->success == true) {
        //         $data['preview'] = $preview->data->evaluasi;
        //         if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        //             $data['apiUser'] = $this->serviceEvaluasi->checkUserPenyelenggara($id)->first();
        //         }
        //     }
        // }
           
        return view('frontend.pelatihan.pelatihan', compact('data'), [
            'title' => $data['read']->judul,
            // 'breadcrumbsBackend' => [
            //     'Course' => route('course.list'),
            //     'Detail' => '',
            // ],
        ]);
    }


    public function filterBy(Request $request, $groupBy)
    {
        // dd($groupBy);
        if($groupBy =="Alphabetical"){
            $orderBy = 'ASC';
            $data['mata'] = $this->service->getMataFree('judul', $orderBy,12, $request);
        }elseif ($groupBy=="Newly published") {
            $orderBy = 'DESC';
            $data['mata'] = $this->service->getMataFree('urutan', $orderBy,12, $request);
        }else{
            $orderBy ='DESC';
            $data['mata'] = $this->service->getMataFree('urutan', $orderBy,12, $request);
        }
        return view('frontend.pelatihan.index', compact('data'));
    }

}
