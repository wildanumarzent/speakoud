<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\ActivityService;
use App\Services\Course\Bahan\BahanQuizItemService;
use App\Services\Course\MataService;
use Illuminate\Http\Request;

class MataActivityController extends Controller
{
    private $service, $serviceActivity, $serviceQuizItem;

    public function __construct(
        MataService $service,
        ActivityService $serviceActivity,
        BahanQuizItemService $serviceQuizItem
    )
    {
        $this->service = $service;
        $this->serviceActivity = $serviceActivity;
        $this->serviceQuizItem = $serviceQuizItem;
    }

    public function pembobotan(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['peserta'] = $this->service->getPesertaList($request, $mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['mata'] = $this->service->findMata($mataId);

        return view('backend.course_management.mata.activity.pembobotan', compact('data'), [
            'title' => 'Program - Pembobotan',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Pembobotan Nilai' => ''
            ],
        ]);
    }

    public function completion(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['mata'] = $this->service->findMata($mataId);
        $data['track'] = $this->serviceActivity->getActivityByMata($mataId);
        $data['peserta'] = $this->service->getPesertaList($request, $mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);

        return view('backend.course_management.mata.activity.completion', compact('data'), [
            'title' => 'Program - Activity Completion',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Activity Completion' => ''
            ],
        ]);
    }

    public function compare(Request $request, $mataId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['mata'] = $this->service->findMata($mataId);
        $data['peserta'] = $this->service->getPesertaList($request, $mataId);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['pre'] = $this->serviceQuizItem->nilaiTest($mataId, 1);
        $data['post'] = $this->serviceQuizItem->nilaiTest($mataId, 2);

        return view('backend.course_management.mata.activity.compare', compact('data'), [
            'title' => 'Program - Compare Test',
            'breadcrumbsBackend' => [
                'Kategori' => route('program.index'),
                'Program' => route('mata.index', ['id' => $data['mata']->program_id]),
                'Compare Test' => ''
            ],
        ]);
    }


    public function submitCompletion($bahanId, $userId)
    {
        $this->serviceActivity->completeByAdmin($bahanId, $userId);

        return back()->with('success', 'completion berhasil diselesaikan');
    }

    public function statusCompletion($id)
    {
        $this->serviceActivity->status($id);

        return back()->with('success', 'completion berhasil diubah');
    }
}
