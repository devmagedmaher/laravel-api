@extends('layouts.api')


@section('name', 'Upload Profile Picture');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-danger label-lg pull-right">POST</label>
				<h3 class="panel-title">Request: <code>/user/{user_id}/upload-image</code></h3>
				<br><h5>example: <code>/user/23/image</code></h5>
				<br><br>
				<h3 class="panel-title">Alias: <code>/user/{user_id}/image</code></h3>
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
							<td><code>Path</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>User ID</td>
						</tr>
						<tr>
							<td>image</td>
							<td><code>file</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>Profile picture. <br>Must be a jpg, jpeg or png.<br>Must be less than 500kb</td>
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
    "msg": "Image uploaded successfully.",
    "status": true,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">400</span></div>
				<h3 class="panel-title">Error Response. <small>(validation)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Update failed.",
    "status": false,
    "result": [
        {
            "image": [
                "The image must be a file of type: jpg, jpeg, png."
            ]
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">404</span></div>
				<h3 class="panel-title">Error Response. <small>(user id)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "User does not exists.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">403</span></div>
				<h3 class="panel-title">Error Response. <small>(authorization)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Permission denied.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">500</span></div>
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