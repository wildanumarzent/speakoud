<?php

namespace App\Services\LearningCompetency;
use App\Models\Journey\Journey;
use App\Models\Journey\JourneyKompetensi;
use App\Models\Journey\JourneyPeserta;
use App\Models\Kompetensi\Kompetensi;
use App\Models\Kompetensi\KompetensiPeserta;

class JourneyService
{
    private $model;

    public function __construct(Journey $model,JourneyKompetensi $journeyKompetensi,JourneyPeserta $journeyPeserta,Kompetensi $kompetensi , KompetensiPeserta $kompetensiPeserta)
    {
        $this->model = $model;
        $this->kompetensi = $kompetensi;
        $this->kompetensiP = $kompetensiPeserta;
        $this->journeyK = $journeyKompetensi;
        $this->journeyP = $journeyPeserta;
    }

    public function list($request){
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'ilike', '%'.$q.'%');
            });
        });

        if(isset($request['p'])){
            switch ($request['p']) {
                case 'owned':
                    $query->whereHas('journeyPeserta', function($q) {
                        $q->where('status',1);
                    });
                    break;
                 case 'potential':

                    $query->whereHas('journeyKompetensi', function($q) {
                        $q->whereHas('kompetensiPeserta', function($p) {
                            $p->where('peserta_id','=',auth()->user()->peserta->id);
                            $p->where('poin','>',0);
                        });
                    });
                    break;
                 case 'notPotential':
                    $query->whereHas('journeyKompetensi', function($q) {
                        $q->whereHas('kompetensiPeserta', function($p){
                            $p->where('peserta_id','!=',auth()->user()->peserta->id);
                        });
                    });
                    break;
                     case 'progress':
                        $query->whereHas('journeyPeserta', function($q) {
                            $q->where('status',0);
                        });
                    break;

                default:
                    # code...
                    break;
            }
        }


        $result = $query->orderBy('created_at', 'DESC')->paginate(10);

        return $result;

    }



    public function countJourney($pesertaID){
        $data = $this->journeyP->query();
        $data->where('peserta_id',$pesertaID);
        $data->where('status',1);
        $result = $data->count();
        return $result;
    }
    public function getTotalPoint(){
        $data = $this->journeyK->query();
        $data->with('journeyPeserta');
        $result = $data->get();
        return $result;
    }

    public function get($id){
        $query = $this->model->query();
        $query->where('id',$id);
        $result = $query->first();
        return $result;
     }
     public function getLinked($id){
        $query = $this->journeyK->query();
        $query->where('id',$id);
        $result = $query->first();
        return $result;
     }

     public function listJourneyKompetensi($kompetensiId = null,$journeyId = null){
        $query = $this->journeyK->query();
        if(isset($kompetensiId)){
            $query->where('kompetensi_id',$kompetensiId);
        }
        if(isset($journeyId)){
            $query->where('journey_id',$journeyId);
        }
        $result = $query->get();
        return $result;
     }

     public function listJourneyPeserta($request,$pesertaID){
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'ilike', '%'.$q.'%');
            });
        });
        $query->whereHas('journeyKompetensi', function($q) use($pesertaID) {
            $q->whereHas('kompetensiPeserta', function($p) use($pesertaID) {
                $p->where('peserta_id','=',$pesertaID);
                $p->where('poin','>',0);
            });
        });


        $result = $query->orderBy('created_at', 'DESC')->with('journeyPeserta')->paginate(10);

        return $result;
     }

     public function assign($pesertaId,$request,$status = 0){
         $query = new JourneyPeserta;
         $data = $request->all();
         if(isset($request->status) && $request->status == 0){
             $status = 1;
         }
         $query->updateOrCreate(
             ['peserta_id' => $pesertaId,'journey_id' => $request->journey_id],
             ['status' => $status],
         );

     }
     public function getAssign($pesertaId){
        $query = $this->journeyP->query();
        $query->where('peserta_id',$pesertaId);
        $result = $query->get();
        return $result;
     }



    public function store($request){
        $data = $request;
        Journey::create($data);
        return true;
    }


    public function update($id,$request){
       $data = $request->validated();
       $query = $this->get($id);
        $query->update($data);
        return $query;
    }
    public function delete($id){
        $query = $this->get($id);
        $query->delete();
        return true;
    }

    public function link($request){
        $data = $request;
        $query = new JourneyKompetensi;
        $query->updateOrCreate(
            ['kompetensi_id' => $data['kompetensi_id'],
             'journey_id' => $data['journey_id']
            ],
            $request
        );
        return true;
    }

    public function updateLink($id,$request){
        $data = $request->validated();
        $query = $this->getLinked($id);
         $query->update($data);
         return $query;
    }
    public function unlink($id){
        $query = $this->getLinked($id);
        $query->delete();
        return true;
    }
}
