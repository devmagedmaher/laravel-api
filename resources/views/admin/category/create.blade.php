@extends('layouts.admin')


@section('name', 'New Category')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        Create new category.
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3">
                @include('admin.lang-tabs', [
                    'langs' => $langs,
                    'checkedLangs' => []
                ])
            </div>
            <div class="col-sm-9">
                <form action="{{ route('admin.category.add') }}" method="post" role="form" enctype="multipart/form-data">
                	@csrf
                    <div class="tab-content">
                    @foreach($langs as $lang)
                        <div role="tabpanel" class="tab-pane fade in {{ $lang->code == 'en' ? 'active' : ''}}" id="tab-{{ $lang->code }}">
                            <div class="form-group">
                                Entry Language: {{ $lang->name }} ({{ $lang->code }})
                                @if ($lang->hasImage())
                                    <img src="{{ $lang->image_url }}" title="{{ $lang->name }}">
                                @endif
                            </div>
                            <hr>
                            <div class="form-group">
                            	<input type="hidden" value="{{ $lang->id }}" name="language[{{ $lang->code }}]">
                            </div>
                            <div class="form-group {{ $errors->has('name.'.$lang->code) ? 'has-error' : ''}}">
                                <label for="CategoryName" class="control-label">Name</label>
                                <input type="text" class="form-control" id="CategoryName" placeholder="Category Name" 
                                value="{{ old('name.'.$lang->code) }}" name="name[{{ $lang->code }}]">
                                @errorView(['field' => "name.$lang->code"])
                            </div>
                            <div class="form-group {{ $errors->has('description.'.$lang->code) ? 'has-error' : ''}}">
                                <label for="CategoryDescription" class="control-label">Description</label>
                                <textarea class="form-control" id="CategoryDescription" placeholder="Description" name="description[{{ $lang->code }}]">{{ old('description.'.$lang->code) }}</textarea>
                                @errorView(['field' => "description.$lang->code"])
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <hr>
                    <div class="form-group @error('image', 'has-error')">
                        <label class="control-label" for="LanguageImage">Image</label>
                        <input type="file" name="image" class="file-control" id="LanguageImage">
                        @errorView(['field' => 'image'])
                    </div>
                    {{-- <div class="form-group {{ $errors->has('parent') ? 'has-error' : ''}}">
                    	<label for="ParentCategory" class="control-label">Parent (optional)</label>
                        @include('admin.category.parent-select', ['categories' => $categories])
                        @errorView(['field' => 'parent'])
                    </div> --}}
                    @if (session('status'))
                        @successView(['msg' => 'category has been added successfully.'])
                	@endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
