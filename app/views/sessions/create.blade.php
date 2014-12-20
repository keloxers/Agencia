<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
	<meta charset="utf-8" />
	<title>Notebook | Web Application</title>
	<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" href="css/app.v2.css" type="text/css" />
	<link rel="stylesheet" href="css/font.css" type="text/css" cache="false" />
	<!--[if lt IE 9]>
	<script src="js/ie/html5shiv.js" cache="false"></script>
	<script src="js/ie/respond.min.js" cache="false"></script>
	<script src="js/ie/excanvas.js" cache="false"></script>
	<![endif]-->
</head>
<body>

	<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
		<div class="container aside-xxl">
			<a class="navbar-brand block" href="/">Codex</a>
			<section class="panel panel-default bg-white m-t-lg">
				<header class="panel-heading text-center"> <strong>Sign in</strong>
				</header>
				{{ Form::open(array('route' => 'sessions.store', 'class' => 'panel-body wrapper-lg')) }}
				
					<div class="form-group">
						<label class="control-label">Email</label>
						{{ Form::text('email', '', array('class' => 'form-control input-lg', 'placeholder' => '')) }}<br>
						{{ $errors->first('email') }}
					<div class="form-group">
						<label class="control-label">Password</label>
						{{ Form::password('password', array('class' => 'form-control input-lg', 'placeholder' => '')) }}<br>
						{{ $errors->first('password') }}
						{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
					<div class="line line-dashed"></div>
					<p class="text-muted text-center">
						<small>No tienes cuenta ?</small>
					</p>
					<a href="/users/create" class="btn btn-default btn-block">Crear una cuenta</a>
				{{ Form::close() }}
			</section>
		</div>
	</section>
	<!-- footer -->
	<footer id="footer">
		<div class="text-center padder">
			<p>
				<small>
					CodexControl.com
					<br>&copy; 2013</small>
			</p>
		</div>
	</footer>
	<!-- / footer -->
	<script src="js/app.v2.js"></script>
	<!-- Bootstrap -->
	<!-- App -->

</body>
</html>
