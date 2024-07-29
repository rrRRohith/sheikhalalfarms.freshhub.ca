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
                    <div class="col-sm-8 admin_signout offset-sm-4 h-100 vertical-align">
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
                    <div class="col-sm-8 admin_signout h-100 flex-items-sm-center vertical-align">
                        <div class="form vertical-align-content">
                            <div class="logo text-center padding-side-30">
                                <img src="/img/freshhub_logo.png" alt="FreshHub logo">
                            </div>
                            <h3 class="bg-success">You are succesfully logged out</h3>
                            <br>
                               <a  class="text-center" href="{{url('/')}}"><button class="btn btn-success text-center">Login Again</button></a>
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
