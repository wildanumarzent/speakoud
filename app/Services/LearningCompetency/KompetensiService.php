<?php

namespace App\Services\LearningCompetency;

use App\Models\Course\MataPelatihan;
use App\Models\Journey\JourneyPeserta;
use App\Models\Kompetensi\Kompetensi;
use App\Models\Kompetensi\KompetensiMata;
use App\Models\Kompetensi\KompetensiPeserta;
use App\Models\Course\MataPeserta;
class KompetensiService
{
    private $model;

    public function __construct(Kompetensi $model,KompetensiMata $kompetensiMata,KompetensiPeserta $kompetensiPeserta, JourneyPeserta $journeyPeserta,MataPelatihan $mata)
    {
        $this->model = $model;
        $this->kMata = $kompetensiMata;
        $this->kPeserta = $kompetensiPeserta;
        $this->jPeserta = $journeyPeserta;
        $this->mata = $mata;
    }

    public function list($request = null){
        $query = $this->model->query();
        if(isset($request->q)){
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'ilike', '%'.$q.'%');
            });
        });
        }

        if (isset($request->p)) {
            $mata = $this->kMata->query();
            $mata->where('mata_id',$request->p);
            $kompetensiId = $mata->pluck('kompetensi_id');
            if($request->p == 'null'){
            $query->whereNotIn('id',$kompetensiId);
            }else{
            $query->whereIn('id',$kompetensiId);
            }
        }



        $result = $query->orderBy('created_at', 'DESC')->paginate(10);

        return $result;

    }

    public function getRekomendasiMata($pesertaID){

        // dd($pesertaID);
        $query = $this->mata->query();
        $query->publish();
        $query->with('kompetensiMata');
        $query->whereDoesntHave('peserta', function($q) use($pesertaID) {
            $q->where('id','!=',$pesertaID);
        });
        // dd($test);
        // $query->whereHas('kompetensiMata', function($q) use($pesertaID) {
        //     $q->whereHas('kompetensiPeserta', function($p) use($pesertaID) {
        //         $p->where('peserta_id','=',$pesertaID);
        //     });
        // });

        $result = $query->get();
        return $result;
        }

    public function getKompetensiMata(){
        $query = $this->kMata->query();
        $result = $query->get();
        return $result;
    }
    public function listAll(){
        $query = $this->model->query();
        $result = $query->orderBy('created_at', 'DESC')->get();
        return $result;
    }

    public function getPoint($id = null){
        $query = $this->kPeserta->query();
        if(isset($id)){
            $query->where('peserta_id',$id);
        }
        $result = $query->get();
        return $result;
    }
    public function get($id){
        $query = $this->model->query();
        $query->where('id',$id);
        $result = $query->first();
        return $result;
     }
     public function listKompetensiMata($kompetensiId = null,$mataId = null){
        $query = $this->kMata->query();
        if(isset($mataId)){
            $query->where('mata_id',$mataId);
        }
        if(isset($kompetensiId)){
            $query->where('kompetensi_id',$kompetensiId);
        }
        $result = $query->get();
        return $result;
     }

    public function store($request){
        $data = $request;
        Kompetensi::create($data);
        return true;
    }

    public function storeKompetensiMata($kompetensiId = [],$mataId){
        $this->deleteKompetensiMata($mataId);
        if(!empty($kompetensiId)){
        foreach($kompetensiId as $id){
            KompetensiMata::updateOrCreate(
                ['kompetensi_id' => $id, 'mata_id' => $mataId],
                ['kompetensi_id' => $id, 'mata_id' => $mataId]
            );
        }
        }
        return true;
    }

    public function deleteKompetensiMata($mataId){
        $data = KompetensiMata::where('mata_id',$mataId);
        $data->delete();
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
}
