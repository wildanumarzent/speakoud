<?php

namespace App\Http\Controllers;

use App\Http\Requests\JourneyKompetensiRequest;
use App\Models\Journey\JourneyKompetensi;
use App\Services\LearningCompetency\JourneyService;
use Illuminate\Http\Request;
use App\Services\Course\MataService;
use App\Services\LearningCompetency\KompetensiService;

class JourneyKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(JourneyService $journey,MataService $mata,KompetensiService $kompetensi){
        $this->journey = $journey;
        $this->mata = $mata;
        $this->kompetensi = $kompetensi;
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($journeyK)
    {
        $data['journeyID'] = $journeyK;
        $data['kompetensi'] = $this->kompetensi->list();
        return view('backend.journey.kompetensi.form', compact('data'), [
            'title' => 'Journey Kompetensi',
            'breadcrumbsBackend' => [
                'Journey' => route('journey.index'),
                'Kompetensi' =>route('kompetensi.index'),
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
    public function store(JourneyKompetensiRequest $request)
    {
        $data['journeyK'] = $request->validated();
        $this->journey->link($data['journeyK']);
        return redirect()->route('journey.index')->with('success' , 'Kompetensi Berhasil Dihubungkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JourneyKompetensi  $journey
     * @return \Illuminate\Http\Response
     */
    public function show(JourneyKompetensi $journey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JourneyKompetensi  $journey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kompetensi'] = $this->kompetensi->list();
        $data['journeyK'] = $this->journey->getLinked($id);
        return view('backend.journey.kompetensi.form', compact('data'), [
            'title' => 'Journey Kompetensi',
            'breadcrumbsBackend' => [
                'Journey' => route('journey.index'),
                'Kompetensi' =>route('kompetensi.index'),
                'Edit' => ''
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JourneyKompetensi  $journey
     * @return \Illuminate\Http\Response
     */
    public function update(JourneyKompetensiRequest $request, $id)
    {
        $data = $this->journey->updateLink($id,$request);

        return redirect()->route('journey.index')->with('success' , 'Kompetensi Berhasil Dihubungkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->journey->unlink($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
