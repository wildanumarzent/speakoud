<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course\Bahan\BahanQuizItemTracker;
use App\Models\Course\Bahan\BahanQuiz;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MateriService;
use App\Services\Course\MataService;
use App\Services\Users\PesertaService;
class ReportController extends Controller
{

    private $bahan,$peserta;
    public function __construct(BahanService $bahan, PesertaService $peserta,MateriService $materi,MataService $mata)
    {
        $this->peserta = $peserta;
        $this->bahan = $bahan;
        $this->materi = $materi;
        $this->mata = $mata;
    }

    public function compare(Request $request,$materiId){
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $pretest = BahanQuiz::where('materi_id',$materiId)->where('kategori','0')->pluck('id');
        $postest = BahanQuiz::where('materi_id',$materiId)->where('kategori','2')->pluck('id');
        $data['pretestA'] = BahanQuizItemTracker::whereIn('quiz_id',$pretest)->get();
        $data['postestA'] = BahanQuizItemTracker::whereIn('quiz_id',$postest)->get();
        $data['pretestR'] = BahanQuizItemTracker::whereIn('quiz_id',$pretest)->where('benar',1)->get();
        $data['postestR'] = BahanQuizItemTracker::whereIn('quiz_id',$postest)->where('benar',1)->get();
        $data['materi'] = $this->materi->findMateri($materiId);
      $data['peserta'] = $this->mata->getPesertaList($request, $data['materi']->mata_id);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        return view('backend.report.compare.index', compact('data'), [
            'title' => 'Test Comparison Report',
            'breadcrumbsBackend' => [
                $data['materi']->judul => route('bahan.index', ['id' => $data['materi']->id]),
            ],
        ]);
    }
}
