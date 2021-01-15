<?php

namespace App\Http\Controllers;

use App\Http\Requests\JourneyRequest;
use App\Models\Journey\Journey;
use App\Services\LearningCompetency\JourneyService;
use Illuminate\Http\Request;
use App\Services\Course\MataService;
use App\Services\LearningCompetency\KompetensiService;
use App\Services\Users\PesertaService;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(JourneyService $journey,MataService $mata,KompetensiService $kompetensi,PesertaService $peserta){
        $this->journey = $journey;
        $this->mata = $mata;
        $this->kompetensi = $kompetensi;
        $this->peserta = $peserta;
     }
    public function index(Request $request)
    {
        $p = '';
        $q = '';
        $data['mata'] = $this->mata->getAllMata();
        $data['listKompetensi'] = $this->journey->listJourneyKompetensi();
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
        $data['poinKu'] = $this->kompetensi->getPoint(auth()->user()->peserta->id);
        $data['totalPoint'] = $this->journey->getTotalPoint();
        $data['assigned'] = $this->journey->getAssign(auth()->user()->peserta->id);
        // return $data['totalPoint']->where('journey_id',4)->sum('minimal_poin');
        }
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }
        $data['journey'] = $this->journey->list($request);
        $data['number'] = $data['journey']->firstItem();
        $data['journey']->withPath(url()->current().$p.$q);

        return view('backend.journey.index', compact('data'), [
            'title' => 'Journey',
            'breadcrumbsBackend' => [
                'Journey' => ''
            ],
        ]);

    }

    public function peserta(Request $request , $pesertaID)
    {
        $p = '';
        $q = '';
        $data['mata'] = $this->mata->getAllMata();
        $data['listKompetensi'] = $this->journey->listJourneyKompetensi();

        $data['poinKu'] = $this->kompetensi->getPoint($pesertaID);
        $data['totalPoint'] = $this->journey->getTotalPoint();
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['journey'] = $this->journey->listJourneyPeserta($request,$pesertaID);

        $data['number'] = $data['journey']->firstItem();
        $data['journey']->withPath(url()->current().$p.$q);
        $data['pesertaId'] = $pesertaID;
        $data['assigned'] = $this->journey->getAssign($pesertaID);
        $peserta = $this->peserta->findPeserta($pesertaID);
        $data['peserta'] = $peserta->first();
        return view('backend.journey.peserta', compact('data'), [
            'title' => 'Journey',
            'breadcrumbsBackend' => [
                'Peserta' => route('peserta.index'),
                'Journey' => ''
            ],
        ]);

    }
    public function assign(Request $request,$pesertaID){
        $data =$this->journey->assign($pesertaID,$request);
        return redirect()->back()->with('success' , 'Journey Berhasil Diassign');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kompetensi'] = $this->kompetensi->list();
        return view('backend.journey.form', compact('data'), [
            'title' => 'Journey',
            'breadcrumbsBackend' => [
                'Journey' => route('journey.index'),
                'Tambah' => ''
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JourneyRequest $request)
    {
        $data['journey'] = $request->validated();
        $this->journey->store($data['journey']);
        return redirect()->route('journey.index')->with('success' , 'Journey Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function show(Journey $journey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function edit(Journey $journey)
    {
        $data['journey'] = $journey;
        return view('backend.journey.form', compact('data'), [
            'title' => 'Journey',
            'breadcrumbsBackend' => [
                'Journey' => route('journey.index'),
                'Edit' => ''
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journey  $journey
     * @return \Illuminate\Http\Response
     */
    public function update(JourneyRequest $request, $id)
    {
        $data = $this->journey->update($id,$request);

        return redirect()->route('journey.index')->with('success' , 'Journey Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->journey->delete($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
