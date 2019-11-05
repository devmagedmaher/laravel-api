@extends('layouts.api')


@section('name', 'Items by category');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-success label-lg pull-right">GET</label>
				<h3 class="panel-title">Request: <code>/category/{category_id}/items?lang={lang}&user={user}</code></h3>
				<br><h5>example: <code>/category/3/items?lang=en&user=2</code></h5>
				<br><br>
				<h3 class="panel-title">Aliases: <code>/category/{category_id}/items</code>
				<br><br>&emsp;&emsp;&emsp; <code>/cat/{category_id}/items</code>
				<br><br>&emsp;&emsp;&emsp; <code>/items/{category_id}/</code>

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
							<td>category_id</td>
							<td><code>integer</code></td>
							<td><code>Path</code></td>
							<td><span class="label label-danger">required</span></td>
							<td>Category ID</td>
						</tr>
						<tr>
							<td>lang</td>
							<td><code>string</code></td>
							<td><code>Query</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>Language Code in ISO 639-1 format. <br>default value is 'en'</td>
						</tr>
						<tr>
							<td>user</td>
							<td><code>integer</code></td>
							<td><code>Query</code></td>
							<td><span class="label label-success">optional</span></td>
							<td>User ID. if not provided, "has_favorite" property will return false only.</td>
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
            "name": "white cat",
            "has_favorite": false,
            "image": "http://link.to/item-image.jpeg"
        },
        {
            "id": 2,
            "name": "Black Cat",
            "has_favorite": false,
            "image": ""
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-info">204</span></div>
				<h3 class="panel-title">Success Response. <small>(item)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "No items found.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-danger">404</span></div>
				<h3 class="panel-title">Error Response. <small>(category)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "Category does not exist.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<!-- END TABLE HOVER -->
	</div>
</div>


@endsection