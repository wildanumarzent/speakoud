<?php

namespace App\Services\Component;

use App\Models\Artikel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class TagsService
{
    private $model;

    public function __construct(Artikel $model)
    {
        $this->model = $model;
    }

    public function get($data){
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

        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;

    }

    public function save(){
        $this->model->create([
        'title' => 'Mengisi field created_by dan updated_by otomatis',
        'slug' => 'Implementasi blameable behaviour pada eloquent model',
        'publish' => 1,
        ]);
        return true;
    }

    public function delete(){

    }

    public function draft(){

    }

    public function viewAdd(){

    }



}
