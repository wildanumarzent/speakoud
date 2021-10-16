@extends('frontend.course.dokumen-view')

@section('content-view')
     @if ($data['bahan']->dokumen->bankData->file_type == 'pdf')
        <iframe id="myiframe" class="document" src="{{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
        </iframe>
    {{-- <iframe id="iframe" src="{{ route('bank.data.stream', $data['pdf']) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe> --}}
    @elseif ($data['bahan']->dokumen->bankData->file_type == 'ppt' || $data['bahan']->dokumen->bankData->file_type == 'pptx')
    <iframe id="iframe" src="https://view.officeapps.live.com/op/view.aspx?src={{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe>
    @endif
@endsection
@section('scripts')
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.min.js" integrity="sha512-B+t1szGNm59mEke9jCc5nSYZTsNXIadszIDSLj79fEV87QtNGFNrD6L+kjMSmYGBLzapoiR9Okz3JJNNyS2TSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.js" integrity="sha512-I5DeI8/00iidt2UqCjN6/VXjksWSsSwuEleCimq5QuPmhfbnMWSRrfp4cvS6lESaZXYCNv+0qs2Kor9ItoMORA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('jsbody')
   <script>
    //    alert("test");
   </script>
@endsection
