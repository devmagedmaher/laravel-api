@extends('layouts.api')


@section('name', 'Login');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-danger label-lg pull-right">POST</label>
				<h3 class="panel-title">Login Request: <code>/login</code></h3>
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
							<td>email</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>Email address</td>
						</tr>
						<tr>
							<td>password</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>Password</td>
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
    "msg": "Login is successfull.",
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
    "msg": "Login failed.",
    "status": false,
    "result": [
        {
            "email": [
                "The email field is required."
            ],
            "password": [
                "The password field is required."
            ]
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">403</span></div>
				<h3 class="panel-title">Error Response. <small>(authentication)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Credentials are incorrect.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<!-- END TABLE HOVER -->
	</div>
</div>


@endsection