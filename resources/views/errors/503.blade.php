<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>vAMSYS - Error</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
		  type="text/css"/>
	<link rel="stylesheet" href="{{ elixir("css/app.css") }}">
	<link rel="stylesheet" href="{{ elixir("css/error.css") }}">
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="login">
<body class="page-500-full-page">
<div class="row">
	<div class="col-md-12 page-500">
		<div class=" number">
			503
		</div>
		<div class=" details">
			<h3>Maintenance</h3>
			<p>
				Hold tight, we're just upgrading some parts of the system!<br/>
				Please check our status page for more information<br/><br/>
			</p>
		</div>
	</div>
</div>
<!--[if lt IE 9]>
<script src="/js/vendor/respond.min.js"></script>
<script src="/js/vendor/excanvas.js"></script>
<![endif]-->
<script src="{{ elixir("js/all.js") }}" type="text/javascript"></script>
<script>
	jQuery(document).ready(function () {
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
	});
</script>
</body>
</html>