@isset($breadcrumbsBackend)
<h4 class="font-weight-light py-3 mb-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" title="@lang('layout.menu.dashboard')">@lang('layout.menu.dashboard')</a>
        </li>
        @foreach ($breadcrumbsBackend as $key => $val)
        <li class="breadcrumb-item">
            <a href="{{ $val }}" title="{{ $key }}">{{ $key }}</a>
        </li>
        @endforeach
    </ol>
</h4>
@endisset

@isset($breadcrumbsFrontend)
<div class="breadcrumb">
    <ul>
        <li><a href="{{ route('home') }}" title="Beranda">Home</a></li>
        @foreach ($breadcrumbsFrontend as $key => $val)
        <li class="{{ empty($val) ? 'current' : '' }}" title="{{ $key }}"><a href="{{ $val }}">{{ $key }}</a></li>
        @endforeach
    </ul>
</div>
@endisset
