<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Redirect,Response;
use Alert;
use Carbon\Carbon;
use Spatie\CalendarLinks\Link;
use Illuminate\Support\Facades\Validator;
use App\Services\KalenderService;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(KalenderService $kalender)
     {
        $this->kalender = $kalender;
     }
    public function index()
    {
        $data = [];
        return view('backend.kalender.index', compact('data'), [
            'judul' => 'Kalender Diklat',
            'breadcrumbsBackend' => [
                'Kalender Diklat' => '',
            ],
        ]);
    }

    public function list(){
        $event = Event::latest()->get();
        return response()->json($event);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch($request->action) {


            case 'submit':
                $data = $request->except('action');
                $validator = Validator::make($data,[
                    'title' => 'required',
                    'start' => 'required',
                    'end' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',

                ]);

                if($validator->fails()){
                    Alert::error('Error !',$validator->messages()->first());
                    return redirect()->back();
                }else{
                    $data['event'] =  $request->except(['action','id','_token','start_time','end_time']);
                    $startD = $data['event']['start'];
                    $startT = $request['start_time'];
                    $endD = $data['event']['end'];
                    $endT = $request['end_time'];
                    $data['event']['allDay'] = 1;
                    $data['event']['start'] = date('Y-m-d H:i:s', strtotime("$startD $startT"));
                    $data['event']['end'] = date('Y-m-d H:i:s', strtotime("$endD $endT"));
                    if($request['id'] !=  null){

                        $event  = Event::query();
                        $event->find($request['id']);
                        $event->update($data['event'] );
                    }else{
                        Event::create(
                            $data['event']
                        );
                    }
                    Alert::success('Success','Sukses Menyimpan Event');
                }
            break;

            case 'destroy':
                Alert::success('Success','Sukses Menghapus Event');
                $event = Event::where('id',$request->id)->delete();
            break;
        }

        return redirect()->back();

    }


    public function update(Request $request)
    {
        $event  = Event::query();
        $event->where('id',$request->id)->first();
        $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        return Response::json($event);
    }


    public function destroy(Request $request)
    {


        return Response::json($event);
    }
}
