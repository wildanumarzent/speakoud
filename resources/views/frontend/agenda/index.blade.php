@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                     <h1 >Agenda Kegiatan</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap bg-grey-alt">
   	<!-- Content -->
	<div class="container flex-grow-1 container-p-y">
        <div class="title-heading">
            {{-- <h1>{{ $data['mata']->judul}}</h1> --}}
        </div>
		
        <ul class="nav nav-tabs tabs-alt container-m-nx container-p-x mb-4">
            <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#happening">Happening</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#upcoming">Upcoming</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#search-images">Expired</a>
            </li>
        </ul>
		<div class="tab-content">
			<!-- Happening -->
			@include('frontend.agenda.include.happening')
			<!-- / Happening -->
			<!-- Upcoming -->
			@include('frontend.agenda.include.upcoming')
			<!-- / Upcoming -->
			<!-- Expired -->
			@include('frontend.agenda.include.expired')
			<!-- / Expired -->
		</div>
	</div>
	<!-- / Content -->
</div>
@endsection

