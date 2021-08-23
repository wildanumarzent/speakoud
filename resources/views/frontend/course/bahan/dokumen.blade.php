@extends('frontend.course.dokumen-view')

@section('content-view')
    @if ($data['bahan']->dokumen->bankData->file_type == 'pdf')
    <iframe id="iframe" src="{{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe>
    @elseif ($data['bahan']->dokumen->bankData->file_type == 'ppt' || $data['bahan']->dokumen->bankData->file_type == 'pptx')
    <iframe id="iframe" src="https://view.officeapps.live.com/op/view.aspx?src={{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe>
    @endif
@endsection
