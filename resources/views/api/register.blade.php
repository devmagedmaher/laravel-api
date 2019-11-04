@extends('layouts.api')


@section('name', 'Register');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-danger label-lg pull-right">POST</label>
				<h3 class="panel-title">Register Request: <code>/register</code></h3>
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
							<td>first_name</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>First name</td>
						</tr>
						<tr>
							<td>last_name</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
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
							<td><span class="label label-danger">required</span></td>
							<td>Email address</td>
						</tr>
						<tr>
							<td>password</td>
							<td><code>string</code></td>
							<td><code>Body</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>
								Password<br>
								must be at least 6 characters.
							</td>
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
				<div class="pull-right">status code: <span class="label label-success">201</span></div>
				<h3 class="panel-title">Success Response.</h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Registration is successfull.",
    "status": true,
    "result": [
        {
            "id": 2,
            "first_name": "Maged",
            "last_name": "Maher",
            "full_name": "Maged Maher",
            "email": "dev.magedmaher@gmail.com",
            "phone": "01159848839",
            "image": ""
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
    "msg": "Registration failed.",
    "status": false,
    "result": [
        {
            "last_name": [
                "The last name field is required."
            ],
            "email": [
                "The email must be a valid email address."
            ],
            "password": [
                "The password must be at least 6 characters."
            ]
        }
    ]
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