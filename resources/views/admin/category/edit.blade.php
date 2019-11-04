@extends('layouts.admin')


@section('name', 'Update Category')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        @if ($category->isParent())
            Edit "{{ $category->name }}" category.
        @else
            Edit "{{ $category->name }}" sub category of 
            <a href="{{ route('admin.category.edit', ['category' => $category->parent->id]) }}">{{ $category->parent->name }}</a>
        @endif
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.category.update', ['category' => $category->id]) }}" method="post" role="form" enctype="multipart/form-data">

            @method('PATCH')
            @csrf
        
            <div class="row">
                @if ($errors->has('language'))
                    <div class="col-sm-12">
                        <div class="alert alert-warning">You didn't select the language which will be updated.</div>
                    </div>
                @endif
                <div class="col-sm-3">
                    @include('admin.lang-tabs', [
                        'langs' => $langs,
                        'checkedLangs' => $category->checked_langs
                    ])
                </div>
                <div class="col-sm-9">
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
                                <input type="hidden" {!! $lang->code == 'en' ? 'name="language['.$lang->code.']"' : 'disabled' !!} value="{{ $lang->id }}" data-name="language[{{ $lang->code }}]">
                            </div>
                            <div class="form-group {{ $errors->has('name.'.$lang->code) ? 'has-error' : ''}}">
                                <label for="CategoryName" class="form-lebel">Category Name</label>
                                <input type="text" class="form-control" id="CategoryName" placeholder="Category Name" 
                                value="{{ old('name.'.$lang->code) ? old('name.'.$lang->code) : $category->lang($lang->id)->name }}" data-name="name[{{ $lang->code }}]" 
                                {!! $lang->code == 'en' || $lang->code == old('langCheck') ? 'name="name['.$lang->code.']"' : 'disabled' !!}>
                                @if ($errors->has('name.'.$lang->code))
                                    <span id="helpBlock2" class="help-block">{{ $errors->get('name.'.$lang->code)[0] }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('description.'.$lang->code) ? 'has-error' : ''}}">
                                <label for="CategoryDescription" class="control-label">Category Description</label>
                                <textarea class="form-control" id="CategoryDescription" placeholder="Description" 
                                {!! $lang->code == 'en' || $lang->code == old('langCheck') ? 'name="description['.$lang->code.']"' : 'disabled' !!} data-name="description[{{ $lang->code }}]">{{ old('description.'.$lang->code) ? old('description.'.$lang->code) : $category->lang($lang->id)->description }}</textarea>
                                @if ($errors->has('description.'.$lang->code))
                                    <span id="helpBlock2" class="help-block">{{ $errors->get('description.'.$lang->code)[0] }}</span>
                                @endif
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
                        <label for="ParentCategory" class="control-label">Parent Category</label>
                        <select class="form-control" id="ParentCategory" name="parent">
                            <option value="" {{ old('parent') ? '' : 'selected' }}>Choose Parent Category (optional)</option>
                            @foreach ($categories as $cat) 

                                <option value="{{ $cat->id }}" 
                                @if (old('parent'))
                                    @if (old('parent') == $cat->id)
                                        selected
                                    @endif
                                @elseif ($category->parent_id == $cat->id) 
                                    selected 
                                @endif
                                >{{ $cat->name }}</option>

                            @endforeach
                        </select>
                        @if ($errors->has('parent'))
                            <span id="helpBlock2" class="help-block">{{ $errors->get('parent')[0] }}</span>
                        @endif
                    </div> --}}
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Category has been updated successfully!
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>












@if ($category->hasChildren())

<div class="panel panel-default">
    <div class="panel-heading">
        Edit sub categoires
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>items</th>
                        <th>control</th>
                        <th>languages</th>
                    </tr>
                </thead>
                <tbody>
                {{-- <form action="" method="post" role="form"> --}}
                @foreach ($category->children as $child)
                    <tr>
                        <td>
                            {{ $child->name }} 
                        </td>
                        <td>{{ $child->items->count() }}</td>
                        <td>
                            <a class="btn btn-default btn-xs" href="{{ route('admin.category.edit', ['category' => $child->id]) }}">edit</a>

                            <a class="btn btn-{{ $child->entries ? 'danger' : 'default' }} btn-xs submit-next-form">delete</a>
                            <form action="{{ route('admin.category.delete', ['category' => $child->id]) }}" method="post" style="display: none">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                        <td>
                        @foreach ($child->languages as $language)
                            @if ($language->image)
                                <img src="{{ $language->image_url }}" alt="{{ $language->code }}" title="{{ $language->name }}"> 
                            @else
                                [{{ $language->code }}]
                            @endif
                        @endforeach 
                        </td>
                    </tr>
                @endforeach
                {{-- </form> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif


@endsection
