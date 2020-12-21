<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;
use App\Models\Course\MataPelatihan;
use App\Models\Course\ProgramPelatihan;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;

class Program extends Component
{

    public $mata,$data,$max,$min;
    public function mount(MataPelatihan $mata,ProgramPelatihan $program){
        $this->program = $program;
        $this->mata = $mata;
    }
    public function render()
    {

        $mataTahun = $this->mata->get()->groupBy(function($date) {
            return Carbon::parse($date->publish_start)->format('Y'); // grouping by years
            });
        $chart = (new LineChartModel());

        foreach($mataTahun as $a => $date){
        $mataCount = $this->mata->whereYear('publish_start',$a)->count();
        $chart->addPoint($a,$mataCount);
        }
        return view('livewire.chart.program',compact('chart'));
    }
}
