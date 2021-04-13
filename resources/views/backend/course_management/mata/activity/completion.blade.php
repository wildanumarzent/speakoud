@extends('backend.course_management.mata.activity.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.css') }}">
<style>
.verticalTableHeader {
    text-align:center;
    white-space:nowrap;
    g-origin:50% 50%;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);

}
.verticalTableHeader p {
    margin:0 -100% ;
    display:inline-block;
}
.verticalTableHeader p:before{
    content:'';
    width:0;
    padding-top:110%;/* takes width as reference, + 10% for faking some extra padding */
    display:inline-block;
    vertical-align:middle;
}
</style>
@endsection

@section('content-view')
<div class="table-responsive table-mobile-responsive">
    <table id="user-list" class="table card-table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th style="width:120px;">NIP</th>
                <th style="width:180px;">Nama</th>
                @foreach($data['bahan'] as $item)
                <th class="verticalTableHeader" style="max-width: 10px;"><p>{{ $item->judul }}</p></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($data['peserta'] as $item)
            <tr>
                <td>{{ $data['number']++ }}</td>
                <td>{{ $item->peserta->nip }} </td>
                <td>{{ $item->peserta->user->email }}</td>
                @foreach($data['bahan'] as $bahan)
                    @php
                        $track = $data['track']->where('bahan_id', $bahan->id)->where('user_id', $item->peserta->user->id)->first();
                    @endphp
                    @if($data['track']->where('bahan_id', $bahan->id)->where('user_id', $item->peserta->user->id)->count() > 0)
                        <td style="text-align: center; width:10px;">
                            <a href="javascript:;" class="btn icon-btn btn-sm btn-{{ $track->status == '0' ? 'danger' : (!empty($track->track_end) ? 'success' : 'danger') }}" onclick="$(this).find('#form-update').submit();" title="{{ $track->status == '0' ? 'sudah menyelesaikan completion (By : '.$track->completed->name.')' : (!empty($track->track_end) ? 'sudah menyelesaikan completion (By : '.$track->completed->name.')' : 'belum menyelesaikan completion') }}">
                                <span class="las la-{{ !empty($track->track_end) ? 'check' : 'stop' }}"></span>
                                <form action="{{ route('mata.completion.status', ['id' => $track->id]) }}" method="POST" id="form-update">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                        </td>
                    @else
                        <td style="text-align: center; width:10px;">
                            <a href="javascript:;" class="btn icon-btn btn-sm btn-secondary" onclick="$(this).find('#form-submit').submit();" title="belum menyelesaikan completion">
                                <span class="las la-stop"></span>
                                <form action="{{ route('mata.completion.submit',['bahanId' => $bahan->id, 'userId' => $item->peserta->user->id]) }}" method="POST" id="form-submit">
                                    @csrf
                                </form>
                            </a>
                        </td>
                    @endif
                @endforeach
            </tr>
            @empty
            <tr>
                <td colspan="7" align="center">
                    <i>
                        <strong style="color:red;">
                        @if (Request::get('q'))
                        ! Peserta tidak ditemukan !
                        @else
                        ! Data Peserta kosong !
                        @endif
                        </strong>
                    </i>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-footer">
    <div class="row align-items-center">
        <div class="col-lg-6 m--valign-middle">
            Menampilkan : <strong>{{ $data['peserta']->firstItem() }}</strong> - <strong>{{ $data['peserta']->lastItem() }}</strong> dari
            <strong>{{ $data['peserta']->total() }}</strong>
        </div>
        <div class="col-lg-6 m--align-right">
            {{ $data['peserta']->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
@endsection
