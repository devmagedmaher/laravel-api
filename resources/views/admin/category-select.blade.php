@php
if (!isset($checked)) $checked = null;
@endphp
<select class="form-control" id="ParentCategory" name="category">
	<option value="" {{ old('category') ? '' : 'selected' }} disabled>Select Category</option>
	@foreach ($categories as $category) 
		<option disabled></option>
		<option value="{{ $category->id }}" {{ old('category') == $category->id || $checked == $category->id? 'selected' : '' }}>
			{{ $category->name }}
		</option>
		@foreach ($category->children as $child)
			<option value="{{ $child->id }}" {{ old('category') == $child->id || $checked == $child->id ? 'selected' : '' }}>
				---- {{ $child->name }}
			</option>
		@endforeach
	@endforeach
</select>
