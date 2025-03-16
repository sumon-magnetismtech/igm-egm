<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LCL Container Untuffing </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 14px;
        }

        body p {
            margin-top: 1px;
            margin-bottom: 1px;
        }

        header {}

        .overFlow {
            overflow: hidden;
        }

        .logo {
            top: 5px;
            left: 0;
        }

        .textUpper {
            text-transform: uppercase;
        }

        .textCenter {
            text-align: center;
        }

        .textLeft {
            text-align: left;
        }

        .textRight {
            text-align: right;
        }

        .pullLeft {
            float: left;
            width: 55%;
            display: block;
        }

        .pullRight {
            float: right;
            width: 35%;
            display: block;
        }

        .pullLeft,
        .pullRight {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .mrTB {
            margin-top: 8px;
            margin-bottom: 8px
        }

        .page_break {
            page-break-after: always;
        }

        #companyName {
            font-size: 36px;
            font-family: 'Book Antiqua', arial;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 36px;
            font-weight: normal;
        }

        #tableArea {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table,
        table th,
        table td {
            border-spacing: 0;
            border: 1px solid #000000;
            border-collapse: collapse;
            font-size: 10px;
            text-align: center;
        }

        th {
            text-align: left;
        }

        table th,
        table td {
            padding: 3px;
        }

        #doInfo {
            border: 1px solid #000;
        }

        #doInfo p {
            border-top: 1px solid #000;
            padding: 5px;
        }

        #flotNone {
            margin: 0 auto;
            display: block;
            text-align: center;
            width: 40%;
        }

        #containerInfoTable {
            margin-bottom: 15px;
        }

        #containerInfoTable,
        #containerInfoTable td {
            border: none;
            font-size: 12px;
            text-align: left !important;
            padding: 7px 3px;

        }

        #containerInfoTable tr td:first-child {
            width: 40%;
        }

        #containerInfoTable td {
            width: 30%;
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
            display: block;
            font-size: 9px;
        }

        .footer-top {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
            display: block;
            font-size: 9px;
        }
    </style>
</head>

<body>
    @foreach ($containerGroups as $key => $containerGroup)
        <header class="overFlow">
            <div class="logo">
                <img src="{{ public_path('img/logo.jpeg') }}" alt="Logo">
            </div>
            <div id="brand" style="margin-top: -80px" class="textCenter">
                <h1 id="companyName"> Magnetism Tech Ltd </h1>
                <p><small>Admin Future Park, 5th Floor, Barik Building, Chittagong. Tel : +88 02333315926-7.</small></p>
            </div>
            <hr width="100%">
        </header>

        {{-- <div class="footer-top"> --}}
        {{-- <p> --}}
        {{-- Received By --}}
        {{-- </p> --}}
        {{-- </div> --}}

        {{-- <footer> --}}
        {{-- <p> --}}
        {{-- <strong> IGM No. {{$masterbl->id}} </strong> --}}
        {{-- <span style="margin-left: 130px"> Print Time: {{date('d-M-y H:i:s a', strtotime(now()))}}</span> --}}
        {{-- <span style="margin-left: 70px"> Software Developed By <strong> Magnetism Tech Ltd</strong>, Cell: +88 01717 103 605 </span> --}}
        {{-- </p> --}}
        {{-- </footer> --}}

        <h3 class="textCenter" style="text-decoration: underline;"> LCL CONTAINER UN-STUFFING WORKING SHEET</h3>

        <div class="containerInfo">
            <table width="100%" id="containerInfoTable">
                <tr>
                    <td colspan="2"> NAME OF THE VESSEL M.V.: <strong>{{ $masterbl->fvessel }}</strong></td>
                    <td> IMPT. ROT. NO.: <strong> {{ $masterbl->rotno }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2"> A/C : <strong>{{ $masterbl->principal }}</strong></td>
                    <td> ARRIVAL DATE :
                        <strong>{{ $masterbl->arrival ? date('d-m-Y', strtotime($masterbl->arrival)) : null }}</strong>
                    </td>
                </tr>
                <tr>
                    <td> CONTAINER NO: <strong>{{ $containerGroup[0]->contref }}</strong> </td>
                    <td> SIZE: <strong>{{ $containerGroup[0]->type }}</strong> </td>
                    <td> SEAL: <strong>{{ $containerGroup[0]->sealno }}</strong> </td>
                </tr>
                <tr>
                    <td> UN-STUFFING DATE: _____________________ </td>
                    <td> BIRTHING:
                        <strong>{{ $masterbl->berthing ? date('d-m-Y', strtotime($masterbl->berthing)) : null }}</strong>
                        / <strong>{{ $masterbl->jetty }}</strong>
                    </td>
                    <td> SHED: _________________ </td>
                </tr>
            </table>
        </div>

        <div class="" style=">clear: both"></div>


        <div id="tableArea overFlow">
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 15px">Line</th>
                        <th rowspan="2" style="width: 130px">Marks & NOS</th>
                        <th rowspan="2" style="width: 130px">DESCRIPTION OF GOODS</th>
                        <th rowspan="2" style="width: 120px">NOTIFY </th>
                        <th colspan="2">QUANTITY </th>
                        <th rowspan="2">REMARKS</th>
                    </tr>
                    <tr>
                        <th style="width: 40px;">IGM</th>
                        <th style="width: 60px;">FOUND</th>
                    </tr>
                </thead>

                <tbody>
                    @php($totalPackage = 0)
                    @foreach ($containerGroup as $container)
                        <tr>
                            <td>{{ $container->housebl->line }}</td>
                            <td style="text-align: left">{{ Str::limit($container->housebl->shippingmark, 100) }}</td>
                            <td style="text-align: left">{{ Str::limit($container->housebl->description, 100) }}</td>
                            <td style="text-align: left"> <strong>{{ $container->housebl->notifyname }}</strong> </td>
                            <td>
                                {{ $container->pkgno }} <br> {{ $container->housebl->packagetype }}
                                @php($totalPackage += $container->pkgno)
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"> Total Package </td>
                        <td>
                            {{ $totalPackage }}
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- tableArea -->

        @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
