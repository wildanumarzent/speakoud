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

       $data['anno'] = $this->announcement->annoList($request);
       $data['number'] = $data['anno']->firstItem();
       $data['anno']->withPath(url()->current().$q);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
