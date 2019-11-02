

<tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item->category_name }}</td>
    <td>
        {{ $item->images->count() }}
    </td>
    <td>
    	<a class="btn btn-default btn-xs" href="{{ route('admin.item.edit', ['item' => $item->id]) }}">edit</a>
    	
        <button class="btn btn-default btn-xs submit-next-form">delete</button>
		<form action="{{ route('admin.item.delete', ['item' => $item->id]) }}" method="post" style="display: none">
			@method('DELETE')
			@csrf
		</form>

        @if($item->image_remaining)
            <a href="{{ route('admin.image.upload', ['item' => $item->id]) }}" class="btn btn-default btn-xs">upload images</a>
        @endif
    </td>
    <td>
        @include('admin.lang-flags', ['languages' => $item->languages])
    </td>
</tr>
