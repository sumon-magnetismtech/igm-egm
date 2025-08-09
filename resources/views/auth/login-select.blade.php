<!DOCTYPE html>
<html lang="en">

<head>
    <title> Magnetism Tech Ltd</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <style>
        /* Full rounded card */
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
            border-radius: 50px;
            /* Fully rounded corners */
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
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

        /* Ensure cards are vertically centered */
        .login {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Makes sure the section takes full screen height */
            padding: 20px;
            /* Prevents touching screen edges */
        }


        /* Responsive styles */
        @media (max-width: 768px) {
            .square-card {
                height: 60px;
                font-size: 16px;
                border-radius: 40px;
            }
        }

        @media (max-width: 480px) {
            .square-card {
                height: 50px;
                font-size: 14px;
                border-radius: 30px;
            }
        }
    </style>
</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login bg-primary" style="background-image: url('{{ asset("img/igm-egm_bg.png") }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <a href="{{ route('igm-dashboard') }}">
                                <div class="card square-card">
                                    <span>IMPORT GENERAL MANIFEST (IGM)</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('egm-dashboard') }}">
                                <div class="card square-card">
                                    <span>EXPORT GENERAL MANIFEST (EGM)</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/common-pages.js') }}"></script>
</body>

</html>
