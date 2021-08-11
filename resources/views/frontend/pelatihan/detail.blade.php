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
    <div class="container-fluid flex-grow-1 container-p-y">
        <h1>ISO 37001:2016, ABMS Awareness </h1>
        <div class="row">      
                   <div class="col-md-2">
                       <div class="media mb-3">
                            <img src="{{asset('assets/img/5.png')}}" alt width="70px" class="ui-w-40 rounded-circle">
                            <div class="media-body pt-2 ml-3">
                                <h6 class="mb-2"> <strong style="color: grey">Teacher</strong></h6>
                                <h6><strong style="color: rgb(53, 53, 53)">Nellie Maxwell</strong></h6>
                            </div>
                        </div>
                   </div>
                   <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
                   <div class="col-md-3">
                        <div class="media mb-3">
                            <div class="media-body pt-2 ml-3">
                                <h6 class="mb-2"><strong style="color: grey">Categories</strong></h6>
                                <h6><strong style="color: rgb(53, 53, 53)">SISTEM ANTI KORUPSI DAN SUAP</strong></h6>
                            </div>
                        </div>
                   </div>
                    <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
                   <div class="col-md-2">
                         <div class="media mb-3">
                            <div class="media-body pt-2 ml-3">
                                <h6 class="mb-2"><strong style="color: grey">Review</strong></h6>
                               <div class="ui-stars" style="color: orange; font-size: 20px">
                                    <div class="ui-star filled">
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>

                                        <strong style="color: black">(5 REVIEW)</strong>
                                    </div>
                               </div>
                            </div>
                        </div>
                   </div>
                    <div class="line" style="border-left: 1px solid rgb(255, 217, 3); height: 70px;"></div>
                   <div class="col-md-2">
                        <div class="media mb-3">
                            <div class="media-body pt-2 ml-3">
                                <h3 class="mb-2" style="color: rgb(0, 255, 21)"> <strong>Free</strong> <a href="javascript:void(0)" class="btn btn-warning">MORE INFO</a> </h3>
                            </div>
                        </div>
                   </div>
           </div>
           <br>

            <ul class="search-nav nav nav-tabs tabs-alt container-m-nx container-p-x mb-4">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#search-pages"><h5><i class="ion ion-md-copy" style="color: orange"></i>&nbsp; <strong>Overview</strong> </h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-people"><h5><i class="ion ion-logo-dropbox" style="color: orange"></i>&nbsp; <strong>curriculum</strong> </h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-images"><h5><i class="ion ion-ios-person" style="color: orange"></i>&nbsp; <strong>Instructor</strong> </h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#search-videos"><h5><i class="ion ion-ios-chatbubbles" style="color: orange"></i>&nbsp; <strong>Reviews</strong> </h5></a>
              </li>
            </ul>

            <div class="tab-content">

              <!-- Pages -->
              <div class="tab-pane fade show active" id="search-pages">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-2 pt-0">
                        <div class="container">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 73px"><i class="far fa-copy" style="color: orange"></i> Lectures</h6></th>
                                    <th><h6><strong>4</strong></h6></th>
                                </tr>
                            </table>
                            <hr style="color: orange">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 79px"><i class="fas fa-question" style="color: orange"></i> Quizzes</h6></th>
                                    <th><h6><strong>0</strong></h6></th>   
                                </tr>
                            </table>
                            <hr style="color: orange">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 63px"><i class="far fa-file-alt" style="color: orange"></i> Certificate</h6></th>
                                    <th><h6><strong>No</strong></h6></th>     
                                </tr>
                            </table>
                            <hr style="color: orange">
                            <table class="table-responsive mt-3">
                                <tr>
                                    <th><h6 style="padding-right: 41px"><i class="fas fa-check-circle" style="color: orange"></i> Assessments</h6></th>
                                    <th><h6><strong>yes</strong></strong></h6></th>     
                                </tr>
                            </table>
                            <hr style="color: orange">
                           <table class="table-responsive mt-3">
                                <tr>
                                   <th><h6 style="padding-right: 66px"><i class="fas fa-users" style="color: orange"></i> Students</h6></th>
                                    <th><h6><strong>0</strong></h6></th>       
                                </tr>
                            </table>
                            <hr style="color: orange">
                             <table class="table-responsive mt-3">
                                <tr>
                                     <th><h6 style="padding-right: 70px"><i class="far fa-clock" style="color: orange"></i> Duration</h6></th>
                                    <th><h6><strong>0 week</strong></h6></th>        
                                </tr>
                            </table>
                            <hr style="color: orange">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="ui-bordered">
                                    <img class="p-4" src="{{asset('/assets/img/img-2.jpg')}}" width="500px" alt="">
                                    <a href="javascript:void(0)" class="ui-rect ui-bg-cover text-white">
                                        <div class="d-flex justify-content-start align-items-end ui-rect-content p-2">
                                        
                                        </div>
                                    </a>
                                    <div class="p-4">
                                        <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h6>
                                        <p> Duis ut quam nec mi bibendum finibus et id tortor. Maecenas 
                                        tristique dolor enim, sed tristique sem cursus et. Etiam tempus 
                                        iaculis blandit. Vivamus a justo a elit bibendum pulvinar ut non 
                                        erat. Cras in purus sed leo mattis consequat viverra id arcu. Lorem 
                                        ipsum dolor sit, amet consectetur adipisicing elit. Delectus 
                                        excepturi consectetur quia iure ipsam aut provident facere odio 
                                        obcaecati dignissimos accusamus quisquam, culpa iusto dolores sed
                                        modi, voluptate illo eos! 
                                        Duis ut quam nec mi bibendum finibus et id tortor. Maecenas 
                                        tristique dolor enim, sed tristique sem cursus et. Etiam tempus 
                                        iaculis blandit. Vivamus a justo a elit bibendum pulvinar ut non 
                                        erat. Cras in purus sed leo mattis consequat viverra id arcu. Lorem 
                                        ipsum dolor sit, amet consectetur adipisicing elit. Delectus 
                                        excepturi consectetur quia iure ipsam aut provident facere odio 
                                        obcaecati dignissimos accusamus quisquam, culpa iusto dolores sed
                                        modi, voluptate illo eos!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- / Pages -->

              <!-- People -->
            <div class="tab-pane fade" id="search-people">
                <div class="row">
                    <div class="col-md-10">
                        <div class="theme-bg-white ui-bordered mb-2">
                                <a href="#company-faq-1" class="d-flex justify-content-between text-body py-3 px-4" data-toggle="collapse">
                                    <h1>ISO 37001:2016, ABMS Awareness </h1>
                                    <span class="collapse-icon"><h3 style="color: orange; font-weight: bold">4</h3></span>
                                </a>
                                <h3></h3>
                            <div id="company-faq-1" class="collapse text-muted">
                                <div class="card-body py-6">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col"><h3><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.1</strong></h3></div>
                                            <div class="d-none d-md-block col-10">
                                                <div class="row no-gutters align-items-center">
                                                <div class="col-11"><h3>Modul 1</h3></div>
                                                <div class="col-1"><h3><i class="fas fa-lock" style="color: orange"></i></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body py-6">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col"><h3><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.2</strong></h3></div>
                                            <div class="d-none d-md-block col-10">
                                                <div class="row no-gutters align-items-center">
                                                <div class="col-11"><h3>Modul 2</h3></div>
                                                <div class="col-1"><h3><i class="fas fa-lock" style="color: orange"></i></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body py-6">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col"><h3><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.3</strong></h3></div>
                                            <div class="d-none d-md-block col-10">
                                                <div class="row no-gutters align-items-center">
                                                <div class="col-11"><h3>Modul 3</h3></div>
                                                <div class="col-1"><h3><i class="fas fa-lock" style="color: orange"></i></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body py-6">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col"><h3><i class="far fa-copy" style="color: orange"></i> Lectures <strong>1.4</strong></h3></div>
                                            <div class="d-none d-md-block col-10">
                                                <div class="row no-gutters align-items-center">
                                                <div class="col-11"><h3>Modul 4</h3></div>
                                                <div class="col-1"><h3><i class="fas fa-lock" style="color: orange"></i></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <!-- / People -->

              <!-- Images -->
              <div class="tab-pane fade" id="search-images">
                     <!-- Header -->
                    <div class="container-m-nx container-m-ny theme-bg-white mb-4">
                    <div class="media col-md-10 col-lg-8 col-xl-7 py-5 mx-auto">
                        <img src="{{asset('/assets/img/5.png')}}" alt class="d-block ui-w-50 rounded-circle">
                        <div class="media-body ml-5">
                        <h4 class="font-weight-bold mb-4">Nellie Maxwell</h4>

                        <div class="text-muted mb-4">
                            Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro principes ei has.
                        </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    </div>
              </div>
              <!-- / Images -->

              <!-- Search -->
            <div class="tab-pane fade" id="search-videos">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Info -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h1 style="text-align: center; color: orange; font-size: 200px; font-weight: bold">0</h1>
                                    <div class="ui-star filled" style="text-align: center;font-size: 50px; color: orange">
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                        <i class="ion ion-md-star"></i>
                                    </div>
                                    <h3 style="text-align: center">0 rating</h3>
                            </div>
                        </div>
                        <!-- / Info -->
                    </div>
                <div class="col-xl-4">
                    <!-- Side info -->
                    <div class="card mb-4">
                    <hr class="border-light m-0">
                    <div class="card-body">
                        <div class="mb-1"><h2 style="font-weight: bold">5 </h2></div>
                        <div class="progress mb-3" style="height: 10px;">
                        {{-- <div class="progress-bar bg-secondary" style="width: 80%;"></div> --}}
                        </div>

                        <div class="mb-1"><h2 style="font-weight: bold">4</h2> <small class="text-muted"></small></div>
                        <div class="progress mb-3" style="height: 10px;">
                        {{-- <div class="progress-bar bg-success" style="width: 95%;"></div> --}}
                        </div>

                        <div class="mb-1"><h2 style="font-weight: bold">3</h2><small class="text-muted"></small></div>
                        <div class="progress mb-3" style="height: 10px;">
                        {{-- <div class="progress-bar bg-warning" style="width: 90%;"></div> --}}
                        </div>

                        <div class="mb-1"><h2 style="font-weight: bold">2</h2> <small class="text-muted"></small></div>
                        <div class="progress" style="height: 10px;">
                        {{-- <div class="progress-bar bg-danger" style="width: 80%;"></div> --}}
                        </div>
                        <div class="mb-1"><h2 style="font-weight: bold">1</h2><small class="text-muted"></small></div>
                        <div class="progress" style="height: 10px;">
                        {{-- <div class="progress-bar bg-danger" style="width: 80%;"></div> --}}
                        </div> 
                    </div>
                    <hr class="border-light m-0">
                    </div>
                    <!-- / Side info -->
                    </div>
                    <!-- / Search -->
                </div>
            </div>
        </div>
</div>
@endsection
