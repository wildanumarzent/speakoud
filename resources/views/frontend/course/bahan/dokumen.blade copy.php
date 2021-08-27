<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- <a href="">kemabali</a> --}}
     @if ($data['bahan']->dokumen->bankData->file_type == 'pdf')
    <div id="isRead">
        <iframe id="myiframe" class="document" src="{{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
        </iframe>
    </div>
    {{-- <iframe id="iframe" src="{{ route('bank.data.stream', $data['pdf']) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe> --}}
    @elseif ($data['bahan']->dokumen->bankData->file_type == 'ppt' || $data['bahan']->dokumen->bankData->file_type == 'pptx')
    <iframe id="iframe" src="https://view.officeapps.live.com/op/view.aspx?src={{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}" frameborder="0" style="width:100%;height:7000px;">
    </iframe>
    @endif

    <script>
        var i = document.getElementById('myiframe');
        var heig  = i.offsetHeight = 700;
        console.log(heig);
    </script>
</body>
</html>
{{-- @extends('frontend.course.dokumen-view') --}}

{{-- @section('content-view') --}}
   
{{-- @endsection --}}
{{-- @section('scripts')
    <script src="{{ asset('assets/tmplts_backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.min.js" integrity="sha512-B+t1szGNm59mEke9jCc5nSYZTsNXIadszIDSLj79fEV87QtNGFNrD6L+kjMSmYGBLzapoiR9Okz3JJNNyS2TSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.js" integrity="sha512-I5DeI8/00iidt2UqCjN6/VXjksWSsSwuEleCimq5QuPmhfbnMWSRrfp4cvS6lESaZXYCNv+0qs2Kor9ItoMORA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('jsbody')
   <script>
       alert("test");
   </script>
@endsection --}}
