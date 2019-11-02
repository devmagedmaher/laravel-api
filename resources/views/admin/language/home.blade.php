@extends('layouts.admin')


@section('name', 'View Languages')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        View all languages.
    </div>
    <div class="panel-body">

    	<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>code</th>
						<th>image</th>
						<th>name</th>
						<th>categories</th>
						<th>items</th>
						<th>control</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($languages as $language) 
					@include('admin.language.row', ['language' => $language])
				@endforeach
				</tbody>
			</table>            		
    	</div>

	</div>
</div>


@endsection