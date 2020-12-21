@extends('layouts.backend.layout')

@section('content')
<div class="row">
    <div class="col-sm-6 col-xl-6">
    @livewire('chart.mata')
    </div>
    <div class="col-sm-6 col-xl-6">
        @livewire('chart.program')
        </div>
        <div class="col-sm-6 col-xl-6">
            @livewire('chart.pengajar')
            </div>
            <div class="col-sm-6 col-xl-6">
                @livewire('chart.peserta')
                </div>
</div>
<div class="row">
    <div class="col-sm-12 col-xl-12">
    @livewire('chart.keyword-view')
    </div>
</div>
@endsection
