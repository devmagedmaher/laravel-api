@extends('layouts.admin')


@section('name', 'View Items')


@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        View all items.
    </div>
    <div class="panel-body">
		<div class="table-responsive">
		    <table class="table table-hover table-striped">
		        <thead>
		            <tr>
		                <th>name</th>
		                <th>category</th>
		                <th>images</th>
		                <th>control</th>
		                <th>languages</th>
		            </tr>
		        </thead>
		        <tbody>
		            {{-- <form action="" method="post" role="form"> --}}
	            	@foreach ($items as $item)
		            	@include('admin.item.row', ['item' => $item])
		           	@endforeach
		            {{-- </form> --}}
		        </tbody>
		    </table>
		</div>
	</div>
</div>


@endsection