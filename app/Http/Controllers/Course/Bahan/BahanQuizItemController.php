<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizItemRequest;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Services\Course\Bahan\BahanQuizItemService;
use App\Services\Course\Bahan\BahanQuizService;
use Illuminate\Http\Request;

class BahanQuizItemController extends Controller
{
    private $service;

    public function __construct(BahanQuizItemService $service)
    {
        $this->service = $service;
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
        $data['number'] = $data['quiz_item']->firstItem();
        $data['quiz_item']->withPath(url()->current().$t.$q);
        $data['quiz'] = $this->service->findQuiz($quizId);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($data['quiz']->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }

        return view('backend.course_management.bahan.quiz.index', compact('data'), [
            'title' => 'Bahan Pelatihan - Quiz Item',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
                'Soal Quiz' => '',
            ],
        ]);
    }

    public function create($quizId)
    {
        $data['quiz'] = $this->service->findQuiz($quizId);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($data['quiz']->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }

        return view('backend.course_management.bahan.quiz.form', compact('data'), [
            'title' => 'Quiz Item - Tambah',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
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

    public function edit($quizId, $id)
    {
        $data['quiz_item'] = $this->service->findItem($id);
        $data['quiz'] = $this->service->findQuiz($quizId);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            if ($data['quiz']->creator_id != auth()->user()->id) {
                return abort(404);
            }
        }

        return view('backend.course_management.bahan.quiz.form-edit', compact('data'), [
            'title' => 'Quiz Item - Edit',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['quiz']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['quiz']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['quiz']->materi_id]),
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

    public function destroy($quizId, $id)
    {
        $this->service->deleteItem($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
