<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use App\Models\Component\Announcement;
use Illuminate\Http\Request;
use App\Services\Component\AnnouncementService;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(AnnouncementService $announcement)
    {
       $this->announcement = $announcement;
    }
   public function index(Request $request)
   {
       $q = '';
       if (isset($request->q)) {
           $q = '?q='.$request->q;
       }

       $data['announcement'] = $this->announcement->annoList($request);
       $data['number'] = $data['announcement']->firstItem();
       $data['announcement']->withPath(url()->current().$q);

       return view('backend.announcement.index', compact('data'), [
           'title' => 'Announcement',
           'breadcrumbsBackend' => [
               'Announcement' => '',
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
        return view('backend.announcement.form', compact('data'), [
            'title' => 'Announcement',
            'breadcrumbsBackend' => [
                'Announcement' => route('announcement.index'),
                'Create' => '',
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
        $this->announcement->annoStore($request);
        return redirect()->route('announcement.index')->with('success', 'Announcement berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        $data['announcement'] = $announcement;
        if($announcement->status == 0){
            return redirect()->back();
        }
        return view('backend.announcement.detail', compact('data'), [
            'title' => 'Announcement',
            'breadcrumbsBackend' => [
                'Announcement' => route('announcement.index'),
                'Edit' => '',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        $data['announcement'] = $announcement;
        return view('backend.announcement.form', compact('data'), [
            'title' => 'Announcement',
            'breadcrumbsBackend' => [
                'Announcement' => route('announcement.index'),
                'Edit' => '',
            ],
        ]);
    }

    public function publish($id){
        $this->announcement->publish($id);
        return back()->with('success', 'Status berhasil diubah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $this->announcement->annoUpdate($request,$request['id']);
        return redirect()->route('announcement.index')->with('success', 'Announcement berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->announcement->annoDestroy($id);
        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}