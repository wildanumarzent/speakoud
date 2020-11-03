<?php

namespace App\Services;

use App\Models\Artikel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ArtikelService
{
    private $model;

    public function __construct(Artikel $model)
    {
        $this->model = $model;
    }

    public function list($data){
        $query = $this->model->query();

        $query->when($data->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nip', 'like', '%'.$q.'%')
                ->orWhere('unit_kerja', 'like', '%'.$q.'%')
                ->orWhere('kedeputian', 'like', '%'.$q.'%')
                ->orWhere('pangkat', 'like', '%'.$q.'%')
                ->orWhere('alamat', 'like', '%'.$q.'%');
            });
        });
        if (auth()->user()->hasRole('developer|administrator|internal') == false) {
            $query->where('created_by',auth()->user()->id);
        }

        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;

    }

    public function get($id){
      $query = $this->model->query();
      $query->where('id', $id)->first();
      $result = $query;
      $this->viewer($id);
      return $result;
    }

    public function save($data){
        $this->model->create([
        'title' => 'Mengisi field created_by dan updated_by otomatis',
        'slug' => 'Implementasi blameable behaviour pada eloquent model',
        'publish' => 1,
        ]);
        return true;
    }

    public function update($id,$data){

    }

    public function delete(){

    }

    public function draft(){

    }

    public function viewer($id){
    $query = $this->model->query;
    $query->find($id);
    $query->increment('viewer');
    return true;
    }

    public function middleware($id){
    $artikel = $this->get($id);
    if($artikel->created_by != auth()->user()->id){
    return false;
    }else{
    return true;
    }

    }



}
