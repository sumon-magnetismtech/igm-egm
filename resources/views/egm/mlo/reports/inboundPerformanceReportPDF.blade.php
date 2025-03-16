<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INBOUND PERFORMANCE REPORT</title>
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

        #brand {
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 25%;
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

        table tr td {
            text-align: center;
        }

        table td {
            border: 1px solid #000
        }

        table,
        table th,
        table td {
            border-spacing: 0;
            font-size: 10px;
            border-collapse: collapse
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
        <div id="brand" style="" class="textCenter">
            <div class="logo">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
            </div>
            <h1 id="companyName">  Magnetism Tech Ltd </h1>
            <p><small>Admin Future Park, 5th Floor, Barik Building, Chittagong. Tel : +88 02333315926-7.</small></p>
            <br>
            <h2 class="textCenter" style="margin: 5px"> INBOUND PERFORMANCE REPORT </h2>
            <p style="text-align: center; margin-bottom: 10px">
                Date:
                @if ($dateType == 'weekly')
                    {{ now()->subDays(7)->format('d-M-Y') }} to {{ now()->format('d-M-Y') }}
                @elseif($dateType == 'monthly')
                    {{ now()->subDays(30)->format('d-M-Y') }} to {{ now()->format('d-M-Y') }}
                @elseif($dateType == 'custom')
                    {{ $fromDate ? date('d-m-Y', strtotime($fromDate)) : null }} to
                    {{ $tillDate ? date('d-m-Y', strtotime($tillDate)) : null }}
                @else
                    {{ now()->format('d-m-Y') }} to {{ now()->format('d-m-Y') }}
                @endif
            </p>
        </div>
    </header>

    <div class="" style="clear: both"></div>

    <div id="tableArea overFlow">
        <table width="100%">
            <tr style="background: #1d5ea6; color: #fff;">
                <td rowspan="2"> BL</td>
                <td rowspan="2"> MLO</td>
                <td rowspan="2"> VESSEL & VOY </td>
                <td rowspan="2"> BERTH </td>
                @foreach ($locationWiseContTypesWithCount as $key => $containerGroup)
                    <td colspan="{{ count($containerGroup) + 2 }}">
                        {{ $key }}
                    </td>
                @endforeach
                <td colspan="{{ count($locationWiseContTypesWithCount->collapse()) + 2 }}">
                    Grand Total
                </td>
            </tr>

            <tr style="background: #1d5ea6; color: #fff; text-align: center">
                @foreach ($locationWiseContTypesWithCount as $key => $containerGroup)
                    @foreach ($containerGroup as $groupKey => $singleGroup)
                        <td>
                            {{ $groupKey }}
                        </td>
                    @endforeach
                    <td>Total</td>
                    <td>TUES</td>
                @endforeach
                @foreach ($locationWiseContTypesWithCount->collapse() as $commonGroupKey => $commonGroup)
                    <td>{{ $commonGroupKey }}</td>
                @endforeach
                <td>Total </td>
                <td>Tues </td>
            </tr>


            @foreach ($mloblinformations as $mloblinformation)
                <tr>
                    <td>{{ $mloblinformation->bolreference }}</td>
                    <td>{{ $mloblinformation->principal->name }}</td>
                    <td>{{ $mloblinformation->mlofeederInformation->feederVessel }} V.
                        {{ $mloblinformation->mlofeederInformation->voyageNumber }}</td>
                    <td>{{ $mloblinformation->mlofeederInformation->berthingDate ? date('d/m/Y', strtotime($mloblinformation->mlofeederInformation->berthingDate)) : '--' }}
                    </td>

                    @foreach ($locationWiseContTypesWithCount as $key => $containerGroup)
                        @foreach ($containerGroup as $groupKey => $singleGroup)
                            @php
                                $countItem = 0;
                                $countTues = 0;
                            @endphp
                            <td>
                                @if ($key == $mloblinformation->PUloding)
                                    @foreach ($mloblinformation->blcontainers as $container)
                                        @php($countItem += $groupKey == $container->containerGroup->group)
                                        @if (str_contains($container->containerGroup->group, 20))
                                            @php($countTues += 1)
                                        @else
                                            @php($countTues += 2)
                                        @endif
                                    @endforeach
                                @endif
                                {{ $countItem }}
                            </td>
                        @endforeach
                        <td style="background: #c3c3c3">
                            @if ($key == $mloblinformation->PUloding)
                                {{ count($mloblinformation->blcontainers) }}
                            @else
                                0
                            @endif
                        </td>
                        <td style="background: #a3a3a3">
                            {{ $countTues }}
                        </td>
                    @endforeach

                    @foreach ($locationWiseContTypesWithCount->collapse() as $commonGroupKey => $commonGroup)
                        <td>
                            @php($totalGroupItem = 0)
                            @foreach ($mloblinformation->blcontainers as $container)
                                @if ($commonGroupKey == $container->containerGroup->group)
                                    @php($totalGroupItem += 1)
                                @endif
                            @endforeach
                            {{ $totalGroupItem }}
                        </td>
                    @endforeach
                    <td style="background: #c3c3c3">
                        {{ count($mloblinformation->blcontainers) }}
                    </td>
                    <td style="background: #a3a3a3">
                        @php($totalTues = 0)
                        @foreach ($mloblinformation->blcontainers as $container)
                            @if (str_contains($container->containerGroup->group, 20))
                                @php($totalTues += 1)
                            @else
                                @php($totalTues += 2)
                            @endif
                        @endforeach
                        {{ $totalTues }}
                    </td>
                </tr>
            @endforeach {{-- End mloblinformation rows foreach --}}


            {{-- Grand Total --}}
            <tr style="background: #a3a3a3">
                @php($grandTotal = 0)
                @php($grandTotalTues = 0)
                <td colspan="4" style="text-align: right">TOTAL</td>
                @foreach ($locationWiseContTypesWithCount as $containerGroupKey => $containerGroup)
                    @php($columnTypeTotal = 0)
                    @foreach ($containerGroup as $contTypeKey => $singleGroup)
                        <td style="text-align:center">
                            @php($columnTypeTotal += $singleGroup)
                            {{ $singleGroup }}
                        </td>
                    @endforeach

                    <td>
                        {{ $columnTypeTotal }}
                        @php($grandTotal += $columnTypeTotal)
                    </td>

                    <td>
                        @php($columnTuesTotal = 0)
                        @foreach ($containerGroup as $groupKey => $singleGroup)
                            @if (str_contains($groupKey, 20))
                                @php($columnTuesTotal += $singleGroup * 1)
                            @else
                                @php($columnTuesTotal += $singleGroup * 2)
                            @endif
                        @endforeach
                        {{ $columnTuesTotal }}
                        @php($grandTotalTues += $columnTuesTotal)
                    </td>
                @endforeach

                @foreach ($locationWiseContTypesWithCount->collapse() as $commonGroupKey => $commonGroup)
                    <td>
                        @php($totalGroup = 0)
                        @foreach ($locationWiseContTypesWithCount as $key => $contGroups)
                            @foreach ($contGroups as $groupKey => $group)
                                @if ($commonGroupKey == $groupKey)
                                    @php($totalGroup += $group)
                                @endif
                            @endforeach
                        @endforeach
                        {{ $totalGroup }}
                    </td>
                @endforeach
                <td> {{ $grandTotal }} </td>
                <td> {{ $grandTotalTues }} </td>
            </tr>
        </table>
    </div> <!-- tableArea -->
</body>

</html>
