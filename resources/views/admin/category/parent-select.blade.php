
<select class="form-control" id="ParentCategory" name="parent">
	<option value="" {{ old('parent') ? '' : 'selected' }}>Set as a parent category</option>
    <option value="" disabled="">________________________________________________</option>
	@foreach ($categories as $category) 

		<option value="{{ $category->id }}" {{ old('parent') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>

	@endforeach
</select>
