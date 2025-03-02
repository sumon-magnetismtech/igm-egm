<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forwarding Letter</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            margin: 0 5px;
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

        header {
            display: block;
            font-size: 11px;
            height: 100px;
        }

        #company {
            width: 520px;
            float: left;
        }

        #company h1 {
            font-family: 'Book Antiqua', arial;
            margin-top: 48px;
            font-size: 50px;
            line-height: 0;
        }

        .spacing {
            font-size: 12px;
            letter-spacing: .24em;
            text-align: center;
            margin-right: -30px;
        }

        #companyContact {
            float: right;
            width: 170px;
        }

        #companyContact p span {
            width: 40px;
            display: inline-block;
        }

        footer {
            position: fixed;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
        }

        .d-none {
            display: none;
        }

        .d-block {
            display: block;
        }
    </style>
</head>

<body>

    @if (!$masterBl)
        <div class="textCenter">
            <h1 style> Sorry! </h1>
            <h3> No Data Found based on this IGM Number. </h3>
        </div>
    @endif

    <header>
        <div class="{{ $withPad ? 'd-block' : 'd-none' }}">
            <div id="company">
                <h1> Magnetism Tech Ltd</h1>
            </div>

            <div id="companyContact">
                <p><span> Tell</span> : 88 031 720415, 721659</p>
                <p><span> </span> : 2510220</p>
                <p><span> Fax </span> : 88 031 2527591</p>
                <p style="margin-bottom: 0"><span> E-mail </span> : info@qclogistics.com</p>
            </div>
            <hr width="100%" style="display: block; clear: both; margin: 0 -50px">
            <p class="spacing"> C & F Tower (4th Floor), 1222, Sk. Mujib Road, Agrabad, Chittagong, Bangladesh. </p>
        </div>
    </header>

    <div class="addressArea mrTB">
        <div class="mrTB">
            <p> Ref: QCLL/{{ $masterBl->id }}/{{ time() }} </p>
            <p> Date: {{ date('d F, Y', strtotime(now())) }} </p>
        </div>

        <div class="mrTB">
            <p> To </p>
            <p> <strong>{{ $masterBl->mloname }}</strong> </p>
            <p> {{ $masterBl->mloaddress }} </p>
        </div>
    </div> <!-- end addressArea -->

    <div class="" style="clear: both"></div>



    <div id="tableArea overFlow">
        <p> Dear Sir, </p>
        <p> We would like to request you to
            @if ($letterType == 'extension')
                extension of container detention period
            @else
                issue delivery order
            @endif
            for following shipment details:
        </p>
        <table width="100%" class="mrTB">
            <tr>
                <td> 1. Bill of Lading Number: </td>
                <td> {{ $masterBl->mblno }} </td>
            </tr>
            <tr>
                <td> 2. Container Number(s):</td>
                <td>
                    @if ($containers->count() > 5)
                        @php
                            $typeCount = $containers->groupBy('type')->map(function ($item, $key) {
                                return collect($item)->count();
                            });
                        @endphp
                        @foreach ($typeCount as $key => $data)
                            <nobr>{{ $data }} x {{ $key }}</nobr>,
                        @endforeach
                    @else
                        @foreach ($containers->pluck('type', 'contref') as $container => $type)
                            <strong>{{ $container }}</strong>({{ $type }}){{ $loop->last ? null : ', ' }}
                        @endforeach
                    @endif
                </td>
            </tr>
            <tr>
                <td>3. Registration Number</td>
                <td> {{ $masterBl->rotno }} </td>
            </tr>
            <tr>
                <td>4. Vessel(Voyage):</td>
                <td> {{ $masterBl->fvessel }}, {{ $masterBl->voyage }}</td>
            </tr>
            <tr>
                <td>5. Commodity Name:</td>
                <td> {{ $masterBl->mloCommodity }} </td>
            </tr>
            <tr>
                <td>6. Delivery Mode</td>
                <td> {{ $masterBl->contMode }} </td>
            </tr>
            <tr>
                <td>7. Delivery order valid up to:</td>
                <td> {{ $frdData['freeTime'] ?? '' }} </td>
            </tr>
            <tr>
                <td>8. Delivery Location:</td>
                <td> {{ $frdData['deliveryLocation'] ?? '' }} </td>
            </tr>
            <tr>
                <td>9. Detention Payer:</td>
                <td> {{ $frdData['client'] ?? '' }}</td>
            </tr>
        </table>
    </div> <!-- tableArea -->

    <div id="contentArea overFlow" style="text-align: justify">
        <p><strong>We confirm that:</strong></p>
        <ol>
            <li> Name of the Detention Payer mentioned above is the rightful party as per duly endorsed House Bill of
                Lading and Customs Bill of Entry. </li>
            <li> In case of any financial transaction for this bill of lading, we have no objection if
                {{ $masterBl->mloname }} settles either with us or the detention payer only (provided Detention Payer
                is not the freight forwarder itself).</li>
            <li> This request is verified and signed by the delivery order signatory of our company. </li>
        </ol>

        <p> Thankfully Yours,</p><br><br><br>
        <p> As Agents </p>
        <p> For: <strong> Magnetism Tech Ltd.</strong></p>
    </div> <!-- end contentArea -->

    {{-- <div class="page-break"></div> --}}

    <footer class="{{ $withPad ? 'd-block' : 'd-none' }}">
        <p style="clear: both; text-align: center">
            <small> MIRANDEL, Flat A-6, House-03, Road-05, Block-J, Baridhara, Dhaka, Bangladesh.</small> <br>
            <small> Tell: 88 02 8836811, Fax: 88 02 8836812 </small><br>
            <strong> Registered Office: Goods Hill, Rahmatgonj, Chittagong, Bangladesh. </strong>
        </p>
    </footer>
</body>

</html>
