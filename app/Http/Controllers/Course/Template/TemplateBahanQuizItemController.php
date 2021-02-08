<?php

namespace App\Http\Controllers\Course\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizItemRequest;
use App\Services\Course\Template\TemplateBahanQuizItemService;
use App\Services\Course\Template\TemplateBahanQuizService;
use App\Services\Course\Template\TemplateBahanService;
use App\Services\Course\Template\TemplateSoalKategoriService;
use App\Services\Course\Template\TemplateSoalService;
use Illuminate\Http\Request;

class TemplateBahanQuizItemController extends Controller
{
    private $service, $serviceBahan, $serviceQuiz, $serviceSoalKategori, $serviceSoal;

    public function __construct(
        TemplateBahanQuizItemService $service,
        TemplateBahanService $serviceBahan,
        TemplateBahanQuizService $serviceQuiz,
        TemplateSoalKategoriService $serviceSoalKategori,
        TemplateSoalService $serviceSoal
    )
    {
        $this->service = $service;
        $this->serviceBahan = $serviceBahan;
        $this->serviceQuiz = $serviceQuiz;
        $this->serviceSoalKategori = $serviceSoalKategori;
        $this->serviceSoal = $serviceSoal;
    }

    public function index(Request $request, $quizId)
    {
        $t = '';
        $q = '';
        if (isset($request->t) || isset($request->q)) {
            $t = '?t='.$request->t;
            $q = '&q='.$request->q;
        }

        $data['quiz_item'] = $this->service->getTemplateItemList($request, $quizId);
        $data['number'] = $data['quiz_item']->firstItem();
        $data['quiz_item']->withPath(url()->current().$t.$q);
        $data['quiz'] = $this->serviceQuiz->findTemplateQuiz($quizId);

        $data['soal_kategori'] = $this->serviceSoalKategori->getTemplateSoalKategori($data['quiz']->template_mata_id);
        $soal = null;
        if ($data['quiz_item']->total() > 0) {
            $collectSoal = collect($this->service->getTemplateItem($quizId));
            $soal = $collectSoal->map(function($item, $key) {
                return $item->pertanyaan;
            })->all();
        }
        $data['soal'] = $this->serviceSoal->getTemplateSoalByMata($data['quiz']->template_mata_id, $soal);

        return view('backend.course_management.template.bahan.quiz.index', compact('data'), [
            'title' => 'Template - Bahan Pelatihan - Quiz Item',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['quiz']->template_mata_id]),
                'Materi' => route('template.bahan.index', ['id' => $data['quiz']->template_materi_id]),
                'Soal Quiz' => '',
            ],
        ]);
    }

    public function create($quizId)
    {
        $data['quiz'] = $this->serviceQuiz->findTemplateQuiz($quizId);

        return view('backend.course_management.template.bahan.quiz.form', compact('data'), [
            'title' => 'Template - Quiz Item - Tambah',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['quiz']->template_mata_id]),
                'Materi' => route('template.bahan.index', ['id' => $data['quiz']->template_materi_id]),
                'Soal Quiz' => route('template.quiz.item', ['id' => $data['quiz']->id]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(QuizItemRequest $request, $quizId)
    {
        $this->service->storeTemplateItem($request, $quizId);

        return redirect()->route('template.quiz.item', ['id' => $quizId])
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
                $soal = $this->serviceSoal->getTemplateSoalByKategori($request->kategori_id)->count();
                if ($soal == 0) {
                    return back()->with('warning', 'jumlah soal dikategori yang dipilih kosong');
                }
                if ($request->jml_soal > $soal) {
                    return back()->with('warning', 'jumlah soal maksimal '.$soal);
                }
            }
        }

        $this->service->storeTemplateFromBank($request, $quizId);

        return back()->with('success', 'soal berhasil ditambahkan');

    }

    public function edit($quizId, $id)
    {
        $data['quiz_item'] = $this->service->findTemplateItem($id);
        $data['quiz'] = $this->serviceQuiz->findTemplateQuiz($quizId);

        return view('backend.course_management.template.bahan.quiz.form-edit', compact('data'), [
            'title' => 'Quiz Item - Edit',
            'breadcrumbsBackend' => [
                'Template' => '',
                'Program' => route('template.mata.index'),
                'Mata' => route('template.materi.index', ['id' => $data['quiz']->template_mata_id]),
                'Materi' => route('template.bahan.index', ['id' => $data['quiz']->template_materi_id]),
                'Soal Quiz' => route('template.quiz.item', ['id' => $data['quiz']->id]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(QuizItemRequest $request, $quizId, $id)
    {
        $this->service->updateTemplateItem($request, $id);

        return redirect()->route('template.quiz.item', ['id' => $quizId])
            ->with('success', 'Soal Quiz berhasil diedit');
    }

    public function destroy($quizId, $id)
    {
        $this->service->deleteTemplateItem($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
