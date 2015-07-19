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
    <title>vAMSYS - Reset Password</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="login">
<div class="menu-toggler sidebar-toggler">
</div>
<div class="logo">
    <a href="/">
            <img src="/img/logo-subtitle.png" alt="vAMSYS" height="91" width="400" />
    </a>
</div>
<div class="content">
    <form class="login-form" action="/password/reset" method="post">
        <h3 class="form-title">Reset Password</h3>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">New Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text"
                   placeholder="Email Address" name="email" value="{{ old('email') }}"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">New Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="New Password" name="password"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Repeat Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="Repeat Password" name="password_confirmation"/>
        </div>
        <div class="form-actions">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-info uppercase">Reset Password</button>
        </div>
    </form>

    <form class="forget-form" action="/auth/forgot-password" method="post">
        <h3>Reset Password</h3>
        <p>
            Enter your e-mail address below to reset your password.
        </p>

        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                   name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">Back</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
        </div>
    </form>
</div>
<div class="copyright">
    © 2015 vAMSYS. All Rights Reserved.
</div>
<!--[if lt IE 9]>
<script src="/js/vendor/respond.min.js"></script>
<script src="/js/vendor/excanvas.js"></script>
<![endif]-->
<script src="//maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script src="{{ elixir("js/combined.js") }}" type="text/javascript"></script>
<script src="/vendor/js/metronic/layout/pages/login.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        //Metronic.init(); // init metronic core components
        //Layout.init(); // init current layout
        Login.init();
    });
</script>
</body>
</html>
