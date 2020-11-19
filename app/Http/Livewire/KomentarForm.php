<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\Component\KomentarService;
use App\Models\Component\Komentar;
class KomentarForm extends Component
{




    public $comentdata,$model,$list;

    protected $listeners = [
        'stored',
    ];

    public function stored(){
        $this->comentdata = '';
    }

    public function mount(KomentarService $komentarService,$model)
    {
        $this->komentarService = $komentarService;
        $this->model = $model;


    }


    public function render()
    {
        $komentar = new Komentar;
        $model = $komentar->commentable()->associate($this->model);
        $list = Komentar::where('commentable_id',$model['commentable_id'])->where('commentable_type',$model['commentable_type'])->orderby('created_at','desc')->get();
        $this->list = $list;
        return view('livewire.komentar-form');
    }

    public function store()
    {
        $komentar = new Komentar;
        $model = $komentar->commentable()->associate($this->model);
        $query = Komentar::create([
            'komentar' => $this->comentdata,
            'commentable_type'=>$model['commentable_type'],
            'commentable_id'=>$model['commentable_id']
            ]);
            $this->emit('stored');


    }




}
