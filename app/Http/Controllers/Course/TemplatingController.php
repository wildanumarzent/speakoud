<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\MataInstrukturRequest;
use App\Http\Requests\MataRequest;
use App\Http\Requests\SetInstrukturRequest;
use App\Services\Course\EvaluasiService;
use App\Services\Course\MataService;
use App\Services\Course\ProgramService;
use App\Services\Course\Template\TemplateMataService;
use App\Services\Course\TemplatingService;
use App\Services\Users\InstrukturService;
use Illuminate\Http\Request;

class TemplatingController extends Controller
{
    private $service, $serviceTMata, $serviceProgram, $serviceMata, $serviceEvaluasi,
        $serviceInstruktur;

    public function __construct(
        TemplatingService $service,
        TemplateMataService $serviceTMata,
        ProgramService $serviceProgram,
        MataService $serviceMata,
        EvaluasiService $serviceEvaluasi,
        InstrukturService $serviceInstruktur
    )
    {
        $this->service = $service;
        $this->serviceTMata = $serviceTMata;
        $this->serviceProgram = $serviceProgram;
        $this->serviceMata = $serviceMata;
        $this->serviceEvaluasi = $serviceEvaluasi;
        $this->serviceInstruktur = $serviceInstruktur;
    }

    public function copyAsTemplate($mataId)
    {
        $check = $this->service->copyAsTemplate($mataId);

        if ($check == true) {
           return back()->with('success', 'Berhasil mengcopy program ke template');
        } else {
            return back()->with('failed', 'Program harus memiliki Mata & Bahan terlebih dahulu');
        }
    }

    public function createMata($programId, $templateId)
    {
        $data['program'] = $this->serviceProgram->findProgram($programId);
        $data['tMata'] = $this->serviceTMata->findTemplateMata($templateId);

        return view('backend.course_management.mata.template.form-mata', compact('data'), [
            'title' => 'Program Pelatihan - Template - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $programId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function storeMata(MataRequest $request, $programId, $templateId)
    {
        if (!empty($request->kode_evaluasi)) {
            $cekApi = $this->serviceEvaluasi->preview($request->kode_evaluasi);
            if ($cekApi->success == false) {
                return back()->with('warning', $cekApi->error_message[0]);
            }
        }

        $bobot = ($request->join_vidconf + $request->activity_completion +
            $request->forum_diskusi + $request->webinar + $request->progress_test +
            $request->quiz + $request->post_test);

        if ($bobot < 100 || $bobot > 100) {
            return back()->with('warning', 'Bobot nilai harus memiliki jumlah keseluruhan 100%, tidak boleh kurang / lebih');
        }

        $mata = $this->serviceMata->storeMata($request, $programId, $templateId);
        $this->service->copyBankSoal($mata->id, $templateId);

        return redirect()->route('enroll.create.template', ['id' => $mata->id, 'templateId' => $templateId])
            ->with('success', 'Program pelatihan berhasil ditambahkan');
    }

    public function createEnroll(Request $request, $mataId, $templateId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['tMata'] = $this->serviceTMata->findTemplateMata($templateId);

        $collectInstruktur = collect($data['mata']->instruktur);
        $data['instruktur_id'] = $collectInstruktur->map(function($item, $key) {
            return $item->instruktur_id;
        })->all();
        $data['instruktur_list'] = $this->serviceInstruktur
            ->getInstrukturForMata($data['mata']->program->tipe, $data['instruktur_id']);

        if ($data['mata']->instruktur->count() > 0) {
            return abort(404);
        }

        return view('backend.course_management.mata.template.form-enroll', compact('data'), [
            'title' => 'Enroll - Template - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Enroll' => '',
                'Tambah' => ''
            ],
        ]);
    }

    public function storeEnroll(MataInstrukturRequest $request, $mataId, $templateId)
    {
        $this->serviceMata->storeInstruktur($request, $mataId);

        return redirect()->route('materi.create.template', ['id' => $mataId, 'templateId' => $templateId])
            ->with('success', 'Instruktur berhasil ditambahkan');
    }

    public function createMateri(Request $request, $mataId, $templateId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);
        $data['tMata'] = $this->serviceTMata->findTemplateMata($templateId);
        $data['instruktur'] = $this->serviceMata->getInstrukturList($request, $mataId);

        if ($data['mata']->materi->count() > 0) {
            return abort(404);
        }

        return view('backend.course_management.mata.template.form-materi', compact('data'), [
            'title' => 'Materi - Template - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program Pelatihan' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Materi' => '',
                'Tambah' => ''
            ],
        ]);
    }

    public function storeMateri(SetInstrukturRequest $request, $mataId, $templateId)
    {
        $data['mata'] = $this->serviceMata->findMata($mataId);

        $this->service->copyMateri($request, $mataId, $templateId);

        return redirect()->route('mata.index', ['id' => $data['mata']->program_id])
            ->with('success', 'Program pelatihan dari template berhasil ditambahkan');
    }
}
