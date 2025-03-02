<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notice to Consignee </title>
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
            margin-top: 8px;
            margin-bottom: 8px
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

        #tableArea table tr td:first-child {
            width: 150px;
        }

        #tableArea table tr td:nth-child(2) {
            width: 10px;
        }
    </style>
</head>

<body>

    <header class="overFlow">
        <div id="logo">
            <img src="{{ public_path('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div id="brand" class="textCenter">
            <h1 id="companyName"> MAGNETISM TECH LTD </h1>
            <p><small> C&F Tower, 4th Floor, 1222 Sk. Mujib Road, Agrabad, Chittagong. Tel : +880-31-2515926-7,
                    721659.</small></p>
        </div>
        <hr width="100%">
    </header>

    <div class="addressArea">
        <p> Date: {{ date('d F, Y', strtotime(now())) }} </p>
        <div id="flotNone">
            <h2 class="textCenter"> <u>NOTICE TO CONSIGNEE </u></h2>
        </div>

        <div>
            <p> To </p>
            <p>{{ $hblInfo->notifyname }}</p>
            <p> {{ $hblInfo->notifyaddress }}</p>
            <p> BIN {{ $hblInfo->notifybin }} </p>
        </div>
        <div class="mrTB">
            <p>Dear Sir(s), </p>
            <p>We are pleased to inform you that above feeder vessel is scheduled to arrive at
                <strong>Chittagong</strong>
                on or about
                <strong>
                    {{ $hblInfo->masterbl->arrival ? date('d-m-Y', strtotime($hblInfo->masterbl->arrival)) : '--' }}
                </strong>
                with the under noted cargo on your account.
            </p>
        </div>
    </div> <!-- end contentArea -->

    <div class="" style="clear: both"></div>

    <div id="tableArea overFlow">
        <table width="100%" border="none">
            <tr>
                <td>B/L No. </td>
                <td>:</td>
                <th>{{ $hblInfo->bolreference }}</th>
            </tr>
            <tr>
                <td>Consignee </td>
                <td>:</td>
                <th>{{ $hblInfo->consigneename }}</th>
            </tr>
            <tr>
                <td>Mother Vessel& Voy</td>
                <td>:</td>
                <td style="font-weight: normal">{{ $hblInfo->masterbl->mv }}</td>
            </tr>
            <tr>
                <td>Feeder Vessel & Voy</td>
                <td>:</td>
                <th>{{ $hblInfo->masterbl->fvessel }} V. {{ $hblInfo->masterbl->voyage }}</th>
            </tr>
            <tr>
                <td>IMP. ROT. NO. </td>
                <td>:</td>
                <th>{{ $hblInfo->masterbl->rotno }}</th>
            </tr>
            <tr>
                <td> Port of Unloading</td>
                <td>:</td>
                <th>{{ $hblInfo->masterbl->puname }} ({{ $hblInfo->masterbl->pucode }})</th>
            </tr>
            <tr>
                <td> Quantity</td>
                <td>:</td>
                <th>{{ $hblInfo->packageno }} {{ $hblInfo->packagetype }}</th>
            </tr>
            <tr>
                <td> Commodity</td>
                <td>:</td>
                <th>{{ $hblInfo->description }}</th>
            </tr>
            <tr>
                <td> Container</td>
                <td>:</td>
                @if ($hblInfo->containernumber <= 3)
                    <td style="font-size: 11px">
                        @foreach ($containers as $container)
                            <strong> {{ $container->contref }}/ {{ $container->type }} - {{ $container->status }}
                            </strong>,
                        @endforeach
                    </td>
                @else
                    @php $type =array() @endphp
                    @foreach ($containers as $key => $container)
                        @php $type[$key] = $container->type; @endphp
                    @endforeach
                    @php $types = array_count_values($type);  @endphp
                    <td style="font-size: 11px">
                        @foreach ($types as $type => $key)
                            <strong>{{ $key }} {{ $type }},</strong>
                        @endforeach
                    </td>
                @endif
            </tr>

        </table>
    </div> <!-- tableArea -->
    <div id="contentArea overFlow" style="text-align: justify">
        <p class="mrTB">
            You are, therefore, requested to make necessary arrangement for early clearance of the stated
            cargo on presentation of the Original Bill(s) of Lading & relevant documents duly endorsed by the
            Customs Authority within the stipulated free time, in order to avoid any mishap to the cargo
            and /or accruing demurrage /store rent to the container(s).
        </p>
        <p class="mrTB">
            Kindly note if not cleared the stated cargo within 30 days of cargo arrival at Chittagong Port, the
            same will be put to Customs Auction unit for disposal through public auction under section 82 of
            customs Act 1969 and in that case you will remain fully liable for all costs and consequences.
        </p>
        <p class="mrTB">
            <strong> Special remarks : </strong>
            if your consignment is LCL please do not process your Bill of Entry at Customs
            until completion of un-stuffing in order to avoid amendment and for smooth delivery of your
            cargo.
        </p>
        <p class="mrTB">
            Please feel free to contact our Import Department before custom formalities if observe any
            discrepancy between HBL and Manifest or need any help for cargo delivery.
        </p>
        <p>Truly Yours,</p><br><br>
        <p> As Agents</p>
        <p> For: <strong>MAGNETISM TECH LTD.</strong></p>
    </div> <!-- end contentArea -->
</body>

</html>
