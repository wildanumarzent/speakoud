<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\Component\KomentarService;
use App\Models\Component\Komentar;
class KomentarForm extends Component
{




    public $comentdata,$model,$list;
    protected $komentar;

    protected $listeners = [
        'stored',
    ];

    public function mount(KomentarService $komentar,$model)
    {
        $this->komentar = $komentar;
        $this->model = $model;
    }


    public function render()
    {
        $this->list =  $this->komentar->getKomentar($this->model);
        return view('livewire.komentar-form');
    }


}
