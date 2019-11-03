@extends('layouts.admin')


@section('name', 'View Categories')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        View all category.
    </div>
    <div class="panel-body">
		<div class="table-responsive">
		    <table id="tree-table" class="table table-hover table-striped">
		        <thead>
		            <tr>
		                <th>name</th>
		                <th>items</th>
		                <th>image</th>
		                <th>control</th>
		                <th>languages</th>
		            </tr>
		        </thead>
		        <tbody>
		            {{-- <form action="" method="post" role="form"> --}}
		                @foreach ($categories as $category)
			                @include('admin.category.row', ['category' => $category])
			                @foreach ($category->children as $child)
				                @include('admin.category.row', ['category' => $child])
			                @endforeach
		                @endforeach
		            {{-- </form> --}}
		        </tbody>
		    </table>
		</div>
	</div>
</div>

@endsection