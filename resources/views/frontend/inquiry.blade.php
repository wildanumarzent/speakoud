@extends('layouts.frontend.layout')

@section('styles')
{!! NoCaptcha::renderJs() !!}
@endsection

@section('content')
<div class="banner-breadcrumb">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <div class="title-heading text-center">
                    <h1>{!! $data['read']->name !!}</h1>

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
    <div class="container">
        <div class="row justify-content-xl-between">
            @if ($data['read']->show_map == 1)
            <div class="col-md-5">
                <div class="box-map">
                    <div id="map"></div>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <div class="box-post map-desc">
                    <div class="title-heading">
                        <h6>{{ $data['read']->name }} Kami</h6>
                        {!! $data['read']->body !!}
                    </div>
                    <div class="post-info flex-column">
                        <div class="box-info mb-4">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">Tempat</span>
                                <div class="data-info">
                                    <i class="las la-map-marker"></i>
                                    <span>{{ $configuration['address'] }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="box-info mb-4">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">Telpon</span>
                                @if (!empty($configuration['fax']))
                                <div class="data-info">
                                    <i class="las la-fax"></i>
                                    <span>{{ $configuration['fax'] }}</span>
                                </div>
                                @endif
                                @if (!empty($configuration['phone']))
                                <div class="data-info">
                                    <i class="las la-tty"></i>
                                    <span>{{ $configuration['phone'] }}</span>
                                </div>
                                @endif
                                @if (!empty($configuration['phone_2']))
                                <div class="data-info">
                                    <i class="las la-phone"></i>
                                    <span>{{ $configuration['phone_2'] }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="box-info mb-4">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">E-mail</span>
                                @if (!empty($configuration['email']))
                                <div class="data-info">
                                    <i class="las la-envelope"></i>
                                    <span><a href="mailto:{{ $configuration['email'] }}">{{ $configuration['email'] }}</a></span>
                                </div>
                                @endif
                                @if (!empty($configuration['email_2']))
                                <div class="data-info">
                                    <i class="las la-envelope-open-text"></i>
                                    <span><a href="mailto:{{ $configuration['email_2'] }}">{{ $configuration['email_2'] }}</a></span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="box-info mb-4">
                            <div class="item-info text-left p-0" style="border: none;">
                                <span class="ml-4">Website</span>
                                <div class="data-info">
                                    <i class="las la-globe-asia"></i>
                                    <span><a href="{{ $configuration['website'] }}">@lang('strip.inquiry_website')</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if ($data['read']->show_form == 1)
        <div class="inquiry mt-5">
            <div class="title-heading text-center">
                <h1>@lang('strip.inquiry_button')</h1>
            </div>
            {{-- @include('components.alert') --}}
            @if (Cookie::get('inquiry-contact'))
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                {!! $data['read']->after_body ?? 'Thaks for your feedback' !!}
            </div>
            @else
            <form class="row" action="{{ route('inquiry.send', ['id' => $data['read']->id]) }}" method="POST">
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Nama">
                        @include('components.field-error', ['field' => 'name'])
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}" placeholder="Email">
                        @include('components.field-error', ['field' => 'email'])
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input id="subject" class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                        @include('components.field-error', ['field' => 'subject'])
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <textarea id="company" class="form-control @error('message') is-invalid @enderror" type="text" name="message" placeholder="Message">{{ old('message') }}</textarea>
                    @include('components.field-error', ['field' => 'message'])
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    {!! app('captcha')->display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-primary" type="submit">@lang('strip.inquiry_button')</button>
                </div>
            </form>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection

@section('jsbody')
@if ($data['read']->show_map == 1)
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0CuuQ5YQNoIc91Ser9cbum8gYy0oOf4w&callback=initMap" async defer></script>
<script>
    var map;
        function initMap() {
        var Lat = '{{ $data['read']->latitude }}';
        var Lon = '{{ $data['read']->longitude }}';
        var myLatlng = new google.maps.LatLng(Lat, Lon);

        map = new google.maps.Map(document.getElementById('map'), {
            center: myLatlng,
            zoom: 14,
            gestureHandling: 'greedy',
            scrollwheel: false,
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Pusat Pembinaan, Pendidikan dan Pelatihan BPPT',
        });
    }
</script>
@endif
@endsection
