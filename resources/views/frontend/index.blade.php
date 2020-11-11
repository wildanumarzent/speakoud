@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_frontend/css/swiper.min.css') }}">
@endsection

@section('content')
<div class="slide-intro">
    <div class="swiper-container swiper-1">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slide-inner" data-swiper-parallax="45%">
                    <div class="slide-inner-overlay"></div>
                    <div class="slide-inner-image thumbnail-img">
                        <img src="{{ asset('assets/tmplts_frontend/images/slide-1.jpg') }}">
                    </div>
                    <div class="slide-inner-info title-heading">
                        <h6 class="Text-white">Selamat Datang  Di</h6>
                        <h1 data-swiper-parallax="-400px">BPPT E-Learning System</h1>
                        <h5>Layanan Pelatihan Jarak Jauh oleh Pusbindiklat BPPT.</h5>
                        <div class="box-btn">
                            <a href="" class="btn btn-primary text-white">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide-inner" data-swiper-parallax="45%">
                    <div class="slide-inner-overlay"></div>
                    <div class="slide-inner-image thumbnail-img">
                        <img src={{ asset('assets/tmplts_frontend/images/slide-3.jpg') }}>
                    </div>
                    <div class="slide-inner-info title-heading">
                        <h1 data-swiper-parallax="-400px">BELS: BPPT E-Learning System</h1>
                        <h5>Tingkatkan pengetahuan dan keterampilan anda bersama kami, kapan pun dan dimana pun.</h5>
                        <div class="box-btn">
                            <a href="" class="btn btn-primary text-white">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide-inner" data-swiper-parallax="45%">
                    <div class="slide-inner-overlay"></div>
                    <div class="slide-inner-image thumbnail-img">
                        <img src={{ asset('assets/tmplts_frontend/images/slide-2.jpg') }}>
                    </div>
                    <div class="slide-inner-info title-heading">
                        <h1 data-swiper-parallax="-400px">Pelatihan Jabatan Fungsional Perekayasa</h1>
                        <h5>Tingkatkan pengetahuan dan keterampilan anda bersama kami, kapan pun dan dimana pun.</h5>
                        <div class="box-btn">
                            <a href="" class="btn btn-primary text-white">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next sbn-1"><i class="la la-angle-right"></i></div>
        <div class="swiper-button-prev sbp-1"><i class="la la-angle-left"></i></div>
    </div>
</div>
<div class="box-wrap">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-5">
                <div class="video-intro">
                    <div class="thumbnail-img">
                        <img src="{{ asset('assets/tmplts_frontend/images/asep.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="title-heading">
                    <h6>BPPT E-Learning</h6>
                    <h1>Selamat Datang di BPPT E-Learning System</h2>
                </div>
                <article class="summary-text">
                    <p><strong>Kepala Pusat Pembinaan, Pendidikan dan Pelatihan BPPT</strong></p>
                    <p><i>Prof. Dr. Ir. Suhendar I. Sachoemar, M.Si.</i></p>
                    <p>Pusat Pembinaan, Pendidikan dan Pelatihan (Pusbindiklat) Badan Pengkajian dan Penerapan Teknologi (BPPT) bertugas melaksanakan pembinaan, menyelenggarakan pendidikan dan pelatihan perekayasaan teknologi dan pelatihan bidang lainnya. Kegiatan pendidikan dan pelatihan yang telah dilakukan selama ini merupakan kontribusi nyata Pusbindiklat dalam mempersiapkan sumber daya manusia indonesia yang profesional dan kompeten di bidang ilmu pengetahuan dan teknologi (IPTEK).</p>
                    <p>Dalam rangka memudahkan peserta pelatihan dalam mengikuti pelatihan yang kami selenggarakan, kini kami memfasilitasi pembelajaran secara daring melalui BELS (BPPT E-Learning System). Dengan begitu, para peserta pelatihan dapat mengkuti kegiatan pembelajaran yang kami selenggarakan secara daring dimana saja, dan kapan saja sesuai dengan kebutuhan peserta diklat.</p>
                </article>
            </div>
            
        </div>
    </div>
</div>
<!-- <div class="box-wrap bg-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading text-white text-center">
                    <h6>BPPT E-Learning</h6>
                    <h1>Panduan Penggunaan</h2>
                    <div class="box-btn">
                        <a href="" class="btn btn-primary white">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="box-wrap bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading">
                    <h6>BPPT E-Learning</h6>
                    <h1>Program Pelatihan</h2>
                </div>
                <div class="summary-text m-0">
                    <p>Beragam pilihan program pelatihan e-learning yang tersedia saat ini</p>
                </div>
            </div>
        </div>
        <div class="swiper-container mt-5 swiper-2" style="overflow: visible;">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Jabatan Fungsional Teknisi Litkayasa
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Jabatan Fungsional Teknisi Perekayasa
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-3.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Penulisan Karya Tulis Ilmiah
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-4.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                TOEFL ITP Preparation Course
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                    <div class="box-info">
                                        <div class="item-info">
                                            <div class="data-info">
                                                <i class="las la-user"></i>
                                                <span>50</span>
                                            </div>
                                            <span>Enrolled</span>
                                        </div>
                                        <div class="item-info">
                                            <div class="data-info">
                                                <i class="las la-comment"></i>
                                                <span>15</span>
                                            </div>
                                            <span>Topics</span>
                                        </div>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Jabatan Fungsional Teknisi Litkayasa
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Jabatan Fungsional Teknisi Perekayasa
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-3.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                Pelatihan Penulisan Karya Tulis Ilmiah
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                <div class="box-info">
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-user"></i>
                                            <span>50</span>
                                        </div>
                                        <span>Enrolled</span>
                                    </div>
                                    <div class="item-info">
                                        <div class="data-info">
                                            <i class="las la-comment"></i>
                                            <span>15</span>
                                        </div>
                                        <span>Topics</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="item-post">
                        <div class="box-img">
                            <div class="thumbnail-img">
                                <img src="{{ asset('assets/tmplts_frontend/images/study-4.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="box-post">
                            <div class="post-date">
                                13 March 2019
                            </div>
                            <h5 class="post-title">
                                TOEFL ITP Preparation Course
                            </h5>
                            <div class="post-info">
                                <a href="" class="btn btn-primary mr-auto">Daftar</a>
                                    <div class="box-info">
                                        <div class="item-info">
                                            <div class="data-info">
                                                <i class="las la-user"></i>
                                                <span>50</span>
                                            </div>
                                            <span>Enrolled</span>
                                        </div>
                                        <div class="item-info">
                                            <div class="data-info">
                                                <i class="las la-comment"></i>
                                                <span>15</span>
                                            </div>
                                            <span>Topics</span>
                                        </div>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="box-btn d-flex align-items-center  mt-xl-5">
                <div class="swiper-btn-wrapper">
                    <div class="swiper-button-prev swiper-btn sbp-2"><i class="la la-angle-left"></i></div>
                    <div class="swiper-button-next swiper-btn sbn-2"><i class="la la-angle-right"></i></div>
                </div>
                <a href="" class="link-icon ml-xl-auto">
                    Lihat lainnya
                    <span>
                        <i class="las la-arrow-right"></i>
                    </span>
                </a>

            </div>
        </div>
    </div>
</div>
<div class="box-wrap bg-grey-alt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-heading text-center">
                    <h6>BPPT E-Learning</h6>
                    <h1>Acara Mendatang</h2>
                    <div class="summary-text m-0">
                        <p>Temukan program pelatihan E-Learning yang akan diselenggarakan dalam waktu dekat, disini</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                       
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="detail-jadwal.html">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                       
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="item-post row-box">
                    <div class="box-img">
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <a href="">
                            <h5 class="post-title">
                                Pendaftaran Diklat JF Perekayasa Batch 1
                            </h5>
                        </a>
                        <div class="post-info flex-column">
                            <div class="box-info">
                                <div class="item-info text-left">
                                    <span class="ml-4">Start</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>08:00 AM</span>
                                    </div>
                                </div>
                                <div class="item-info text-left">
                                    <span class="ml-4">End</span>
                                    <div class="data-info">
                                        <i class="las la-clock"></i>
                                        <span>17:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-btn d-flex justify-content-center">
            <a href="" class="link-icon">
                Lihat lainnya
                <span>
                    <i class="las la-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<div class="box-wrap bg-blue">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="title-heading text-center text-white">
                    <h6>BPPT E-Learning</h6>
                    <h1>Berlangganan Informasi Pelatihan Terbaru</h2>
                    <div class="summary-text m-0">
                        <p>Terus terhubung dengan kami untuk mengetahui informasi mengenai pelatihan terbaru yang akan kami selenggarakan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="" class="subs-box">
                    <input class="form-control" type="email" placeholder="Email address"></input>
                    <button class="btn btn-primary white">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/tmplts_frontend/js/swiper.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //SLIDER HOME
    var swiper = new Swiper('.swiper-1', {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 1000,
        autoplay: {
            delay: 5000,
        },
        parallax: true,
        draggable: false,
        simulateTouch: false,
        loop: 'true',
        navigation: {
            nextEl: '.sbn-1',
            prevEl: '.sbp-1',
            }
    });

    var swiper = new Swiper('.swiper-2', {
        slidesPerView: 3,
        spaceBetween: 20,
        speed: 1000,
        parallax: true,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.sbn-2',
            prevEl: '.sbp-2',
            }
    });
</script>
@endsection
