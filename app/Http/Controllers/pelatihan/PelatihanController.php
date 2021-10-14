<?php

namespace App\Http\Controllers\Pelatihan;

use App\Http\Controllers\Controller;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\MateriService;
use App\Services\Course\ProgramService;
use App\Services\KonfigurasiService;
use App\Services\Users\InstrukturService;
use App\Services\Users\PesertaService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\Bahan\ActivityService;


use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
   private $service, $serviceProgram, $serviceMateri, $serviceInstruktur,
        $servicePeserta, $serviceKonfig, $serviceEvaluasi, $serviceTemplate,  $serviceActivity, $bahanService;

    public function __construct(
        MataService $service,
        ProgramService $serviceProgram,
        MateriService $serviceMateri,
        InstrukturService $serviceInstruktur,
        PesertaService $servicePeserta,
        KonfigurasiService $serviceKonfig,
        EvaluasiService $serviceEvaluasi,
        BahanService $bahanService,
        ActivityService $serviceActivity
    )
    {
        $this->service = $service;
        $this->serviceProgram = $serviceProgram;
        $this->serviceMateri = $serviceMateri;
        $this->serviceInstruktur = $serviceInstruktur;
        $this->servicePeserta = $servicePeserta;
        $this->serviceKonfig = $serviceKonfig;
        $this->serviceEvaluasi = $serviceEvaluasi;
        $this->bahanService = $bahanService;
        $this->serviceActivity = $serviceActivity;
    }

    public function index(Request $request)
    {
        $data['mata'] = $this->service->getMataFree('id', 'DESC', 12,$request);
        $data['kategori'] = $this->serviceProgram->getProgramList($request);
        return view('frontend.pelatihan.index', compact('data'));
    }

    
    public function show($id)
    {

        $data['mata'] = $this->service->findMata($id);
        if(auth()->user() != null){
            // dd(auth()->user()->);
            $data['pelatihanKhusus']=$this->servicePeserta->getPelatihanKhusus( auth()->user()->peserta->id , $data['mata']->id);
        }
        if(auth()->user() != null)
        {
            $data['peserta'] = $this->servicePeserta->findPesertaByUserId(auth()->user()->id);
            $data['instruktur'] = $this->serviceInstruktur->findInstrukturByUserId(auth()->user()->id);
            if($data['peserta'] != null)
            {
                $array = ['peserta_id' => $data['peserta']->id];
                $object = (object) $array;
                // $this->service->storePeserta($object, $id);
            }

            if($data['instruktur'] != null)
            {
                $array = ['instruktur_id' => $data['instruktur']->id];
                $object = (object) $array;
                $this->service->storeInstruktur($object, $id);
            }
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
        $data['read'] = $this->service->findMata($id);
        $data['materi'] = $this->serviceMateri->getMateriByMata($id);
        $data['other_mata'] = $this->service->getOtherMata($id);
       
        //rating
        $data['numberRating'] = [1, 2, 3, 4, 5];
        $data['numberProgress'] = [1, 2, 3, 4, 5];
        rsort($data['numberProgress']);
         
        $this->serviceProgram->checkAdmin($data['read']->program_id);
        $this->serviceProgram->checkPeserta($data['read']->program_id);
        // if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra|peserta_internal|peserta_mitra')) {
            // if ($this->service->checkUserEnroll($id) == 0) {
            //     return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            // }
        // }
           
        return view('frontend.pelatihan.roomPelatihan', compact('data'), [
            'title' => $data['read']->judul,
            // 'breadcrumbsBackend' => [
            //     'Course' => route('course.list'),
            //     'Detail' => '',
            // ],
        ]);
    }

     public function viewRoom($mataId, $id, $tipe)
    {
        $data['mata'] = $this->service->findMata($mataId);
        $data['bahan'] = $this->bahanService->findBahan($id);
        // dd($data['bahan']);
        $data['materi'] = $this->serviceMateri->findMateri($data['bahan']->materi_id);
        $data['materiByMata'] = $this->serviceMateri->getMateriByMata($mataId);
        $data['materi_lain'] = $this->serviceMateri->getMateriByMata($data['bahan']->mata_id);
        $data['jump'] = $this->bahanService->bahanJump($mataId, $id);
        $data['prev'] = $this->bahanService->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'prev');
        $data['next'] = $this->bahanService->bahanPrevNext($data['materi']->id, $data['bahan']->urutan, 'next');

        //check data
        if (!auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($tipe == 'conference' && $data['bahan']->publish == 0) {
                return abort(404);
            }
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra|instruktur_internal')) {
           
            if (now()->format('Y-m-d H:i:s') > $data['mata']->publish_end->format('Y-m-d H:i:s')) {
                return back()->with('warning', 'Pelatihan telah selesai');
            }
            
            //publish
            if ($data['bahan']->program->publish == 0 || $data['bahan']->mata->publish == 0 ||
                $data['bahan']->materi->publish == 0 || $data['bahan']->publish == 0) {
                return abort(404);
            }

            //enroll
            // if ($this->serviceMata->checkUserEnroll($mataId) == 0) {
            //     return back()->with('warning', 'anda tidak terdaftar di course '.$data['read']->judul.'');
            // }
 
            // restrict
            if ($data['bahan']->restrict_access >= '0') {
                
                if ($data['bahan']->restrict_access == '0') {
                    $checkMateri = $this->serviceActivity->restrict($data['bahan']->requirement);
                    if ($checkMateri == 0) {
                        return back()->with('warning', 'Materi tidak bisa diakses sebelum anda menyelesaikan materi '.
                            $data['bahan']->restrictBahan($data['bahan']->requirement)->judul);
                    }
                }

                if ($data['bahan']->restrict_access == 1) {
                    if ($tipe == 'dokumen' || $tipe == 'scorm' || $tipe == 'audio' || $tipe == 'video') {
                        if (now() < $data['bahan']->publish_start) {
                            return back()->with('warning', 'Materi tidak bisa diakses karena belum memasuki tanggal yang sudah ditentukan');
                        }

                        if (now() > $data['bahan']->publish_end) {
                            return back()->with('warning', 'Materi tidak bisa diakses karena sudah melebihi tanggal yang sudah ditentukan');
                        }
                    }
                }
            }

            // record completion
            if (empty($data['bahan']->activityCompletionByUser) && $data['bahan']->completion_type > 0) {
                $this->serviceActivity->recordActivity($id);

                return redirect()->route('course.bahan', ['id' => $mataId, 'bahanId' => $id, 'tipe' => $data['bahan']->type($data['bahan'])['tipe']]);
            }

            //completion time
            if ($data['bahan']->completion_type == 3 && !empty($data['bahan']->completion_parameter) &&
                !empty($data['bahan']->activityCompletionByUser)) {

                $durasi = $data['bahan']->completion_parameter['timer'];
                $data['timer'] = $data['bahan']->activityCompletionByUser->track_start->addMinutes($durasi);
                $now = now()->format('is');
                $kurang = $data['timer']->diffInSeconds(now());
                $menit = floor($kurang/60);
                $detik = $kurang-($menit*60);
                $data['countdown'] = $menit.':'.$detik;
            }
         
        }

        //check user
        $this->serviceProgram->checkAdmin($data['mata']->program_id);
        $this->serviceProgram->checkPeserta($data['mata']->program_id);
        // $this->service->checkInstruktur($data['bahan']->materi_id);
        
        if ($tipe == 'forum') {
            $data['topik'] = $this->serviceBahanForum->getTopikList($data['bahan']->forum->id);
        }
        
        if ($tipe == 'quiz') {

            if (!empty($data['bahan']->quiz->trackUserIn)) {
                $data['start_time'] = $data['bahan']->quiz->trackUserIn->start_time->format('l, j F Y H:i A');
                $startTime = $data['bahan']->quiz->trackUserIn->start_time;
                if (!empty($data['bahan']->quiz->trackUserIn->end_time)) {
                    $data['finish_time'] = $data['bahan']->quiz->trackUserIn->end_time->format('l, j F Y H:i A');
                    $finishTime = $data['bahan']->quiz->trackUserIn->end_time;
                    $totalDuration = $finishTime->diffInSeconds($startTime);
                    $menit = gmdate('i', $totalDuration);
                    $detik = gmdate('s', $totalDuration);
                    $data['total_duration'] = $menit.' Menit '.$detik.' Detik';
                }
            }
        }
    

        if ($tipe == 'scorm') {
            $data['checkpoint'] = $this->serviceScorm->checkpoint(auth()->user()->id,$data['bahan']->scorm->id);
            if(isset($data['checkpoint'])){
                $data['cpData'] = json_decode($data['checkpoint']->checkpoint,true);
            }
        }

        if ($tipe == 'evaluasi-pengajar') {
            $evaluasi = $data['bahan']->evaluasiPengajar->mataInstruktur;
            if (!empty($evaluasi->kode_evaluasi)) {
                $data['preview'] = $this->serviceEvaluasi->preview($evaluasi->kode_evaluasi)->data->evaluasi;
                if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
                    $data['apiUser'] = $this->serviceEvaluasi->checkUserPengajar($mataId, $id)->first();
                }
            } else {
                return abort(404);
            }
        }
            // dd("masuk dan");
        // $data['pdf'] = response()->file(storage_path('/app/bank_data/'.$data['bahan']->dokumen->bankData->file_path));
        // return $data['bahan']->dokumen->bankData->file_path;
        return view('frontend.course.roomMateri.'.$tipe, compact('data'), [
            'title' => 'Course - Bahan',
            // 'breadcrumbsBackend' => [
            //     'Course' => route('course.list'),
            //     'Detail' => route('course.detail', ['id' => $mataId]),
            //     'Preview' => '',
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
