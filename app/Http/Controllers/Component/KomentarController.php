<?php

namespace App\Http\Controllers\Component;

use App\Models\Component\Komentar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Component\KomentarService;

class KomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(KomentarService $komentar)
     {
        $this->komentar = $komentar;
     }
    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['komentar'] = $this->komentar->list($request);
        $data['number'] = $data['komentar']->firstItem();
        $data['komentar']->withPath(url()->current().$q);

        return view('backend.komentar.index', compact('data'), [
            'title' => 'Komentar',
            'breadcrumbsBackend' => [
                'Komentar' => '',
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
     * @param  \App\Models\Component\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function show(Komentar $komentar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Component\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function edit(Komentar $komentar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komentar $komentar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->komentar->destroy($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
