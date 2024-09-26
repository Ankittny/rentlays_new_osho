
<body class="hold-transition login-page">
    <div class="spinner-wrap">
        <div class="spinner-item"></div>
        <div class="spinner-item spinner-item--2"></div>
        <div class="spinner-item spinner-item--3"></div>
        <div class="spinner-item spinner-item--4"></div>
    </div>

    <div class="left_green_shadow"></div>
    <div class="left_blue_shadow"></div>
    <div class="left_red_shadow"></div>

    <div class="">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class') }} text-center mb-0" role="alert">
                {{ Session::get('message') }}
                <a href="javaScript:void(0);" class="pull-right" data-dismiss="alert" aria-label="Close">&times;</a>
            </div>
        @endif
    </div>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}">
            <img src="/public/backend/dist/img/logo.png" alt="">
            </a>
        </div>
        <div class="login-box-body">


        