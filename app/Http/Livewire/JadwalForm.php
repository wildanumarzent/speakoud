<?php

namespace App\Http\Livewire;

use App\Models\Course\MataPelatihan;
use Livewire\Component;

class JadwalForm extends Component
{
    public $jadwal;
    public $mataP;
    public $mataId;
    public $mata;
    public $checked;
    public function mount($jadwal,$mataP){
        $this->jadwal = $jadwal;
        $this->mataP = $mataP;
        if(isset($this->jadwal->mata_id)){
        $this->mataId = $this->jadwal->mata_id;
        $this->checked = true;
        }
    }
    public function render()
    {

        if(!empty($this->mataId)){
           $this->mata = MataPelatihan::where('id',$this->mataId)->first();
           $this->dispatchBrowserEvent('clicked');
        }

        if($this->checked == false){
            $this->mata = null;
        }

        return view('livewire.jadwal-form');
    }
}
