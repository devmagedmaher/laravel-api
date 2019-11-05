@extends('layouts.admin')


@section('name', 'Upload Images')


@section('content')


@if (session('fromItemForm'))
	@successView(['msg' => 'Your item has beed added successfully.'])
@endif	

<div class="panel panel-default">
    <div class="panel-heading">
        Upload Images for "{{ $item->name }}".
		<a href="{{ route('admin.item.edit', ['item' => $item->id]) }}" class="btn btn-default btn-xs pull-right">Edit item</a>
    </div>
    <div class="panel-body">
    @if (!$item->image_remaining)
    	you have 0 image slots in this item.
    @else
    	<form action="{{ route('admin.image.store', ['item' => $item->id]) }}" method="post" enctype="multipart/form-data" class="form-inline">
    		@csrf
    		<div class="form-group">
    			<input type="file" name="images[]" class="form-control-file" multiple>
    		</div>
			<button type="submit" class="btn btn-primary">Upload</button>
			@if (session('uploadSuccess') || session('uploadErrors') || $errors->has('images'))
				<hr>
			@endif
			<div class="form-group {{ $errors->has('images') ? 'has-error' : '' }}">
				@errorView(['field' => 'images'])
			</div>
		</form>
	@endif
    	<br>
		@if (session('uploadErrors'))
			@foreach (session('uploadErrors') as $message)
				<div class="alert alert-danger">{{ $message }}</div>
			@endforeach
		@endif
		@if (session('uploadSuccess'))
			@foreach (session('uploadSuccess') as $message)
				<div class="alert alert-success">{{ $message }}</div>
			@endforeach
		@endif
	</div>
</div>	
	

@if ($item->images->count())

<div class="panel panel-default">
    <div class="panel-heading">
        Images uploaded for this item.
    </div>
    <div class="panel-body">
    @foreach ($item->images as $image)
    	<div class="img-thumbnail">
	    	<img src="{{ $image->url }}">
    		<span class="fa fa-times submit-next-form mouse-pointer remove" title="delete this images"></span>
	    	<form action="{{ route('admin.image.delete', ['image' => $image->id]) }}" method="post" style="display: none">
	    		@method('DELETE')
	    		@csrf
	    	</form>
	    </div>
	@endforeach
	</div>
</div>

@endif


@endsection