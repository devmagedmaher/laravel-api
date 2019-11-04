@extends('layouts.api')


@section('name', 'Remove favorite');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-danger label-lg pull-right">POST</label>
				<h3 class="panel-title">Request: <code>/favorite/remove</code></h3>
				<br><br>
				<h3 class="panel-title">Aliases: <code>/fav/remove</code>
				<br><br>&emsp;&emsp;&emsp; <code>/fav/rm</code></h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Parameter</th>
							<th>Type</th>
							<th>Position</th>
							<th>#</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>user_id</td>
							<td><code>integer</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</code></td>
							<td>User ID</td>
						</tr>
						<tr>
							<td>item_id</td>
							<td><code>integer</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</code></td>
							<td>Item ID</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END TABLE HOVER -->
	</div>
	<div class="col-md-5">
		<!-- TABLE HOVER -->

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-success">200</span></div>
				<h3 class="panel-title">Success Response.</h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Favorite removed successfully.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">400</span></div>
				<h3 class="panel-title">Error Response. <small>(item|user)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Validation failed.",
    "status": false,
    "result": [
        {
            "user": "The `user` parameter is missing."
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">404</span></div>
				<h3 class="panel-title">Error Response. <small>(item|user)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Add favorite failed.",
    "status": false,
    "result": [
        {
            "item": "Item does not exist."
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">404</span></div>
				<h3 class="panel-title">Error Response. <small>(favorite)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Favorite does not exists.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-warning">500</span></div>
				<h3 class="panel-title">Error Response. <small>(server)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Server failed.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<!-- END TABLE HOVER -->
	</div>
</div>


@endsection