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
            border-collapse: collapse;
        }

        table tr td {
            word-wrap: break-word;
            border-left: dotted 1px #000000;
            border-bottom: solid 1px #000000;
            border-top: solid 1px #000000;
            vertical-align: middle;
            text-align: center;
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
        <h6 style="text-align: center" id="companyName"> MAGNETISM TECH LTD (DO Report) </h6>
    </header>
    <footer>
        <p>
            <span style="margin-left: 130px"> Print Time: {{ date('d-M-y H:i:s a', strtotime(now())) }}</span>
            <span style="margin-left: 70px"> Software Developed By <strong>Magnetism Tech Ltd</strong>, Cell: +88 01717
                103 605 </span>
        </p>
    </footer>

    @if ($deliveryOrders->isNotEmpty() || $noc->isNotEmpty())
        <p class="my-0"> Total DO : <strong> {{ count($deliveryOrders) }}</strong>; Total NOC : <strong>
                {{ count($noc) }}</strong></p>
        <table class="table-bordered text-break" id="mainTable" width="100%">
            <thead>
                <tr class="align-items-bottom">
                    <td> # </td>
                    <td> Type </td>
                    <td>BL Num</td>
                    <td>Pkgs</td>
                    <td>M/VESSEL & VOY</td>
                    <td>FED/ VESSEL & VOY</td>
                    <td>ARR. DT</td>
                    <td>Principal</td>
                    <td>Exporter Name</td>
                    <td>Importer Name</td>
                    <td>D/O DATE</td>
                    <td>UpToDate</td>
                    <td>CNF AGENT</td>
                    <td>CONTACT NO</td>
                </tr>
            </thead>
            <tbody>
                @if ($deliveryOrders->isNotEmpty())
                    @foreach ($deliveryOrders as $key => $deliveryOrder)
                        <tr>
                            <td style="width: 3%"> {{ $loop->iteration }} </td>
                            <td style="width: 3%">
                                <nobr>DO</nobr>
                            </td>
                            <td style="width:7%"> {{ $deliveryOrder->moneyReceipt->houseBl->bolreference }} </td>
                            <td style="width:4%"> {{ $deliveryOrder->moneyReceipt->houseBl->packageno }} <br>
                                {{ $deliveryOrder->moneyReceipt->houseBl->packagetype }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->moneyReceipt->houseBl->masterbl->mv }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->moneyReceipt->houseBl->masterbl->fvessel }}
                                V.{{ $deliveryOrder->moneyReceipt->houseBl->masterbl->voyage }} </td>
                            <td style="width:6%">
                                {{ $deliveryOrder->moneyReceipt->houseBl->masterbl->arrival ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->houseBl->masterbl->arrival)) : null }}
                            </td>
                            <td style="width:11%"> {{ $deliveryOrder->moneyReceipt->houseBl->masterbl->principal }}
                            </td>
                            <td style="width:11%"> {{ $deliveryOrder->moneyReceipt->houseBl->exportername }} </td>
                            <td style="width:11%"> {{ $deliveryOrder->moneyReceipt->houseBl->notifyname }} </td>
                            <td style="width:6%">
                                {{ $deliveryOrder->issue_date ? date('d-m-Y', strtotime($deliveryOrder->issue_date)) : null }}
                            </td>
                            <td style="width:6%">
                                {{ $deliveryOrder->upto_date ? date('d-m-Y', strtotime($deliveryOrder->upto_date)) : null }}
                            </td>
                            <td style="width:11%"> {{ $deliveryOrder->moneyReceipt->client_name }} </td>
                            <td style="width:8%"> {{ $deliveryOrder->moneyReceipt->client_mobile }} </td>
                        </tr>
                    @endforeach
                @endif

                @if ($noc->isNotEmpty())
                    @foreach ($noc as $key => $deliveryOrder)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td>
                                <nobr>NOC</nobr>
                            </td>
                            <td style="width:7%"> {{ $deliveryOrder->houseBl->bolreference }} </td>
                            <td style="width:4%"> {{ $deliveryOrder->houseBl->packageno }}<br>
                                {{ $deliveryOrder->houseBl->packagetype }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->houseBl->masterbl->mv }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->houseBl->masterbl->fvessel }}
                                V.{{ $deliveryOrder->houseBl->masterbl->voyage }} </td>
                            <td style="width:6%">
                                {{ $deliveryOrder->houseBl->masterbl->arrival ? date('d-m-Y', strtotime($deliveryOrder->houseBl->masterbl->arrival)) : null }}
                            </td>
                            <td style="width:12%"> {{ $deliveryOrder->houseBl->masterbl->principal }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->houseBl->exportername }} </td>
                            <td style="width:12%"> {{ $deliveryOrder->houseBl->notifyname }} </td>
                            <td style="width:6%">
                                {{ $deliveryOrder->issue_date ? date('d-m-Y', strtotime($deliveryOrder->issue_date)) : null }}
                            </td>
                            <td style="width:6%"> -- -- -- </td>
                            <td style="width:12%"> {{ $deliveryOrder->client_name }} </td>
                            <td style="width:8%"> {{ $deliveryOrder->client_mobile }} </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    @endif

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
