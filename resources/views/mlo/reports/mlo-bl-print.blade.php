<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print ALL IGM </title>
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
            margin: 100px 10px 40px 10px !important;
        }


        header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
            display: block;
        }

        #companyName {
            font-family: 'Book Antiqua', arial;
            font-weight: normal;
            font-size: 18px;
            letter-spacing: 2px;
        }

        #importGeneral {
            position: absolute;
            top: 15px;
            border: 1px solid #000;
            padding: 3px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>

<body>
    <header>
        <h6 id="companyName" class=""> Magnetism Tech Ltd </h6>
        <p class=""> <small>AIN: 301080083; <span style="margin-left: 5px">LICENSE NO: 0083/2008</span></small> </p>
        <p class=""> <small>CNF TOWER 4TH FLOOR, AGRABAD C/A, CHITTAGONG, BANGLADESH.</small> </p>

        <h6 id="importGeneral"> IMPORT GENERAL MANIFEST</h6>

        <small style="position: absolute; left: 700px; top: 0">
            <span> Vessel Name: <strong> {{ $feederinformation->feederVessel }} </strong> </span>
        </small>

        <small style="position: absolute; left: 700px; top: 15px">
            <span> Voyage : <strong> {{ $feederinformation->voyageNumber }} </strong></span>

            <span> IMP. REG. No: <strong> {{ $feederinformation->rotationNo }} </strong></span>
        </small>

        {{-- <small style="position: absolute; left: 700px; top: 30px"> --}}
        {{-- <span> Unloading Port: <strong> {{$feederinformation->desPortName}} ({{$feederinformation->desPortCode}}) </strong></span> --}}
        {{-- </small> --}}

        @if ($status == 'bdkam' || $status == 'bdpng')
            <h2 style="margin-top: -3px; text-align: center; text-transform: uppercase"> Container Bound for
                {{ strtoupper($status) }} </h2>
        @endif
    </header>

    <footer>
        <p>
            <strong> IGM No. {{ $feederinformation->id }} </strong>
            <span style="margin-left: 130px"> Print Time: {{ date('d-M-y H:m:s a', strtotime(now())) }}</span>
            <span style="margin-left: 70px"> Software Developed By <strong> Magnetism Tech Ltd</strong>, Cell: +88 01717
                103 605 </span>
        </p>
    </footer>

    <table class="table-bordered text-break" id="mainTable" width="100%">
        <thead>
            <tr class="align-items-bottom">
                <td style="width: 2.5%">Lin <br><strong>1</strong></td>
                <td style="width: 7%">Bl Num <br><strong>2</strong></td>
                <td style="width: 4%">Num & Desc <br><strong>3 </strong></td>
                <td style="width: 8%">Marks & No <br><strong>4</strong></td>
                <td style="width: 8%">Description <br><strong>5</strong></td>
                <td style="width: 7%">Exporter <br><strong>6</strong></td>
                <td style="width: 7%">Consignee <br><strong>7</strong></td>
                <td style="width: 7%">Notify <br><strong>8</strong></td>
                <td style="width: 4.5%">Gross W <br><strong>9 </strong></td>
                <td style="width: 3%">Cbm <br><strong>10 </strong></td>
                <td style="width: 3%">N. Co <br><strong>11 </strong></td>
                <td style="width: 7%">Contr <br><strong>12 </strong></td>
                <td style="width: 5%">Seal No <br><strong>13 </strong></td>
                <td style="width: 3%">Size <br><strong>14 </strong></td>
                <td style="width: 3.5%">Status <br><strong>15 </strong></td>
                <td style="width: 3%">Qty <br><strong>16 </strong></td>
                <td style="width: 3.5%">Weight <br><strong>17 </strong></td>
                <td style="width: 2%">Co <br><strong>18 </strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($feederinformation->mloblInformation as $key => $blinformation)
                @foreach ($blinformation->blcontainers as $container)
                    <tr>
                        @if ($loop->first)
                            <td> {{ $blinformation->line }} </td>
                            <td> {{ $blinformation->bolreference }} </td>
                            <td>
                                {{ $blinformation->packageno }} <br>
                                {{ $blinformation->package->description }}
                            </td>
                            <td> {{ strtoupper($blinformation->shippingmark) }} </td>
                            <td> {{ $blinformation->description }} </td>
                            <td> {{ $blinformation->exportername }}, {{ $blinformation->exporteraddress }} </td>
                            <td> {{ $blinformation->blConsignee->BIN }}<br>
                                {{ $blinformation->blConsignee->NAME }}<br> {{ $blinformation->blConsignee->ADD1 }}
                            </td>
                            <td> {{ $blinformation->blNotify->BIN }}<br> {{ $blinformation->blNotify->NAME }}<br>
                                {{ $blinformation->blNotify->ADD1 }} </td>
                            <td> {{ $blinformation->grosswt }} </td>
                            <td> {{ $blinformation->measurement }} </td>
                            <td> {{ $blinformation->containernumber }} </td>
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
                        @endif

                        <td>{{ $container->contref }}</td>
                        <td>{{ $container->sealno }}</td>
                        <td>{{ $container->type }}</td>
                        <td>{{ $container->status }}</td>
                        <td>{{ $container->pkgno }}</td>
                        <td>{{ $container->grosswt }}</td>
                        <td>{{ $container->commodity }}</td>
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

    @if ($feederinformation->mloblInformation->count() < $feederinformation->mloblInformation->count())
        <div class="page_break"></div>
    @endif
</body>

</html>
