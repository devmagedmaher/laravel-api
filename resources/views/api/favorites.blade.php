@extends('layouts.api')


@section('name', 'Favorites by user');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-success label-lg pull-right">GET</label>
				<h3 class="panel-title">Request: <code>/user/{user_id}/favorites?lang={lang}</code></h3>
				<br><h5>example: <code>/user/{user_id}/favorites?lang=en</code></h5>
				<br><br>
				<h3 class="panel-title">Aliases: <code>/user/{user_id}/favs</code>
					<br><br>&emsp;&emsp;&emsp; <code>/favorites/{user_id}</code>
					<br><br>&emsp;&emsp;&emsp; <code>/favs/{user_id}</code>
				</h3>
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
							<td><span class="label label-danger">required</code></td>
							<td>User ID</td>
						</tr>
						<tr>
							<td>lang</td>
							<td><code>string</code></td>
							<td><code>Query</code></td>
							<td><span class="label label-success">optional</code></td>
							<td>Language Code in ISO 639-1 format. <br>default value is 'en'</td>
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
    "msg": "Data retrieved successfully.",
    "status": true,
    "result": [
        {
            "id": 1,
            "name": "White Cat",
            "images": "http://link.to/image-1.jpg"
        }, 
        {
            "id": 2,
            "name": "Black Cat",
            "image": "http://link.to/image-1.jpg"
        }
    }
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-info">204</span></div>
				<h3 class="panel-title">Success Response. <small>(favorite)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "No favorites found.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">404</span></div>
				<h3 class="panel-title">Error Response. <small>(user)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "User does not exists",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<!-- END TABLE HOVER -->
	</div>
</div>


@endsection