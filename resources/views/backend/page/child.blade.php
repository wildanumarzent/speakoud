@foreach ($childs as $child)
<tr>
    <td><i class="lab la-slack"></i></td>
    <td>--- {!! Str::limit($child->judul, 90) !!} <a href="{{ route('page.read', ['id' => $child->id, 'slug' => $child->slug]) }}" title="view website" target="_blank"><i class="las la-external-link-alt"></i></a></td>
    <td><span class="badge badge-info">{!! $child->viewer ?? 0 !!}</span></td>
    <td>
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $child->publish == 1 ? 'primary' : 'warning' }}"
            title="Click to publish page">
            {{ $child->publish == 1 ? 'Publish' : 'Draft' }}
            <form action="{{ route('page.publish', ['id' => $child->id]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
    </td>
    <td>{{ $child->created_at->format('d F Y (H:i)') }}</td>
    <td>{{ $child->updated_at->format('d F Y (H:i)') }}</td>
    <td>
        @php
        $min = $child->where('parent', $child->parent)->min('urutan');
        $max = $child->where('parent', $child->parent)->max('urutan');
        @endphp
        @if ($min != $child->urutan)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="klik untuk merubah urutan">
            <i class="las la-arrow-up"></i>
            <form action="{{ route('page.position', ['id' => $child->id, 'position' => ($child->urutan - 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" disabled><i class="las la-arrow-up"></i></button>
        @endif
        @if ($max != $child->urutan)
        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="klik untuk merubah urutan">
            <i class="las la-arrow-down"></i>
            <form action="{{ route('page.position', ['id' => $child->id, 'position' => ($child->urutan + 1), 'parent' => $child->parent]) }}" method="POST">
                @csrf
                @method('PUT')
            </form>
        </a>
        @else
        <button type="button" class="btn icon-btn btn-sm btn-default" disabled><i class="las la-arrow-down"></i></button>
        @endif
    </td>
    <td>
        <a href="{{ route('page.create', ['parent' => $child->id]) }}" class="btn icon-btn btn-sm btn-success" title="klik untuk menambah page">
            <i class="las la-plus"></i>
        </a>
        <a href="{{ route('page.edit', ['id' => $child->id]) }}" class="btn icon-btn btn-sm btn-primary" title="klik untuk mengedit page page">
            <i class="las la-pen"></i>
        </a>
        <a href="javascript:;" data-id="{{ $child->id }}" class="btn icon-btn btn-sm btn-danger js-sa2-delete" title="klik untuk menghapus page">
            <i class="las la-trash"></i>
        </a>
    </td>
</tr>
@endforeach
