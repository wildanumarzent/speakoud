<?php

namespace App\Http\Controllers\Course\Log;

use App\Models\Course\Bahan\ActivityCompletion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MateriService;
use App\Services\Users\PesertaService;

class ActivityTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $bahan,$peserta;
    public function __construct(BahanService $bahan, PesertaService $peserta,MateriService $materi)
    {
        $this->peserta = $peserta;
        $this->bahan = $bahan;
        $this->materi = $materi;
    }

    public function index(Request $request,$materiId)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }
        $data['peserta'] = $this->peserta->getPesertaList($request);
        $data['number'] = $data['peserta']->firstItem();
        $data['peserta']->withPath(url()->current().$q);
        $data['materi'] = $this->materi->findMateri($materiId);
        $data['bahan'] = $this->bahan->getBahanList(null,$materiId);
        $data['track'] = ActivityCompletion::where('materi_id',$materiId)->get();
        return view('backend.report.activity_report.index', compact('data'), [
            'title' => 'Activity Report',
            'breadcrumbsBackend' => [
                $data['materi']->judul => route('bahan.index', ['id' => $data['materi']->id]),
            ],
        ]);
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
     * @param  \App\Models\Course\Track\ActivityTrack  $activityTrack
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityTrack $activityTrack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course\Track\ActivityTrack  $activityTrack
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityTrack $activityTrack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course\Track\ActivityTrack  $activityTrack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityTrack $activityTrack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Track\ActivityTrack  $activityTrack
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityTrack $activityTrack)
    {
        //
    }
}
