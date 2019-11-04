@extends('layouts.api')


@section('name', 'Edit Profile');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-danger label-lg pull-right">POST</label>
				<h3 class="panel-title">Request: <code>/user/{user_id}/profile-edit</code></h3>
				<br><h5>alias: <code>/user/29/edit</code></h5>
				<br><br>
				<h3 class="panel-title">Alias: <code>/user/{user_id}/edit</code></h3>
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
							<td>first_name</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>First name</td>
						</tr>
						<tr>
							<td>last_name</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>Last name</td>
						</tr>
						<tr>
							<td>phone</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>
								Phone number. <br>
								allows: plus[+], dash[-] and spaces<br>
								&emsp; 01159848839<br>
								&emsp; 011-598-48-839<br>
								&emsp; +201159848839<br>
								&emsp; +20 115 9848 839<br>
							</td>
						</tr>
						<tr>
							<td>email</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>Email address</td>
						</tr>
					</tbody>
				</table>
				<hr>
				<div class="label label-success">
					NOTE: you are free to provide only fields you want to update.<br>
				</div>
				<br>
				<div class="label label-warning">
					NOTE: if you don't provide any params, you will still get success response<br>
				</div>
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
    "msg": "User updated successfully.",
    "status": true,
    "result": [
        {
            "id": 2,
            "first_name": "Maged",
            "last_name": "Maher",
            "full_name": "Maged Maher",
            "email": "dev.magedmaher@gmail.com",
            "phone": "01159848839",
            "image": "http://link.to/profile-picture.jpg"
        }
    ]
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
            "email": [
                "The email has already been taken."
            ],
            "phone": [
                "The phone format is invalid."
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