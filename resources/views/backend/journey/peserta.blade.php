@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<!-- Filters -->

<div class="card">
    <div class="card-body">
        <form action="" method="GET">
        <div class="form-row align-items-center">
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Kata kunci...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-warning" title="klik untuk mencari"><i class="las la-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<!-- / Filters -->

<hr>
<h3>Learning Journey {{$data['peserta']->user->name}}</h3>



                @forelse ($data['journey'] as $item)
                @if($data['poinKu']->sum('poin') != 0)

                <div class="card mt-5">

                    <div class="p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-10 col-sm-8">
                                <a href="javascript:void(0)" class="text-body text-large font-weight-semibold">{{$item->judul}}</a>
                            </div>

                            <div class="col-md-2 col-sm-4">
                                <div class="btn-group dropdown dropdown-right mr-3">
                                 <button type="button" class="btn btn-primary btn-sm rounded-pill" data-toggle="collapse" data-target="#kompetensi-{{$item->id}}">Kompetensi</button>

                                <form action="{{route('journey.assign',['pesertaId' => $data['pesertaId']])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="journey_id" value="{{$item->id}}">
                                    {{-- <input type="hidden" name="status" value="{{$item->journeyPeserta->status}}"> --}}


                                @php
                                $assigned = $data['assigned']->where('journey_id',$item->id)->first();
                                @endphp

                                @if(!empty($assigned) && $assigned->status == 1)
                                @if( $assigned->complete == 0)
                                <input type="hidden" name="status" value="{{$assigned->status}}">
                                <button type="submit" class="btn btn-secondary btn-sm rounded-pill ml-2" data-toggle="collapse">Un-Assign</button>
                                @else
                                <button type="button" class="btn btn-success btn-sm rounded-pill ml-2" data-toggle="collapse">Selesai</button>
                                @endif
                                @else
                                <button type="submit" class="btn btn-warning btn-sm rounded-pill ml-2" data-toggle="collapse">Assign</button>
                                @endif
                                </div>
                            </form>
                            </div>

                        </div>
                        <div class="d-flex flex-wrap mt-3">
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-person text-light" title="Department"></i>&nbsp; {{$item->user->name}}</div>
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-time text-primary" title="Employment"></i>&nbsp; {{$item->created_at->format('Y-m-d H:i:s')}}</div>
                        </div>
                        <div class="mt-3 mb-4">

                            {!! Str::limit($item->deskripsi,120) !!}


                        </div>
                        <div class="collapse" id="kompetensi-{{$item->id}}">

                            @php
                            $totalPoint = $data['totalPoint']->where('journey_id',$item->id)->sum('minimal_poin');
                            $kompetensiId = $data['listKompetensi']->where('journey_id',$item->id)->pluck('kompetensi_id');
                            $myPoin = $data['poinKu']->whereIn('kompetensi_id',$kompetensiId)->sum('poin');
                            if($myPoin == null){
                                $myPoin = 0;
                            }
                            if($totalPoint > 0){
                                $persentase = round(($myPoin/$totalPoint) * 100);
                            }
                            @endphp
                            @if($totalPoint != 0)
                            <div class="progress mt-3 mb-2">
                                <div class="progress-bar" style="width: {{$persentase}}%;">{{$persentase}}%</div>
                              </div>
                            @endif

                        <ul class="list-group mt-3">
                            @foreach($data['listKompetensi']->where('journey_id',$item->id) as $k)

                            @php
                            $myPoin = $data['poinKu']->first();
                            if($myPoin == null){
                                $myPoin = 0;
                            }else{
                                $myPoin =  $myPoin->poin;
                            }
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">{{$k->kompetensi->judul}}
                                <span class="badge badge-@if($myPoin == $k->minimal_poin)success @else default @endif">{{$myPoin}}/{{$k->minimal_poin}} @if($myPoin == $k->minimal_poin)Complete @endif</span>
                            </li>

                            @endforeach
                        </ul>
                        </div>
                    </div>

                    <hr class="border-light m-0">
                </div>

                @endif
                @endforeach
                @if ($data['journey']->total() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-6 m--valign-middle">
                                Menampilkan : <strong>{{ $data['journey']->firstItem() }}</strong> - <strong>{{ $data['journey']->lastItem() }}</strong> dari
                                <strong>{{ $data['journey']->total() }}</strong>
                            </div>
                            <div class="col-lg-6 m--align-right">
                                {{ $data['journey']->onEachSide(3)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-body text-center">
                        <strong style="color: red;">
                            Tidak Ditemukan Learning Journey yang Terkait dengan Kompetensi Peserta Ini
                        </strong>
                    </div>
                </div>
                @endif
@endsection
@section('jsbody')
@include('components.toastr')
@endsection
@section('scripts')
<script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection
