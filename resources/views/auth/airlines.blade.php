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
    <title>vAMSYS - Choose Airline</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
    <link rel="stylesheet" href="{{ elixir("css/login.css") }}">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="login">
<div class="menu-toggler sidebar-toggler">
</div>
<div class="logo">
    <a href="/">
        <img src="//placehold.it/400x150.png&text=Airline+Logo+Here" alt=""/>
    </a>
</div>
<div class="content">
        <h3 class="form-title">Choose Airline</h3>

        <div class="alert alert-success">
            <span>Which airline do you want to sign in with?</span>
        </div>

        <div class="form-group">
            @foreach($user->pilots as $pilot)
                <a href="/auth/airlines/{{ $pilot->airline->id }}">{{ $pilot->airline->name }}</a><br />
            @endforeach
        </div>
</div>
<div class="copyright">
    © 2015 vAMSYS. All Rights Reserved.
</div>
<!--[if lt IE 9]>
<script src="/js/vendor/respond.min.js"></script>
<script src="/js/vendor/excanvas.js"></script>
<![endif]-->
<script src="{{ elixir("js/all.js") }}" type="text/javascript"></script>
<script src="{{ elixir("js/login.js") }}" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
    });
</script>
</body>
</html>