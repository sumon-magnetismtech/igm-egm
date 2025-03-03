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
        <h6 style="text-align: center" id="companyName">  Magnetism Tech Ltd (DO Report) </h6>
    </header>
    <footer>
        <p>
            <span style="margin-left: 130px"> Print Time: {{ date('d-M-y H:i:s a', strtotime(now())) }}</span>
            <span style="margin-left: 70px"> Software Developed By <strong> Magnetism Tech Ltd</strong>, Cell: +88 01717
                103 605 </span>
        </p>
    </footer>

    @if ($deliveryOrders->isNotEmpty())
        <p class="my-0"> Total DO : <strong> {{ count($deliveryOrders) }}</strong> </p>
        <table class="table-bordered text-break" id="mainTable" width="100%">
            <thead>
                <tr class="align-items-bottom">
                    <td> # </td>
                    <td>Line</td>
                    <td> B/L </td>
                    <td>Pkgs</td>
                    <td>FED/ VESSEL & VOY</td>
                    <td>ARR. DT</td>
                    <td>Principal</td>
                    <td>Exporter Name</td>
                    <td>Importer Name</td>
                    <td>D/O DATE</td>
                    <td>UpTo Date</td>
                    <td>CNF AGENT</td>
                    <td>CONTACT NO</td>
                </tr>
            </thead>
            <tbody>
                @if ($deliveryOrders->isNotEmpty())
                    @foreach ($deliveryOrders as $key => $deliveryOrder)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $deliveryOrder->moneyReceipt->molblInformations->line }} </td>
                            <td> {{ $deliveryOrder->moneyReceipt->molblInformations->bolreference }} </td>
                            <td> {{ $deliveryOrder->moneyReceipt->molblInformations->packageno }} <br>
                                {{ $deliveryOrder->moneyReceipt->molblInformations->package->description }} </td>
                            <td style="width: 150px">
                                {{ $deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->feederVessel }}
                                V.{{ $deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->voyageNumber }}
                            </td>
                            <td style="width: 68px">
                                <nobr>
                                    {{ $deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate)) : null }}
                                </nobr>
                            </td>
                            <td style="width: 68px">
                                {{ $deliveryOrder->moneyReceipt->molblInformations->principal->name }}</td>
                            <td style="width: 150px">
                                {{ $deliveryOrder->moneyReceipt->molblInformations->exportername }} </td>
                            <td style="width: 150px">
                                {{ $deliveryOrder->moneyReceipt->molblInformations->blNotify->NAME }} </td>
                            <td style="width: 68px">
                                <nobr>
                                    {{ $deliveryOrder->DO_Date ? date('d-m-Y', strtotime($deliveryOrder->DO_Date)) : null }}
                                </nobr>
                            </td>
                            <td style="width: 68px">
                                <nobr>
                                    {{ $deliveryOrder->moneyReceipt->uptoDate ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->uptoDate)) : null }}
                                </nobr>
                            </td>
                            <td style="width: 150px"> {{ $deliveryOrder->moneyReceipt->client->cnfagent }} </td>
                            <td> {{ $deliveryOrder->moneyReceipt->client->contact }} </td>
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
