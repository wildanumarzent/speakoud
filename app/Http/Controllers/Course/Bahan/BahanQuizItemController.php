<?php

namespace App\Http\Controllers\Course\Bahan;


use App\Http\Controllers\Controller;
use App\Http\Requests\QuizItemRequest;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Services\Course\Bahan\BahanQuizItemService;
use App\Services\Course\Bahan\BahanQuizService;
use App\Services\Course\Bahan\BahanService;
use App\Services\Soal\SoalKategoriService;
use App\Services\Soal\SoalService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuizExport;
use App\Models\Course\Bahan\BahanQuizItemTracker;
use App\Services\Course\Bahan\ActivityService;

class BahanQuizItemController extends Controller
{
    private $service, $serviceBahan, $serviceQuiz, $serviceSoalKategori, $serviceSoal,
        $serviceActivity;

    public function __construct(
        BahanQuizItemService $service,
        BahanService $serviceBahan,
        BahanQuizService $serviceQuiz,
        SoalKategoriService $serviceSoalKategori,
        SoalService $serviceSoal,
        ActivityService $serviceActivity
    )
    {
        $this->service = $service;
        $this->serviceBahan = $serviceBahan;
        $this->serviceQuiz = $serviceQuiz;
        $this->serviceSoalKategori = $serviceSoalKategori;
        $this->serviceSoal = $serviceSoal;
        $this->serviceActivity = $serviceActivity;
    }

    public function index(Request $request, $quizId)
    {
        $t = '';
        $q = '';
        if (isset($request->t) || isset($request->q)) {
            $t = '?t='.$request->t;
            $q = '&q='.$request->q;
        }

        $data['quiz_item'] = $this->service->getItemList($request, $quizId);
        // dd($data['quiz_item']);
        $data['number'] = $data['quiz_item']->firstItem();
        $data['quiz_item']->withPath(url()->current().$t.$q);
        $data['quiz'] = $this->service->findQuiz($quizId);

        $data['soal_kategori'] = $this->serviceSoalKategori->getSoalKategori($data['quiz']->mata_id);
        
        $soal = null;
        if ($data['quiz_item']->total() > 0) {
            $collectSoal = collect($this->service->getItem($quizId));
            $soal = $collectSoal->map(function($item, $key) {
                return $item->pertanyaan;
            })->all();
        }
        $data['soal'] = $this->serviceSoal->getSoalByMata($data['quiz']->mata_id, $soal);

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('backend.course_management.bahan.quiz.index', compact('data'), [
            'title' => 'Bahan Pelatihan - Quiz Item',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Modul Pelatihan' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Materi' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
                'Soal Quiz' => '',
            ],
        ]);
    }

    public function preview($quizId)
    {
        $data['quiz'] = $this->service->findQuiz($quizId);

        if ($data['quiz']->soal_acak == 1) {
            $data['soal'] = $data['quiz']->item()->inRandomOrder()
                ->limit($data['quiz']->jml_soal_acak)->get();
        } else {
            $data['soal'] = $data['quiz']->item;
        }

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('backend.course_management.bahan.quiz.preview', compact('data'), [
            'title' => 'Quiz - Preview',
            'breadcrumbsBackend' => [
                'Soal' => route('quiz.item', ['id' => $quizId]),
                'Preview' => ''
            ],
        ]);
    }

    public function room($quizId)
    {
        $data['quiz'] = $this->service->findQuiz($quizId);

        if ($data['quiz']->bahan->publish == 0) {
            return abort(404);
        }

        if ($data['quiz']->item()->count() == 0) {
            return back()->with('warning', 'Tidak ada soal');
        }


        $restrict = $this->serviceBahan->restrictAccess($data['quiz']->bahan_id);
        if (!empty($restrict)) {
            return back()->with('warning', $restrict);
        }

        if ($data['quiz']->trackUserIn()->count() == 0) {
            $this->serviceQuiz->trackUserIn($quizId);
            if ($data['quiz']->soal_acak == 1 && !empty($data['quiz']->jml_soal_acak)) {
                $this->service->insertSoalRandom($quizId);
            }

            return redirect()->route('quiz.room', ['id' => $quizId]);
        }
        if (!empty($data['quiz']->trackUserIn) && !empty($data['quiz']->durasi)) {
            $start = $data['quiz']->trackUserIn->start_time->addMinutes($data['quiz']->durasi);
            $now = now()->format('is');
            $kurang = $start->diffInSeconds(now());
            $menit = floor($kurang/60);
            $detik = $kurang-($menit*60);
            $data['countdown'] = $menit.':'.$detik;

            if ($data['quiz']->trackUserIn->status == 2) {
                return back()->with('info', 'Anda sudah menyelesaikan quiz ini');
            }
            if (now()->format('Y-m-d H:i:s') > $data['quiz']->trackUserIn->start_time->addMinutes($data['quiz']->durasi)->format('Y-m-d H:i:s')) {
                return redirect()->route('course.bahan', ['id' => $data['quiz']->mata_id, 'bahanId' => $data['quiz']->bahan_id, 'tipe' => 'quiz'])
                    ->with('warning', 'Durasi sudah habis');
            }
        }

        $collectSoal = collect($data['quiz']->trackUserItem);
        $soalId = $collectSoal->map(function($item, $key) {
            return $item->quiz_item_id;
        })->all();

        $data['quiz_tracker'] = $this->service->getSoalQuizTracker($quizId);
        $data['count_tracker'] = $this->service->getSoalQuizTracker($quizId)->count();
        $data['soal'] = $this->service->soalQuiz($quizId, $soalId);

        if ($data['quiz']->view == true) {
            $view = 1;
        } else {
            $view = 0;
        }

        return view('frontend.course.quiz.room-'.$view, compact('data'), [
            'title' => 'Quiz - Test',
            'breadcrumbsBackend' => [
                'Bahan' => route('course.bahan', [
                    'id' => $data['quiz']->mata_id,
                    'bahanId' => $data['quiz']->bahan_id,
                    'tipe' => 'quiz'
                ]),
                'Quiz' => '',
                'Test' => ''
            ],
        ]);
    }

    public function peserta(Request $request, $quizId)
    {
        $s = '';
        $q = '';
        if (isset($request->s) || isset($request->q)) {
            $s = '?s='.$request->s;
            $q = '&q='.$request->q;
        }

        $data['peserta'] = $this->serviceQuiz->quizPesertaList($request, $quizId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$s.$q);
        $data['quiz'] = $this->service->findQuiz($quizId);

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('frontend.course.quiz.peserta', compact('data'), [
            'title' => 'Quiz - Peserta',
            'breadcrumbsBackend' => [
                'Quiz' => route('course.bahan', [
                    'id' => $data['quiz']->mata_id,
                    'bahanId' => $data['quiz']->bahan_id,
                    'tipe' => 'quiz'
                ]),
                'Peserta' => ''
            ],
        ]);
    }

    public function jawabanPeserta($quizId, $pesertaId)
    {
        $data['peserta'] = $this->serviceQuiz->findQuizPeserta($quizId, $pesertaId);
        $data['item'] = $this->service->jawabanPeserta($quizId, $pesertaId);
        $data['quiz'] = $this->service->findQuiz($quizId);

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            if ($data['quiz']->hasil == 0) {
                return back()->with('warning', 'Anda tidak diperbolehkan melihat hasil quiz');
            }
            if ($pesertaId != auth()->user()->id) {
                return abort(404);
            }
        }

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('frontend.course.quiz.jawaban', compact('data'), [
            'title' => 'Quiz - Jawaban',
            'breadcrumbsBackend' => [
                'Quiz' => route('course.bahan', [
                    'id' => $data['quiz']->mata_id,
                    'bahanId' => $data['quiz']->bahan_id,
                    'tipe' => 'quiz'
                ]),
                'Peserta' => route('quiz.peserta', ['id' => $quizId]),
                'Jawaban' => ''
            ],
        ]);
    }

    public function create($quizId)
    {
        $data['quiz'] = $this->service->findQuiz($quizId);

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('backend.course_management.bahan.quiz.form', compact('data'), [
            'title' => 'Quiz Item - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Modul Pelatihan' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Materi' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
                'Soal Quiz' => route('quiz.item', ['id' => $data['quiz']->id]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(QuizItemRequest $request, $quizId)
    {
        $this->service->storeItem($request, $quizId);

        return redirect()->route('quiz.item', ['id' => $quizId])
            ->with('success', 'Soal Quiz berhasil ditambahkan');
    }

    public function storeFromBank(Request $request, $quizId)
    {
        if ((bool)$request->random == 0 && $request->soal_id == null) {
            return back()->with('warning', 'soal harus dipilih');
        }

        if ((bool)$request->random == 1) {
            if (empty($request->jml_soal)) {
                return back()->with('warning', 'jumlah soal harus diisi');
            }
            if (!empty($request->jml_soal) && $request->kategori_id > 0) {
                $soal = $this->serviceSoal->getSoalByKategori($request->kategori_id)->count();
                if ($soal == 0) {
                    return back()->with('warning', 'jumlah soal dikategori yang dipilih kosong');
                }
                if ($request->jml_soal > $soal) {
                    return back()->with('warning', 'jumlah soal maksimal '.$soal);
                }
            }
        }

        $this->service->storeFromBank($request, $quizId);

        return back()->with('success', 'soal berhasil ditambahkan');

    }

    public function edit($quizId, $id)
    {
        $data['quiz_item'] = $this->service->findItem($id);
        $data['quiz'] = $this->service->findQuiz($quizId);

        $this->serviceBahan->checkInstruktur($data['quiz']->materi_id);

        return view('backend.course_management.bahan.quiz.form-edit', compact('data'), [
            'title' => 'Quiz Item - Edit',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Modul Pelatihan' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Materi' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
                'Soal Quiz' => route('quiz.item', ['id' => $data['quiz']->id]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(QuizItemRequest $request, $quizId, $id)
    {
        $this->service->updateItem($request, $id);

        return redirect()->route('quiz.item', ['id' => $quizId])
            ->with('success', 'Soal Quiz berhasil diedit');
    }

    public function trackJawaban(Request $request, $quizId)
    {

        $this->service->trackJawaban($request, $quizId);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function finishQuiz(Request $request, $quizId)
    {
        // dd( auth()->user()->id);
        $quiz = $this->service->findQuiz($quizId);
        $nilaiQuiz = $quiz->trackItem->where('user_id', auth()->user()->id);
        if($nilaiQuiz->count() > 0)
        {
            $grade = round(($nilaiQuiz->where('benar', 1)->count() / $nilaiQuiz->count()) * 100);
        }
        
        if($grade > 70)
        {
            $lulus =1;
        }else{
            $lulus =0;
        }
        
        $this->serviceQuiz->trackUserOut($quizId, $lulus);
        
        if ($quiz->bahan->completion_type == 4 ) {

            $this->serviceActivity->complete($quiz->bahan_id);
        }

        if ($request->button == 'yes') {
            return redirect()->route('course.bahan', [
                'id' => $quiz->mata_id, 'bahanId' => $quiz->bahan_id, 'tipe' => 'quiz'
                ])->with('success', 'Quiz telah selesai');
        } else {
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
        }
    }

    public function checkEssay($itemId, $status)
    {
        $this->service->cekEssay($itemId, $status);

        return back();
    }

    public function checkPeserta($quizId, $userId, $id)
    {
        $quiz = $this->service->findQuiz($quizId);

        $this->serviceQuiz->cekPeserta($id);
        if ($quiz->bahan->completion_type == 5) {
            $this->serviceActivity->completeCheckQuiz($quiz->bahan_id, $userId);
        }

        return back();
    }

    public function ulangi($quizId, $pesertaId)
    {
        $ulangi = $this->service->ulangi($quizId, $pesertaId);

        if ($ulangi == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'anda tidak bisa mengulangi quiz karena jawaban sudah dicek pengajar'
            ], 200);
        }
    }

    public function exportJawaban($quizId)
    {
        $quiz = $this->service->findQuiz($quizId);;
        $peserta = $this->serviceQuiz->quizPesertaExport($quizId);
        return Excel::download(new QuizExport($quiz, $peserta), "data-quiz-{$quiz->bahan->judul}.xlsx");
    }

    public function destroy($quizId, $id)
    {
        $this->service->deleteItem($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function destroyCheck(Request $request, $quizId)
    {
        $this->service->deleteChecked($request->id, $quizId);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
