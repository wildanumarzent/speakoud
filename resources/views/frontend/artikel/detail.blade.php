@extends('layouts.frontend.layout')

@section('content')
<main>
    <div class="box-wrap single-post">
        <div class="container">

            <!-- <div class="breadcrumb justify-content-center">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li class="current"><a href="">Artikel</a></li>
                </ul>
            </div> -->
            <div class="box-post text-center">
                <div class="post-date">
                   {{$data['artikel']->created_at->format('Y M d')}}
                </div>
                <div class="title-heading text-center">
                    <h1>{{$data['artikel']->title}}</h1>
                </div>
                <div class="post-info justify-content-center">
                    <div class="box-info mb-3">
                        <div class="item-info text-left">
                            <span class="ml-4">Create</span>
                            <div class="data-info">
                                <i class="las la-user-edit"></i>
                                <span>Admin User</span>
                            </div>
                        </div>
                        <div class="item-info text-left">
                            <span class="ml-4">Tags</span>
                            <div class="data-info">
                                <i class="las la-tag"></i>
                                <span>Technology</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-content mt-5">
                <article>
                    <article>
                           <strong>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deseru mollit anim id est laborum.</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                           <img src="images/slide-1.jpg">
                        <strong>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deseru mollit anim id est laborum.</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <ul>
                            <li>consectetur adipisicing elit</li>
                            <li>quis nostrud exercitation ullamco</li>
                            <li>reprehenderit in voluptate velit</li>
                            <li> incididunt ut labore et dolore</li>
                            <li>Lorem ipsum dolor sit amet</li>
                        </ul>
                        <img src="images/slide-3.jpg" style="float: left;">
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <a href="">test</a></p>
                         <img src="images/study-4.jpg" style="float: right;">
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    </article>
                </article>
            </div>
        </div>
    </div>
    <div class="box-wrap bg-grey">
    <div class="container">
        <div class="title-heading mb-4">
            <h6>BPPT E-Learning</h6>
            <h1>Recent Post</h1>
        </div>
        <div class="row mt-5">
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/slide-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Marketing
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                Panduan Penggunaan E-Learning
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/slide-2.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Digital
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                Pengenalan Komputer, Internet, Email &amp; Microsoft Word
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/slide-3.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Sponsored
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                The World's Most Refined Mountaineering Equipment
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/study-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Sponsored
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                The World's Most Refined Mountaineering Equipment
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/slide-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Marketing
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                Panduan Penggunaan E-Learning
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/slide-2.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Digital
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                Pengenalan Komputer, Internet, Email &amp; Microsoft Word
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/study-2.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Sponsored
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                The World's Most Refined Mountaineering Equipment
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item-post">
                    <div class="box-img article">
                        <div class="post-date">
                            13 March 2019
                        </div>
                        <div class="thumbnail-img">
                            <img src="images/study-3.jpg" alt="">
                        </div>
                    </div>
                    <div class="box-post boxless">
                        <div class="post-cat">
                            Sponsored
                        </div>
                        <a href="">
                            <h6 class="post-title">
                                The World's Most Refined Mountaineering Equipment
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
