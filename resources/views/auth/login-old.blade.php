<!DOCTYPE html>
<html lang="en">

<head>
    <title>{!! htmlspecialchars(config('company_info.company_fullname')) !!}</title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--    <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon">--}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/bootstrap.min.css')) !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset(url('css/style.css')) !!}">
    <style>
        body{
            background: #ffffff!important;
        }
    </style>
</head>

<body class="fix-menu">
<!-- Pre-loader start -->

{{--<div class="theme-loader">--}}
{{--    <div class="loader-track">--}}
{{--        <div class="loader-bar"></div>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Pre-loader end -->

<section class="login p-fixed d-flex text-center common-img-bg" style="background: #ffffff!important;">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <div class="login-card card-block auth-body mr-auto ml-auto">
                    <form class="md-float-material" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center">
{{--                            <h2 style="color: white">Magnetism Tech Ltd.</h2>--}}
                            <img src="{{asset('images/ranksfc_log_big.png')}}" alt="RanksFC">
                        </div>
                        <div class="auth-box">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-left txt-primary">Login</h3>
                                </div>
                            </div>
                            <hr/>
                            @error('email') <span class="text-danger text-left mb-5" role="alert"> <strong>{{ $message }}</strong></span>@enderror
                            <div class="input-group mb-1">
                                <input type="email" name="email" class="form-control round @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email here.." required autocomplete="email" autofocus >
                            </div>
                            <div class="input-group mt-3">
                                <input name="password" type="password" class="form-control round @error('password') is-invalid @enderror" placeholder="Password" required>
                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                <span class="md-line"> </span>
                            </div>

                            {{--<div class="input-group">--}}
                                {{--<input type="email" name="email" class="form-control round @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="abc@gmail.com" required autocomplete="email" autofocus >--}}
                                {{--@error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span>@enderror--}}
                                {{--<span class="md-line"></span>--}}
                            {{--</div>--}}
                            {{--<div class="input-group">--}}
                                {{--<input name="password" type="password" class="form-control round @error('password') is-invalid @enderror" placeholder="Password" required>--}}
                                {{--@error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror--}}
                                {{--<span class="md-line"> </span>--}}
                            {{--</div>--}}

                            <hr/>
                            {{--<div class="row m-t-25 text-left">
                                <div class="col-12">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <input type="checkbox" value="">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span class="text-inverse">Remember me</span>
                                        </label>
                                    </div>
                                    <div class="forgot-phone text-right f-right">
                                        <a href="auth-reset-password.html" class="text-right f-w-600 text-inverse"> Forgot Password?</a>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Login</button>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- Authentication card end -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

<script  src="{!! asset(url('js/jquery.min.js')) !!}"></script>
<script  src="{!! asset(url('js/jquery-ui.min.js')) !!}"></script>
<script  src="{!! asset(url('js/popper.min.js')) !!}"></script>
<script  src="{!! asset(url('js/bootstrap.min.js')) !!}"></script>
<script  src="{!! asset(url('js/common-pages.js')) !!}"></script>
</body>

</html>
