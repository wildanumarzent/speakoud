<?php

namespace App\Http\Controllers\Course\Log;

use App\Models\Course\Bahan\ActivityCompletion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Course\Bahan\BahanService;
use App\Services\Course\MateriService;
use App\Services\Course\MataService;
use App\Services\Users\PesertaService;

class ActivityTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $bahan,$peserta;
    public function __construct(BahanService $bahan, PesertaService $peserta,MateriService $materi,MataService $mata)
    {
        $this->peserta = $peserta;
        $this->bahan = $bahan;
        $this->materi = $materi;
        $this->mata = $mata;
    }

    public function index(Request $request,$materiId)
    {
        $data['materi'] = $this->materi->findMateri($materiId);
        $data['bahan'] = $this->bahan->getBahanList(null,$materiId);
        $data['track'] = ActivityCompletion::where('materi_id',$materiId)->get();

        $data['mata'] = $this->mata->findMata($data['materi']->mata_id);
        $collectPeserta = collect($data['mata']->peserta);
        $data['peserta_id'] = $collectPeserta->map(function($item, $key) {
            return $item->peserta_id;
        })->all();
        $data['peserta'] = $this->peserta->getPesertaForMata($data['mata']->program->tipe, $data['peserta_id']);
        return view('backend.report.activity_report.index', compact('data'), [
            'title' => 'Activity Report',
            'breadcrumbsBackend' => [
                $data['materi']->judul => route('bahan.index', ['id' => $data['materi']->id]),
            ],
        ]);
    }

    public function publish($id)
    {
       $activity = ActivityCompletion::find($id);
       $status = (bool)$activity->status;
       $activity->status = 1;
       if($status == true){
        $activity->status = 0;
       }
       $activity->save();
       return redirect()->back()->with(['success' => 'data updated']);
    }

    public function submit($userId,$bahanId)
    {
        $bahan = $this->bahan->findBahan($bahanId);
        ActivityCompletion::create([
            'user_id' => $userId,
            'bahan_id' => $bahan->id,
            'mata_id' => $bahan->mata_id,
            'program_id' => $bahan->program_id,
            'materi_id' => $bahan->materi_id
        ]);
        return redirect()->back()->with(['success' => 'data updated']);
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
