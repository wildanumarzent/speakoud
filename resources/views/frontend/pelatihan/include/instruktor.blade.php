<div class="tab-pane fade" id="search-images">
    <!-- Header -->
    <div class="container">
        <div class="media col-md-12">
            {{-- {{dd(asset('/userfile/photo/'.$data['mata']->creator->photo['filename']))}} --}}
            {{-- <img src="{{ $data['mata']->creator->photo['filename'] != null ? asset('/userfile/photo/'.$data['mata']->creator->photo['filename'] != null) : asset('assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle"> --}}
            <img src="{{ asset('/userfile/photo/'.$data['mata']->creator != null ? '/userfile/photo/'.$data['mata']->creator->photo['filename'] : '/userfile/photo/assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
                <div class="media-body pt-2 ml-3">
                <h6 class="mb-2"> <strong style="color: grey">Instruktur</strong></h6>
                <h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->creator->name}}</strong></h6>
            </div>
        </div>
    </div>
</div>
