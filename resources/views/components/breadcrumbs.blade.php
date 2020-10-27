@isset($breadcrumbsBackend)
<h4 class="font-weight-light py-3 mb-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        @foreach ($breadcrumbsBackend as $key => $val)
        <li class="breadcrumb-item">
            <a href="{{ $val }}">{{ $key }}</a>
        </li>
        @endforeach
    </ol>
</h4>
@endisset
