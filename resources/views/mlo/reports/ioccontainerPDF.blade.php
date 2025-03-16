<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> IOC Container List </title>
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
            width: 700px;
            float: left;
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
            font-size: 10px
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
            <br>
            <h2 class="textCenter" style="margin: 5px"> INTER-OFFICE CORRESPONDENCE (IOC) <br> Container List </h2>
        </div>
        <div class="addressArea">
            <div>
                <p> Vessel: <strong>{{ $feederInfo->feederVessel }}</strong> </p>
                <p> IMP Rot No: <strong>{{ $feederInfo->rotationNo }}</strong> </p>
                <p> ETA :
                    <strong>
                        @if (!empty($feederInfo->arrivalDate))
                            {{ date('d-m-yy', strtotime($feederInfo->arrivalDate)) }}
                        @endif
                    </strong>
                </p>
            </div>
        </div> <!-- end contentArea -->
    </header>

    <div class="" style="clear: both"></div>

    <div id="tableArea overFlow">
        <table width="100%">
            <tr style="background: #1d5ea6; color: #fff;">
                <td>Sl. </td>
                <td>Line</td>
                <td>HBL</td>
                <td>Container</td>
                <td>Type</td>
                <td>PO R</td>
                <td>Notify</td>
                <td>Description</td>
                <td>Note For DO</td>
                <td> Remarks</td>
            </tr>
            @php($sl = 1)
            @foreach ($feederInfo->mloblInformation as $blkey => $mloblInformation)
                @foreach ($mloblInformation->blcontainers as $key => $container)
                    @php($totalContiner = $mloblInformation->blcontainers->count()))
                    <tr>
                        <td class="textCenter"> {{ $sl++ }}</td>
                        @if ($loop->first)
                            <td rowspan="{{ $totalContiner }}" class="textCenter"> {{ $mloblInformation->line }}</td>
                            <td rowspan="{{ $totalContiner }}" class="textCenter"> {{ $mloblInformation->bolreference }}
                            </td>
                        @endif
                        <td> {{ $container->contref }}</td>
                        <td class="textCenter"> {{ $container->type }}</td>

                        @if ($loop->first)
                            <td rowspan="{{ $totalContiner }}" class="textCenter"> {{ $mloblInformation->pOrigin }}
                            </td>
                            <td rowspan="{{ $totalContiner }}"> {{ $mloblInformation->blNotify->NAME }}</td>
                            <td rowspan="{{ $totalContiner }}"> {{ $mloblInformation->description }}</td>
                            <td rowspan="{{ $totalContiner }}"> {{ $mloblInformation->note }}</td>
                            <td rowspan="{{ $totalContiner }}"> {{ $mloblInformation->remarks }}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </table>
        <h4>
            <span style="color: #153262"> Summary : </span>
            @foreach ($containerGroups as $type => $total)
                {{ $type }} x {{ $total }} {{ $loop->last ? null : ',' }}
            @endforeach
        </h4>
    </div> <!-- tableArea -->
</body>

</html>
