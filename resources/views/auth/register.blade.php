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
    <title>vAMSYS - Register Account</title>
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
    <form class="login-form" action="/auth/register" method="post">
        <h3 class="form-title">Register Account</h3>

        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Enter your details below</span>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Email Address</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text"
                   placeholder="Email Address" name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password"
                   placeholder="Password" name="password"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Name</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text"
                   placeholder="First Name" name="first_name"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Name</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text"
                   placeholder="Last Name" name="last_name"/>
        </div>
        <input type="hidden" name="_token" value="<?=csrf_token();?>">
        <div class="form-actions center">
            <button type="submit" class="btn btn-success uppercase">Register</button>
        </div>
    </form>

    <form class="forget-form" action="index.html" method="post">
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