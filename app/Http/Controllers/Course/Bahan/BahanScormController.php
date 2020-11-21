<?php

namespace App\Http\Controllers\Course\Bahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Course\Bahan\BahanScormService;
use App\Models\Course\Bahan\BahanScorm;
class BahanScormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $scorm;

    public function __construct(BahanScormService $scorm)
    {
        $this->scorm = $scorm;
    }

    public function index()
    {

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['scorm'] = $this->scorm->get($id);
        // $data['path'] = storage_path($data['scorm']->package);
        $data['path'] = asset($data['scorm']->package);
        $data['path1'] = asset('scorm-sample/odading/scormdriver/indexAPI.html');
        $data['path2'] = asset('scorm-sample/golf/shared/launchpage.html');
        $data['path3'] = asset('scorm-sample/onetwo/shared/launchpage.html');
        return view('backend.course_management.bahan.scorm.detail', compact('data'), [
            'title' => 'Bahan Pelatihan - Scorm',
            'breadcrumbsBackend' => [
                'Program' => route('program.index'),
                'Mata' => route('mata.index', ['id' => $data['scorm']->program_id]),
                'Materi' => route('materi.index', ['id' => $data['scorm']->mata_id]),
                'Bahan' => route('bahan.index', ['id' => $data['scorm']->materi_id]),
                'Scorm - '. $data['scorm']->bahan->judul => '',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
