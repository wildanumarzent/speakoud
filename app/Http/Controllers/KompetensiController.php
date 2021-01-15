<?php

namespace App\Http\Controllers;

use App\Http\Requests\KompetensiRequest;
use App\Models\Kompetensi\Kompetensi;
use App\Services\LearningCompetency\KompetensiService;
use Illuminate\Http\Request;
use App\Services\Course\MataService;
class KompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(KompetensiService $kompetensi,MataService $mata){
        $this->kompetensi = $kompetensi;
        $this->mata = $mata;
     }
    public function index(Request $request)
    {
        $p = '';
        $q = '';
        $data['mata'] = $this->mata->getAllMata();
        $data['listMata'] = $this->kompetensi->listKompetensiMata();
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['kompetensi'] = $this->kompetensi->list($request);
        $data['number'] = $data['kompetensi']->firstItem();
        $data['kompetensi']->withPath(url()->current().$p.$q);

        return view('backend.kompetensi.index', compact('data'), [
            'title' => 'Kompetensi',
            'breadcrumbsBackend' => [
                'Kompetensi' => ''
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
        $data = [];
        return view('backend.kompetensi.form', compact('data'), [
            'title' => 'Kompetensi',
            'breadcrumbsBackend' => [
                'Kompetensi' => route('kompetensi.index'),
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
    public function store(KompetensiRequest $request)
    {
        $data['kompetensi'] = $request->validated();
        $this->kompetensi->store($data['kompetensi']);
        return redirect()->route('kompetensi.index')->with('success' , 'Kompetensi Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function show(Kompetensi $kompetensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kompetensi $kompetensi)
    {
        $data['kompetensi'] = $kompetensi;
        return view('backend.kompetensi.form', compact('data'), [
            'title' => 'Kompetensi',
            'breadcrumbsBackend' => [
                'Kompetensi' => route('kompetensi.index'),
                'Edit' => ''
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kompetensi  $kompetensi
     * @return \Illuminate\Http\Response
     */
    public function update(KompetensiRequest $request, $id)
    {
        $data = $this->kompetensi->update($id,$request);

        return redirect()->route('kompetensi.index')->with('success' , 'Kompetensi Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->kompetensi->delete($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
