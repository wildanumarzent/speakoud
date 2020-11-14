@extends('layouts.frontend.layout-blank')

@section('content')

<div class="item-signbox">
    <div class="title-heading">
        <h3>@lang('strip.register_title')</h3>
    </div>
</div>
<div class="item-signbox form">
    @include('components.alert')
</div>
@endsection
