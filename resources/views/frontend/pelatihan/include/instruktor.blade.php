<div class="tab-pane fade" id="search-images">
    <!-- Header -->
    <div class="container-m-nx container-m-ny theme-bg-white mb-4">
        <div class="media col-md-10 col-lg-8 col-xl-7 py-5 mx-auto">
            {{-- {{dd(asset('/userfile/photo/'.$data['mata']->creator->photo['filename']))}} --}}
            {{-- <img src="{{ $data['mata']->creator->photo['filename'] != null ? asset('/userfile/photo/'.$data['mata']->creator->photo['filename'] != null) : asset('assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle"> --}}
            <img src="{{ asset('/userfile/photo/'.$data['mata']->creator != null ? '/userfile/photo/'.$data['mata']->creator->photo['filename'] : '/userfile/photo/assets/img/5.png') }}" alt width="70px" class="ui-w-40 rounded-circle">
                <div class="media-body pt-2 ml-3">
                <h6 class="mb-2"> <strong style="color: grey">Teacher</strong></h6>
                <h6><strong style="color: rgb(53, 53, 53)">{{$data['mata']->creator->name}}</strong></h6>
            </div>
        </div>
    <hr class="m-0">
    </div>
</div>
