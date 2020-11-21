<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\Tags;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ArtikelService;
use App\Services\Component\TagsService;

class TagsController extends Controller
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

        $data['tags'] = $this->tags->list($request);
        $data['number'] = $data['tags']->firstItem();
        $data['tags']->withPath(url()->current().$q);
        return view('backend.tags.index', compact('data'), [
            'title' => 'Tags',
            'breadcrumbsBackend' => [
                'Tags' => '',
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
     * @param  \App\Models\Component\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show(Tags $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Component\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit(Tags $tags)
    {
        $data['tags'] = $tags;
        return view('backend.tags.form', compact('data'), [
            'title' => 'Tags',
            'breadcrumbsBackend' => [
                'Tags' => route('tags.index'),
                'Edit' => ''
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $this->tags->update($request);
        return redirect()->route('tags.index')->with('success', 'Tags Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->tags->destroy($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
