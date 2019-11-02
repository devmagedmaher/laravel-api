@php
    // dd(session()->get('errors')->has('code'));
@endphp
@extends('layouts.admin')


@section('name', 'New Language')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        Create new language.
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.language.add') }}" method="post" role="form" enctype="multipart/form-data" class="form-error-focus">

        	@csrf
				
			<div class="form-group @error('code', 'has-error')">
				<label class="control-label" for="LanguageCode">Language ISO Code</label>
				<input type="text" name="code" class="form-control" id="LanguageCode" value="{{ old('code') }}">
                @errorView(['field' => 'code'])
			</div>
			<div class="form-group @error('name', 'has-error')">
				<label class="control-label" for="LanguageName">Language Name</label>
				<input type="text" name="name" class="form-control" id="LanguageName" value="{{ old('name') }}">
                @errorView(['field' => 'name'])
			</div>
            <div class="form-group @error('image', 'has-error')">
                <label class="control-label" for="LanguageImage">Language Image</label>
                <input type="file" name="image" class="form-control" id="LanguageImage">
                @errorView(['field' => 'image'])
            </div>
            @if (session('status'))
                @successView(['msg' => 'Language has been added successfully!'])
        	@endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">Create</button>
            </div>

        </form>
    </div>
</div>


@endsection
