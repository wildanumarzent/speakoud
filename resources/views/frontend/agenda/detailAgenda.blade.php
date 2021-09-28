@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                     <h1 >DETAIL AGENDA</h1>
                </div>
            </div>
            @include('components.breadcrumbs')
        </div>
    </div>
    <div class="thumbnail-img">
        <img src="{{ $configuration['banner_default'] }}" title="banner default" alt="banner learning">
    </div>
</div>
<div class="box-wrap">
   	<!-- Content -->
	<div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="title-heading">
                    <h1>Pelatihan ISO 37001:2016</h1>
                </div>
                <div class="box-event">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row" >
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Tanggal Mulai :</span>
                                    <div class="point-event">
                                        <i class="las la-calendar"></i>
                                        <div class="data-event">
                                            <strong>27 September 2021</strong>
                                        </div>
                                    </div>
                                    <span></span>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Tanggal Selesai :</span>
                                    <div class="point-event">
                                        <i class="las la-calendar"></i>
                                        <div class="data-event">
                                        <strong>29 September 2021</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Pukul :</span>
                                    <div class="point-event">
                                        <i class="las la-clock"></i>
                                        <div class="data-event">
                                        <strong>15:24 s/d 15:24</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-6">
                                    <span class="text-muted">Lokasi :</span>
                                    <div class="point-event">
                                        <i class="las la-clock"></i>
                                        <div class="data-event">
                                        <strong>Bandung</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <article class="mt-4 mb-3">
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorem at voluptate nihil accusamus, molestiae laboriosam minima fugiat iste atque magni error possimus eligendi deleniti tempora nam eveniet quos, maxime ad!</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </article>
                <div class="box-participant">
                    <div class="title-heading">
                        <h3 class="mb-4">Event Participants</h3>
                    </div>
                    <div class="list-participant">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="item-participant">
                                    <div class="img-participant">
                                        <div class="thumbnail-img">
                                            <img src="images/participant-1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="info-participant">
                                        <h6 class="name">John Doe</h6>
                                        <div class="departement">Founder</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box-information">
                    <form action="">
                        <div class="title-heading text-center">
                            <h3 class="mb-4">Buy Ticket</h3>
                        </div>
                        <ul class="list-information">
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-question"></i> -->
                                    <span>Total Slots</span>
                                </div>
                                <div class="data-information">
                                    <span>625</span>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-award"></i> -->
                                    <span>Booked Slots</span>
                                </div>
                                <div class="data-information">
                                        <span>233</span>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-check-circle"></i> -->
                                    <span>Cost</span>
                                </div>
                                <div class="data-information">
                                    <div class="box-price">
                                        <div class="no-free">Rp. 3,000,000</div>
                                    </div>
                                </div>
                            </li>
                            <li class="item-information">
                                <div class="title-information">
                                    <!-- <i class="las la-users"></i> -->
                                    <span>Students</span>
                                </div>
                                <div class="data-information">
                                    <input type="number" id="quantity" value="1" name="quantity" min="1" max="5" style="width: 100px">
                                </div>
                            </li>
                        </ul>
                        <button class="btn btn-primary filled d-block w-100 mt-5" type="submit">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<!-- / Content -->
</div>
@endsection

