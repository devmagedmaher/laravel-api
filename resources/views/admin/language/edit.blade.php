
@extends('layouts.admin')


@section('name', 'Edit Language')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        Edit "{{ $language->name }}" language.
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.language.update', ['language' => $language->id]) }}" method="post" role="form" enctype="multipart/form-data">

            @method('PATCH')
        	@csrf
				
			<div class="form-group @error('code', 'has-error')">
				<label class="control-label" for="LanguageCode">Language ISO Code</label>
				<input type="text" name="code" class="form-control" id="LanguageCode" value="{{ old('code', $language->code) }}">
                @errorView(['field' => 'code'])
			</div>
			<div class="form-group @error('name', 'has-error')">
				<label class="control-label" for="LanguageName">Language Name</label>
				<input type="text" name="name" class="form-control" id="LanguageName" value="{{ old('name', $language->name) }}">
                @errorView(['field' => 'name'])
			</div>
            <div class="form-group @error('image', 'has-error')">
                <label class="control-label" for="LanguageImage">Language Image</label>
                @if ($language->hasImage())
                    <sub>
                        (current image: <img src="{{ $language->image_url }}" title="{{ $language->name }}" class="flag flag-sm"> )
                    </sub>
                @endif
                <input type="file" name="image" class="form-control" id="LanguageImage">
                @errorView(['field' => 'image'])
            </div>
            @if (session('status'))
                @successView(['msg' => 'Language has been updated successfully!'])
        	@endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
            </div>

        </form>
    </div>
</div>


@endsection
