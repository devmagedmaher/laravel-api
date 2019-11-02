      

<tr data-id="{{ $category->id }}" 
    data-parent="{{ $category->isParent() ? '0' : $category->parent_id }}" 
    data-level="{{ $category->isParent() ? '1' : '2' }}">
    <td data-column="name">
    	{{ $category->name }} 
        @if ($category->isParent())
        	&ensp;
    		@if ($category->children->count())
            	<span class="label label-default pull-right">
            		{{ $category->children->count() }} sub-category
            	</span>
    		@endif
        @endif
    </td>
    <td>{{ $category->items->count() }}</td>
    <td>
    	<a class="btn btn-default btn-xs" href="{{ route('admin.category.edit', ['category' => $category->id]) }}">edit</a>

    	<button class="btn btn-{{ $category->entries ? 'danger' : 'default' }} btn-xs delete-button submit-next-form">delete</button>
		<form action="{{ route('admin.category.delete', ['category' => $category->id]) }}" method="post" style="display: none">
            @method('DELETE')
			@csrf
        </form>
    </td>
    <td>
        @include('admin.lang-flags', ['languages' => $category->languages])
{{--     @foreach ($category->languages as $language)
    	@if ($language->image)
    		<img src="{{ url('storage/languages/'. $language->image) }}" title="{{ $language->name }}" class="flag flag-sm"> 
    	@else
        	<span title="{{ $language->name }}">[{{ $language->code }}]</span>
    	@endif
    	@if (!$loop->first && $loop->iteration % 3 === 0)
    		<br>
    	@endif
    @endforeach	
 --}}    </td>
</tr>
