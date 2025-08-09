<!DOCTYPE html>
<html lang="en">

<head>
    <title> Magnetism Tech Ltd </title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--    <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon"> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body class="fix-menu">
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="loader-track">
        <div class="loader-bar"></div>
    </div>
</div>
<!-- Pre-loader end -->

<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                        <div class="text-center d-none d-lg-block">
                            <img src="{{ asset('/img/Magnetism-Logo.png') }}" height="100px" alt="logo.png" style="margin-right: .7rem;">
                            <img src="{{ asset('/img/ctgport.png') }}" width="100px" alt="logo.png">
                        </div>

                <!-- Authentication card start -->
                <div class="login-card card-block auth-body mr-auto ml-auto">
                    <form class="md-float-material" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center d-none d-lg-block">
                            <h2 style="color:white;">Shipping and Logistics Online Desk</h2>
                        </div>
                        {{-- <div class="d-flex justify-content-between align-items-center w-100" style="max-width: 500px; margin: 0 auto;">
                            <div style="">
                                <img src="{{ asset('/img/Magnetism-Logo.png') }}" style="height: 100px; width: auto; max-width: 100%;" alt="logo.png">
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <img src="{{ asset('/img/ctgport.png') }}" style="width: 100px; height: auto; max-width: 100%;" alt="logo.png">
                            </div>
                        </div> --}}
                        <div class="auth-box">
                            <div class="row m-b-20">
                                <div class="col-md-12 d-flex justify-content-between align-items-center w-100">
                                    <h3 class="text-left txt-primary">Sign In</h3>
                                    {{-- <div style="">
                                        <img src="{{ asset('/img/Magnetism-Logo.png') }}" style="height: 40px; width: auto; max-width: 100%;" alt="logo.png">
                                        <img src="{{ asset('/img/ctgport.png') }}" style="width: 40px; height: auto; max-width: 100%;" alt="logo.png">
                                    </div> --}}
                                </div>
                            </div>
                            <hr/>
                            @error('email')
    <span class="text-danger text-left mb-5" role="alert"> <strong>{{ $message }}</strong></span>
@enderror
                            <div class="input-group mb-1">
                                <input type="email" name="email" class="form-control round @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email here.." required autocomplete="email" autofocus >
                            </div>
                            <div class="input-group mt-3">
                                <input name="password" type="password" class="form-control round @error('password') is-invalid @enderror" placeholder="Password" required>
                                @error('password')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
@enderror
                                <span class="md-line"> </span>
                            </div>
                            <hr/>
                            {{-- <div class="row m-t-25 text-left">
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
                            </div> --}}
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign In</button>
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

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/common-pages.js') }}"></script>
</body>

</html>
