<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Services\LogService;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(LogService $log)
    {
       $this->log = $log;
    }

    public function index(Request $request)
    {
        $q = '';
        $data['type'] = 'date';
        $data['date'] = Carbon::now()->format('Y-m-d');
        if (isset($request->q)) {
            $q = '?q='.$request->q;
            $data['date'] = $request->q;
            $data['type'] = 'time';
        }

        $data['log'] = $this->log->list($request);
        $data['number'] = $data['log']->firstItem();
        $data['log']->withPath(url()->current().$q);


        return view('backend.log.index', compact('data'), [
            'title' => 'Logs',
            'breadcrumbsBackend' => [
                'Logs' => '',
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
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
