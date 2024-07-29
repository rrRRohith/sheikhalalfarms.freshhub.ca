<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshHub Sign-in</title>

    <!-- main css -->
    <link rel="stylesheet"
          href="/vendors/clarity-ui/css/clarity-ui.min.css?v=2.1">
    <link rel="stylesheet" href="/css/main.min.css?v=2.1">
    <link rel="stylesheet" href="/css/style.css">
    <!-- favicon css -->
    <link rel="shortcut icon" href="/img/favicon/favicon.ico?v=2.1"
          type="image/x-icon">
    <link rel="icon" href="/img/favicon/favicon.ico?v=2.1" type="image/x-icon">
</head>
<body class="h-100 ">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-6 h-100 hidden-sm-down">
                <div class="row h-100 bg-success">
                    <div class="col-sm-4 offset-sm-4 h-100 vertical-align">
                        <div class="img-circle vertical-align-content">
                            <div class="img-circle-content">
                                <img src="/img/login.svg" alt="cloud login">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 h-100">
                <div class="row h-100">
                    <div class="col-sm-8 admin_signin h-100 flex-items-sm-center vertical-align">
                        <div class="form vertical-align-content">
                            <div class="logo text-center padding-side-30">
                                <img src="/img/freshhub_logo.png" alt="FreshHub logo">
                            </div>
                            <div>
                                {!!session('message')!!}
                                <form method="POST" action="{{url()->route('login')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <input type="text" id="aName" class="form-control input-light"
                                                value=""
                                                name="email" placeholder="Username or E-mail...">
                                                                                </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <input type="password" id="aFamily" name="password"
                                                class="form-control input-light" placeholder="Password...">
                                                                                </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <button class="btn btn-success btn-block">Login</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <a class="btn-block" href="{{url('forgotpassword')}}">Forgot Password</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="copyright-text">
                        <p>Copyright © 2020-2021 Fresh<span>Hub</span>. All rights reserved. | Version: 1.0</p>                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
