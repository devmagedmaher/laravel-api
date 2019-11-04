@extends('layouts.api')


@section('name', 'Categories');


@section('content')


<div class="row">
	<div class="col-md-7">
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<label class="label label-success label-lg pull-right">GET</label>
				<h3 class="panel-title">Request: <code>/categories?lang={lang}</code></h3>
				<br><h5>example: <code>/categories?lang=en</code></h5>
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
							<td>lang</td>
							<td><code>string</code></td>
							<td><code>Query</code></td>
							<td><span class="label label-success">optional</span></td>
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
            "name": "Cats",
            "image": "http://link.to/image.jpg"
        },
        {
            "id": 2,
            "name": "Dogs",
            "image": ""
        },
        {
            "id": 3,
            "name": "Birds",
            "image": "http:://link.to/another-image.png"
        }
    ]
}</pre>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<div class="pull-right">status code: <span class="label label-info">204</span></div>
				<h3 class="panel-title">Success Response. <small>(category)</small></h3>
			</div>
			<div class="panel-body">
<pre>{
    "msg": "No categories found.",
    "status": false,
    "result": []
}</pre>
			</div>
		</div>

		<!-- END TABLE HOVER -->
	</div>
</div>


@endsection