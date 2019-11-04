@extends('layouts.admin')


@section('name', 'New Item')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        Create new item.
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
                <form action="{{ route('admin.item.add') }}" method="post" role="form" enctype="multipart/form-data">
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
                                <label for="ItemName" class="form-lebel">Name</label>
                                <input type="text" class="form-control" id="ItemName" placeholder="Item Name" 
                                value="{{ old('name.'.$lang->code) }}" name="name[{{ $lang->code }}]">
                                @errorView(['field' => "name.$lang->code"])
                            </div>
                            <div class="form-group {{ $errors->has('description.'.$lang->code) ? 'has-error' : ''}}">
                                <label for="ItemDescription" class="control-label">Description</label>
                                <textarea class="form-control" id="ItemDescription" placeholder="Description" name="description[{{ $lang->code }}]">{{ old('description.'.$lang->code) }}</textarea>
                                @errorView(['field' => "description.$lang->code"])
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <hr>
                    <div class="form-group @error('price', 'has-error')">
                        <label for="ItemPrice" class="control-label">Price</label>
                        <input type="number" class="form-control" id="ItemPrice" placeholder="Price" value="{{ old('price') }}" name="price" >
                        @errorView(['field' => "price"])
                    </div>
                    <div class="form-group @error('category', 'has-error')">
                        <label for="ParentCategory" class="control-label">Category</label>
                        @include('admin.category-select', ['categories' => $categories])
                        @errorView(['field' => 'category'])
                    </div>
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
