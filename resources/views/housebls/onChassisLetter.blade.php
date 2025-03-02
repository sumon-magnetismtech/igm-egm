<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>On Chassis Application</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            margin: 70px 20px 20px 40px;
            font-family: sans-serif;
            font-size: 14px;
        }

        body p {
            margin-top: 1px;
            margin-bottom: 1px;
        }

        header {
            position: relative;
        }

        .overFlow {
            overflow: hidden;
        }

        #logo {
            position: absolute;
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


        #companyName {
            font-size: 36px;
            font-family: 'Book Antiqua', arial;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 36px;
            font-weight: normal;
        }

        #addressArea h2 {
            padding: 10px 5px;
            color: #000;
            border: 2px solid #000;
            border-radius: 5px;
            font-size: 18px;
        }

        #tableArea {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table,
        table th,
        table td {
            border-spacing: 0;
            border: 1px solid #000
        }

        th {
            text-align: left;
        }

        table tr td:first-child {
            width: 200px;
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

        ol {
            margin: 20px;
            padding: 0;
        }

        ol>li {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    @if (!$housebl)
        <div class="textCenter">
            <h1 style> Sorry! </h1>
            <h3> No Data Found based on this IGM Number. </h3>
        </div>
    @endif

    <div class="addressArea mrTB">
        <div class="mrTB">
            <p> Ref: QCLL/ONC/{{ $housebl->bolreference }}</p>
            <p> Date: {{ date('d F, Y', strtotime(now())) }} </p>
        </div>

        <div class="mrTB">
            <p> To </p>
            <p>The Manager (Import) </p>
            <p> <strong>{{ $housebl->masterbl->mloname }}</strong> </p>
            <p> {{ $housebl->masterbl->mloaddress }} </p>
        </div>
    </div> <!-- end addressArea -->

    <div class="" style="clear: both"></div>

    <div id="tableArea overFlow">
        <p>
            <strong>Subject: </strong>
            Undertaking and guarantee for the below consignment of
            @foreach ($countContTypes as $key => $countContType)
                <strong>{{ $countContType }}x{{ $key }}</strong>{{ $loop->last ? null : ', ' }}
            @endforeach
            FCL shipments under MCC B/L No. {{ $housebl->masterbl->mblno }} against the vessel
            {{ $housebl->masterbl->fvessel }} V.{{ $housebl->masterbl->voyage }}, Imp. Rot. No.
            {{ $housebl->masterbl->rotno }} to be taken to
            {{ $housebl->notifyaddress }}
            as per our HOUSE B/L No. {{ $housebl->bolreference }}, Dated:{{ $onChassisData['date'] ?? '' }}.
        </p>
        <br>
        <p>
            <strong>Container No: </strong>
            @foreach ($housebl->containers as $container)
                {{ $container->contref }}/{{ $container->type }}{{ $loop->last ? null : ', ' }}
            @endforeach
        </p>

        <br>
        <p>Dear Sir,</p>
        <p>
            In consideration of your allowing our consignee
            {{ $housebl->notifyname }}{{ $housebl->notifyaddress }}
            to take the above mentioned containers to their FActory Premises.
        </p>
        <br>
        <p>
            We do hereby write to confirm you that we shall be liable to satisfy and fulfill the guarantee obligations
            by the consignee in
            case they (the consignee) fails to fulfill the obligations.
        </p>
        <br>

        <p>
            Thanking you,<br><br>
            Yours faithfully,
            <br>
            For Magnetism Tech Ltd.<br><br><br><br>
            (Mohammad Yeakub)
        </p>
        <br>
        <br>
        <p>Cc : {{ $housebl->notifyname }}{{ $housebl->notifyaddress }}</p> <br>
        <p>Cc : {{ $onChassisData['client'] ?? '' }}</p> <br>
        <p>Cc : Chittagong Customs Clearing & Forwarding Agents Association.</p> <br>


        <p>
            <strong>N. B.: You will only return original undertaking to the ultimate consignee</strong>
            “{{ $housebl->notifyname }}{{ $housebl->notifyaddress }}” on fulfillment of your all requirements.
        </p>
    </div> <!-- tableArea -->

</body>

</html>
