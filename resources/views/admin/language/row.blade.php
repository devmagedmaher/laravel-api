

<tr>
	<td>{{ $language->id }}</td>
	<td>{{ $language->code }}</td>
	<td>
		<form action="{{ route('admin.language.upload', ['language' => $language->id]) }}" method="post" enctype="multipart/form-data">
			@method('PATCH')
			@csrf
			<label>
			@if ($language->hasImage())
				<img src="{{$language->image_url }}" title="{{ $language->name }}" class="mouse-pointer flag">
			@else
				<span class="btn btn-default btn-xs">upload</span>
			@endif
				<input type="file" name="image" style="display: none" class="submit-on-change">
			</label>
		</form>
	</td>
	<td>{{ $language->name }}</td>
	<td>{{ $language->categories->count() }}</td>
	<td>{{ $language->items->count() }}</td>
	<td>
		<a href="{{ route('admin.language.edit', ['language' => $language->id]) }}" class="btn btn-default btn-xs">edit</a>

		<button type="" class="btn btn-{{ $language->entries ? 'danger' : 'default' }} btn-xs submit-next-form" data-target="#{{ $language->code }}-delete-form">delete</button>
		<form action="{{ route('admin.language.delete', ['language' => $language->id]) }}" method="post" class="delete-form" style="display: none" id="{{ $language->code }}-delete-form">
			@method('DELETE')
			@csrf
		</form>
	</td>
</tr>
