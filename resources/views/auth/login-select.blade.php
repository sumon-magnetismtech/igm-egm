<!DOCTYPE html>
<html lang="en">
<head>
    <title>QC Logistics </title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--    <link rel="icon" href="../files/assets/images/favicon.ico" type="image/x-icon">--}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<style>
    .square-card {
    width: 230px; /* Adjust size as needed */
    height: 230px; /* Same as width to make it square */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-weight: bold;
    font-size: 24px;
    margin: auto;
    border: 1px solid #ddd; /* Optional: add a border */
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); /* Optional: add a shadow */
    color: #5EA9FF;
}
.square-card span {
    font-size: 70px;
    color: #5EA9FF;
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
            <div class="col-sm-6">
                <a href="{{ route('igm-dashboard') }}">
                    <div class="card square-card">
                        <span>IGM</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="#">
                    <div class="card square-card">
                        <span>EGM</span>
                    </div>
                </a>
            </div>
        </div>        
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/common-pages.js')}}"></script>
</body>

</html>
