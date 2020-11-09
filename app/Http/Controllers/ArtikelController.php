<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use App\Services\ArtikelService;
use App\Services\Component\TagsService;
class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $artikel, $tags;

    public function __construct(ArtikelService $artikel,TagsService $tags)
    {
        $this->artikel = $artikel;
        $this->tags = $tags;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['artikel'] = $this->artikel->list($request);
        $data['number'] = $data['artikel']->firstItem();
        $data['artikel']->withPath(url()->current().$q);
        return view('backend.artikel.index', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsBackend' => [
                'Artikel' => '',
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
        $data['mode'] = 'create';
        return view('backend.artikel.form', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsBackend' => [
                'Artikel' => route('artikel.index'),
                'Create' => '',
            ],
        ]);
    }
    public function edit(Artikel $id)
    {
        $data['mode'] = 'edit';
        $data['artikel'] = $this->artikel->get($id['id']);
        return view('backend.artikel.form', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsBackend' => [
                'Artikel' => route('artikel.index'),
                'Edit' => '',
            ],
        ]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->mode == 'edit'){
            $this->artikel->update($request);
        }else{
            $this->artikel->save($request);
        }
        return redirect()->route('artikel.index')
        ->with('success', 'Artikel Telah Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function show(Artikel $id)
    {
        $this->artikel->viewer($id['id']);  
        $data['artikel'] = $this->artikel->get($id['id']);
        return view('backend.artikel.detail', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsBackend' => [
                'Artikel' => route('artikel.index'),
                $id['title'] => '',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artikel $artikel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->artikel->delete($id);
        return redirect()->route('artikel.index')
        ->with('success', 'Artikel Telah Dihapus');
    }
}
