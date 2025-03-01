<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print - House BL</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        body p {
            margin-top: 1px;
            margin-bottom: 1px;
        }

        h6 {
            font-size: 14px;
            line-height: 14px;
            margin: 0;
            margin-left: 130px;
        }

        .page_break {
            page-break-after: always;
        }

        .float-left {
            float: left;
        }

        /** Define the margins of your page **/
        #mainTable {
            font-size: 11px;
            table-layout: fixed;
            width: 100%;
            border: 2px solid #000000;
            !important;
        }

        table,
        table th,
        table td {
            border-spacing: 0;
        }

        table tr td {
            word-wrap: break-word;
            border-left: dotted 1px #000000;
            border-bottom: solid 1px #000000;
            border-top: solid 1px #000000;
            vertical-align: bottom;
        }


        table tr td:first-child {
            border-left: none;
            border-bottom: solid 1px #000000;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        .subTable {
            width: 100%;
            border-top: 1px solid #000000;
            /*background: green;*/
        }

        .subTable tr td {
            border-top: 1px solid #000000;
        }

        .subTable tr+.subTable td {
            border-top: none;
        }


        @page {
            margin: 47px 10px;
        }

        header {
            position: fixed;
            top: -20px;
            left: 0;
            right: 0;
        }


        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
            display: block;
        }
    </style>
</head>

<body>

    <header>
        <h6 class="float-left pl-5" id="companyName"> Magnetism Tech Ltd Limited </h6>
    </header>
    <footer>
        <p>
            <span style="margin-left: 130px"> Print Time: {{ date('d-M-y H:i:s a', strtotime(now())) }}</span>
            <span style="margin-left: 70px"> Software Developed By <strong>Magnetism Tech Ltd</strong>, Cell: +88 01717
                103 605 </span>
        </p>
    </footer>

    <table class="table-bordered text-break" id="mainTable" width="100%">
        <thead>
            <tr class="align-items-bottom">
                <td style="width:3%;"> Line </td>
                <td> MBL </td>
                <td style="width: 2.5%"> NOC </td>
                <td> HBL </td>
                <td> Feeder Ves. </td>
                <td style="width: 4.3%"> Quantity </td>
                <td style="width: 4.5%"> Arrival </td>
                <td style="width: 4.5%"> Berthing </td>
                <td> Rotation </td>
                <td> Shipper Name </td>
                <td> Consignee Name </td>
                <td> Notify Name </td>
                <td> Container </td>
                <td style="width: 2.8%"> Type </td>
                <td style="width: 2.3%"> Sta </td>
                <td> Seal No </td>
                <td style="width: 3.5%"> Do No </td>
                <td style="width: 4.5%"> DO Date </td>
                <td style="width: 4%"> MR No </td>
                <td> Client Details </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($housebls as $key => $housebl)
                @foreach ($housebl->containers as $container)
                    <tr>
                        @if ($loop->first)
                            <td style="vertical-align: middle"> {{ $housebl->line }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->masterbl->mblno }} </td>
                            <td style="vertical-align: middle">{{ $housebl->masterbl->noc ? 'NOC' : null }}</td>
                            <td style="vertical-align: middle"> {{ $housebl->bolreference }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->masterbl->fvessel }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->packageno }} </td>
                            <td style="vertical-align: middle">
                                {{ $housebl->masterbl->arrival ? date('d/m/y', strtotime($housebl->masterbl->arrival)) : null }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $housebl->masterbl->berthing ? date('d/m/y', strtotime($housebl->masterbl->berthing)) : null }}
                            </td>
                            <td style="vertical-align: middle"> {{ $housebl->rotation }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->exportername }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->consigneename }} </td>
                            <td style="vertical-align: middle"> {{ $housebl->notifyname }} </td>
                        @else
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                            <td style="text-align: center; vertical-align: middle">"</td>
                        @endif

                        <td style="vertical-align: middle">{{ $container->contref }}</td>
                        <td style="vertical-align: middle">{{ $container->type }}</td>
                        <td style="vertical-align: middle">{{ $container->status }}</td>
                        <td style="vertical-align: middle">{{ $container->sealno }}</td>
                        <td style="vertical-align: middle">
                            {{ $housebl->moneyReceipt && $housebl->moneyReceipt->deliveryOrder ? $housebl->moneyReceipt->deliveryOrder->id : '--' }}
                        </td>
                        <td style="vertical-align: middle">
                            {{ $housebl->moneyReceipt && $housebl->moneyReceipt->deliveryOrder ? date('d-m-y', strtotime($housebl->moneyReceipt->deliveryOrder->issue_date)) : '--' }}
                        </td>
                        <td style="vertical-align: middle">
                            {{ $housebl->moneyReceipt ? $housebl->moneyReceipt->id : null }} <br>
                            <nobr>
                                {{ $housebl->moneyReceipt ? date('d/m/y', strtotime($housebl->moneyReceipt->issue_date)) : null }}
                            </nobr>
                        </td>
                        <td style="vertical-align: middle">
                            {{ $housebl->moneyReceipt ? $housebl->moneyReceipt->client_name . '; ' . $housebl->moneyReceipt->client_mobile : '--' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <script type="text/php">
    if (isset($pdf)) {
        $x = 775;
        $y = 565;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 11;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
    {{-- <div class="page_break"></div> --}}
</body>

</html>
