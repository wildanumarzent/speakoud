<form action="{{ route($form['route'].'.store') }}" method="post" enctype="multipart/form-data" >
    @csrf
    <input type="hidden" name="sender_id" value="{{auth()->user()->id}}">
    <input type="hidden" name="sender_name" value="{{auth()->user()->username}}">
    <input type="hidden" name="mode" value="{{$data['mode']}}">

    @if($data['mode'] == 'edit')
    <input type="hidden" name="id" value = "{{@$data['data']->id}}">
    @endif

    @forelse($form['input'] as $value)

    @if($value['type'] == 'check')
    {{-- Form Check --}}
    <div class="form-group">
        <label class="form-label">{{$value['label']}}</label>
        @foreach($data[$value['value']] as $item)
        <label class="custom-control custom-checkbox">
          <input type="checkbox" value="1" id="{{$item}}"  {{ isset($data['my'.$value['value']][$item]) == $item?'checked':''}}  name="{{$value['value']}}[{{$item}}]" class="custom-control-input is-valid" >
          <span class="custom-control-label">{{$item}}</span>
        </label>
        @endforeach
        {!! $errors->first($value['value'], '<small class="form-text text-danger">:message</small>') !!}
    </div>
     {{-- Form Check --}}

    {{-- Form Select --}}
    @elseif($value['type'] == 'select')
    <div class="form-group">
        <label class="form-label">{{$value['label']}}</label>
        <select class="form-control select2 {{ $errors->has($value['value'])?' is-invalid':'' }}" name="{{$value['value']}}">
            @foreach ($data[$value['value']] as $item)
            @php
            $item->nama = $item[@$value['name']];
            @endphp
                @if (!empty($item->nama))
                <option value="{{$item[$value['param']]}}" {{$item->id==@$data['data'][$value['value']]?'selected':''}}>{{$item->nama}}</option>
                @endif
            @endforeach
        </select>
        {!! $errors->first($value['value'], '<small class="form-text text-danger">:message</small>') !!}
    </div>
    @else
    {{-- Form Select --}}

    {{-- Form Biasa --}}
    @if($value['value'] != 'password')
    <div class="form-group">
    <label class="form-label">{{$value['label']}}</label>
        <input type="{{$value['type']}}" name="{{$value['value']}}" class="form-control @error($value['value']) is-invalid @enderror" value="{{ old($value['value'])  ?? @$data['data'][$value['value']] }}"placeholder="Masukan {{$value['label']}}" @if($value['required'] == true) required autofocus @endif>

        @error($value['value'])
        <small style="color:maroon">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
    @else

    @if($data['mode'] == 'add')
    <div class="form-group">
    <label class="form-label">{{$value['label']}}</label>
        <input type="{{$value['type']}}" name="{{$value['value']}}" class="form-control {{ $errors->has($value['value'])?' is-invalid':'' }}" value="{{ old($value['value'])  ?? @$data['data'][$value['value']] }}"placeholder="Masukan {{$value['label']}}" @if($value['required'] == true) required autofocus @endif>
        {!! $errors->first($value['value'],'<small class="form-text text-danger">:message</small>') !!}

    </div>
    @endif

    @endif
    {{-- Form Biasa --}}
    @endif
    @empty
    @endforelse

    <button type="submit" class="btn btn-default">Simpan</button>
</form>
