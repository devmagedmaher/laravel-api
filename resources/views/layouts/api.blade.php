<!doctype html>
<html lang="en">

<head>
	<title>API Docs | @yield('name')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('api-assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('api-assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('api-assets/vendor/linearicons/style.css') }}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('api-assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('api-assets/css/demo.css') }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('api-assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('api-assets/img/favicon.png') }}">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/docs"><img src="{{ asset('api-assets/img/logo-dark.png') }}" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li>
							<a class="mouse-pointer"><i class="fa fa-users"></i> <span>User</span></a>
							<div>
								<ul class="nav">
									<li><a href="/docs/login" class="">Login &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
									<li><a href="/docs/register" class="">Register &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
									<li><a href="/docs/edit-profile" class="">Edit Profile &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
									<li><a href="/docs/upload-profile-picture" class="">Upload Picture &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a class="mouse-pointer"><i class="fa fa-cubes"></i> <span>Category & Item</span></a>
							<div>
								<ul class="nav">
									<li><a href="/docs/categories" class="">Categories &nbsp; <span class="label label-success label-xs">GET</span></a></li>
									<li><a href="/docs/items" class="">Items &nbsp; <span class="label label-success label-xs">GET</span></a></li>
									<li><a href="/docs/item-details" class="">Item Details &nbsp; <span class="label label-success label-xs">GET</span></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a class="mouse-pointer"><i class="fa fa-star"></i> <span>Favorite</span></a>
							<div>
								<ul class="nav">
									<li><a href="/docs/favorites" class="">Favorites &nbsp; <span class="label label-success label-xs">GET</span></a></li>
									<li><a href="/docs/add-favorite" class="">Add Fovorite &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
									<li><a href="/docs/remove-favorite" class="">Remove Favorite &nbsp; <span class="label label-danger label-xs">POST</span></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h5 class="">API base url: <code>{{ config('app.url') }}/api</code></h5>
					<h1 class="page-title">@yield('name')</h1>
				

					@yield('content')


				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<script src="{{ asset('api-assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('api-assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('api-assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('api-assets/scripts/klorofil-common.js') }}"></script>
	<!-- Javascript -->
	<script>
	$(document).ready(function() {
	  $('pre code').each(function(i, block) {
		hljs.highlightBlock(block);
	  });
	  $('.nav').find('a').each(function(i, e) {
	  	if (this.href == window.location.href){
		  	$(this).addClass('active');
	  	}
	  });
	});
	</script>
</body>

</html>
