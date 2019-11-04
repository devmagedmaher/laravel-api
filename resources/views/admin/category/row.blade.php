      

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
    @if ($category->hasImage())
        <div class="img-thumbnail">
            <img src="{{ $category->image_url }}" height="30" width="auto">
        </div>
    @else
        <form action="{{ route('admin.category.upload', ['category' => $category->id]) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <label>
                <span class="btn btn-default btn-xs">upload</span>
                <input type="file" name="image" class="submit-on-change" style="display: none">
            </label>
        </form>
    @endif
    </td>
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
    </td>
</tr>
