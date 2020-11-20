<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;
use App\Models\Artikel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class KeywordView extends Component
{

    public $artikel,$data,$max,$min;
    public function mount(Artikel $artikel){
        $this->artikel = $artikel;
        $this->max = $this->artikel->query()->orderby('viewer','desc')->first()->viewer;
        $this->min = $this->artikel->query()->orderby('viewer','asc')->first()->viewer;
    }
    public function render()
    {
        $artikel = $this->artikel->get();
        $color = ["#b8f4ff","#a09fe6","#cc759a","#4faaa1","#90CDF4"];
        $chart = (new PieChartModel());
        foreach($artikel as $a){
        $chart->addSlice($a->meta_data['keywords'],$a->viewer, $color[array_rand($color)]);
        }
        return view('livewire.chart.keyword-view',compact('chart'));
    }
}
