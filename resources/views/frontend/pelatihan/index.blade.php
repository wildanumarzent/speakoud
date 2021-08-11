@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>ALL COURSE</h1>
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
        <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="d-flex flex-wrap justify-content-between align-items-center w-100 font-weight-bold pt-2 mb-4">
            <div class="col-12 col-md px-0 pb-2">Courses</div>
            <div class="col-12 col-md-3 px-0 pb-2">
            <input type="text" class="form-control" placeholder="Search...">
            </div>
        </h4>

        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="{{route('pelatihan.detail',['id' => 1])}}" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-1.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h5 style="color: rgb(11, 245, 11)"> <strong>Free</strong> </h5>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-2.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h6 style="color: rgb(245, 147, 0)"> <strong>Rp. 1000.000</strong> </h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-3.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h5 style="color: rgb(11, 245, 11)"> <strong>Free</strong> </h5>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-2.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h6 style="color: rgb(245, 147, 0)"> <strong>Rp. 500.000</strong> </h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="{{route('pelatihan.detail',['id' => 1])}}" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-1.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h5 style="color: rgb(11, 245, 11)"> <strong>Free</strong> </h5>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-2.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h6 style="color: rgb(245, 147, 0)"> <strong>Rp. 1000.000</strong> </h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-3.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h5 style="color: rgb(11, 245, 11)"> <strong>Free</strong> </h5>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 shadow">
                    <div class="w-100">
                        <a href="javascript:void(0)" class="d-block ui-rect-60 ui-bg-cover">
                        <img class="card-img-top" src="{{asset('/assets/img/img-2.jpg')}}" alt="Card image cap">
                    </a>
                    </div>
                    <div class="card-body">
                    <h5 class="mb-3"><a href="javascript:void(0)" class="text-body">Complete Java Masterclass</a></h5>
                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec odio ligula, rhoncus scelerisque ullamcorper iaculis.</p>
                    <hr style="color: orange; background-color: orange">
                    <div class="media">
                        {{-- <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5> --}}
                        <div class="mr-3">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-users"></i> 100</a></h5>
                        </div>
                        <div class="media-body">
                        <h5> <a href="javascript:void(0)" class="text-muted small"><i class="fas fa-comment"></i> 55</a></h5>
                        </div>
                        <div class="text-muted small">
                        <h6 style="color: rgb(245, 147, 0)"> <strong>Rp. 500.000</strong> </h6>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">«</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="javascript:void(0)">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">4</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">5</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">»</a>
            </li>
            </ul>
        </nav>

        </div>
    <!-- / Content -->
</div>
@endsection
