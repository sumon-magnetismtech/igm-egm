<!DOCTYPE html>
<html lang="en">

<head>
    <title>Magnetism Tech Ltd </title>
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
<style>
    .square-card {
        width: 100%;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        background: #e0f2e9;
        border-radius: 38px;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .square-card span {
        z-index: 1;
        position: relative;
    }

    .square-card:hover {
        background: #d1ead8;
    }

    .square-card:first-child {
        background: white;
        color: #5EA9FF;
    }

    .square-card:first-child span {
        font-weight: bold;
    }


</style>

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
        <div class="row ml-5 mr-5">
            <div class="col-6 offset-3 ">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('igm-dashboard') }}">
                            <div class="card square-card ">
                                <span>IMPORT GENERAL MANIFEST (IGM)</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12">
                        <a href="{{ route('egm-dashboard') }}">
                            <div class="card square-card">
                                <span>EXPORT GENERAL MANIFEST (EGM)</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
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
