<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LCL CONTAINER LIST</title>
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
            margin-top: 15px;
            margin-bottom: 15px
        }

        .page_break {
            page-break-after: always;
        }

        header {
            display: block;
            width: 100%;
        }

        .logo {
            width: 100px;
            float: left;
            clear: right;
        }

        #brand {
            width: 800px;
            float: left;
            margin-bottom: 15px;
        }

        .addressArea {
            width: 210px;
            padding: 10px;
            background: #1b5297;
            float: right;
            color: #fff;
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

        table {
            border: 1px solid #000
        }

        table tr:first-child td {
            text-align: center;
        }

        table td {
            border: 1px dotted #000
        }

        table,
        table th,
        table td {
            border-spacing: 0;
        }

        th {
            text-align: left;
        }

        table th,
        table td {
            padding: 5px;
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
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div id="brand" style="" class="textCenter">
            <h1 id="companyName"> Magnetism Tech Ltd </h1>
            <p><small>Admin Future Park, 5th Floor, Barik Building, Chittagong. Tel : +88 02333315926-7.</small></p>
            <h2
                style="border: 1px solid #000; padding: 5px; border-radius:5px; display: inline-block; width: 350px; margin: 10px auto">
                LCL CONTAINER LIST </h2>
        </div>
        <br>
    </header>

    <div class="" style="clear: both"></div>

    <div id="tableArea overFlow">
        <table width="100%">
            <tr style="background: #1d5ea6; color: #fff;">
                <td> Container </td>
                <td> Type </td>
                <td> Vessel Name </td>
                <td> Voy </td>
                <td> Rotation </td>
                <td> MLO </td>
                <td> HBL </td>
            </tr>
            @php $i=1; @endphp
            @if (count($mloblInformations) > 0)
                @foreach ($mloblInformations as $item => $mloblInfo)
                    {{ $item }} == {{ $loop->iteration }}
                    @foreach ($mloblInfo->blcontainers as $item_second => $mloblDetails)
                        {{ $item_second }} == {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                        <tr>
                            <td class="textCenter"> {{ $mloblDetails->contref ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblDetails->type ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblInfo->mlofeederInformation->feederVessel ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblInfo->mlofeederInformation->voyageNumber ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblInfo->mlofeederInformation->rotationNo ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblInfo->mlocode ?? '' }}</td>
                            <td class="textCenter"> {{ $mloblInfo->bolreference ?? '' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center"> No Data Found Based on your query.</td>
                </tr>
            @endif
        </table>
    </div> <!-- tableArea -->
</body>

</html>
