<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Money Receipt PDF</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        font-size: 14px;
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

    p {
        margin: 0;
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

    #billingTable {
        overflow: hidden;
        clear: both;
        width: 100%
    }

    table,
    table th,
    table td {
        border-spacing: 0;
        padding-bottom: 0;
        border-collapse: collapse;
        border: 1px solid #000000;
        font-size: 10px;
    }

    table th,
    table td {
        padding: 3px;
    }

    header {
        display: block;
        font-size: 11px;
        height: 60px;
    }

    #company {
        width: 520px;
        float: left;
    }

    #company h1 {
        font-family: 'Book Antiqua', arial;
        margin: 0 0 8px;
        font-size: 50px;
        line-height: 50px;
        /*font-weight:normal;*/
    }

    #companyContact {
        float: right;
        width: 170px;
    }

    #companyContact p span {
        width: 40px;
        display: inline-block;
    }

    #seal {
        font-family: 'Book Antiqua', arial;
        font-size: 18px;
        font-weight: normal;
    }

    #seal h4 {
        font-size: 18px;
        font-weight: normal;
    }

    footer {
        position: fixed;
        bottom: 5px;
        left: 0;
        right: 0;
        height: 30px;
        width: 100%;
        display: block;
    }

    .my-10 {
        margin-top: 7px;
        margin-bottom: 7px;
    }

    .my-5 {
        margin-top: 7px;
        margin-bottom: 7px;
    }

    #logo {
        position: absolute;
        top: 5px;
        left: 0;
    }

    #companyName {
        font-size: 36px;
        font-family: 'Book Antiqua', arial;
        margin-top: 0;
        margin-bottom: 10px;
        line-height: 36px;
        font-weight: normal;
    }
</style>

<body>
    <header class="overFlow">
        <div id="logo">
            <img src="{{ public_path('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div id="brand" class="textCenter">
            <h1 id="companyName"> Magnetism Tech Ltd Limtied </h1>
            <p><small>Admin Future Park, 5th Floor, Barik Building, Chittagong. Tel : +88 02333315926-7.</small></p>
        </div>
        <hr width="100%">
    </header>

    <div id="billingArea" class="mainArea">
        <h2 style="text-align: center; margin-bottom: 5px"> Money Receipt List </h2>
        <p style="text-align: center; margin-bottom: 10px">
            Date:

            @if ($dateType == 'weekly')
                {{ now()->subDays(7)->format('d-m-Y') }} to {{ now()->format('d-m-Y') }}
            @elseif($dateType == 'monthly')
                {{ now()->subDays(30)->format('d-m-Y') }} to {{ now()->format('d-m-Y') }}
            @elseif($dateType == 'custom')
                {{ $fromDate ? date('d-m-Y', strtotime($fromDate)) : null }} to
                {{ $tillDate ? date('d-m-Y', strtotime($tillDate)) : null }}
            @else
                {{ now()->format('d-m-Y') }} to {{ now()->format('d-m-Y') }}
            @endif
        </p>
        @if ($principal)
            <p style="margin-bottom: 5px">
                Principal: <strong>{{ $principal }}</strong>
            </p>
        @endif

        <table id="billingTable">
            <tr>
                <th>Sl</th>
                <th>MR</th>
                <th>Date</th>
                <th>HBL</th>
                @if (!$principal)
                    <th>Principal</th>
                @endif
                <th>MV</th>
                <th>FV</th>
                <th>Qty</th>
                <th>Client</th>
                <th>Cnt</th>
                <th>Mode</th>
                <th>Particulars</th>
                <th>Amount</th>
                @if (!$principal)
                    <th>Amount <br> Principal-wise</th>
                @endif
            </tr>

            @php
                $grandTotal = 0;
                $i = 1;
                $principalGrandTotal = 0;
            @endphp

            @foreach ($groupByPrincipals as $key => $groupByPrincipal)
                @foreach ($groupByPrincipal as $moneyReceipt)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td>QCLOGFRD-{{ $moneyReceipt->id }}</td>
                        <td style="text-align: center">
                            <nobr>{{ date('d-m-Y', strtotime($moneyReceipt->issue_date)) }}</nobr>
                        </td>
                        <td>{{ $moneyReceipt->houseBl->bolreference }}</td>
                        @if (!$principal)
                            <td>{{ $moneyReceipt->houseBl->masterbl->principal }}</td>
                        @endif
                        <td>{{ $moneyReceipt->houseBl->masterbl->mv }}</td>
                        <td>{{ $moneyReceipt->houseBl->masterbl->fvessel }}</td>
                        <td style="text-align: center">{{ $moneyReceipt->houseBl->packageno }}</td>
                        <td>{{ $moneyReceipt->client_name }}</td>
                        <td style="text-align: center">{{ $moneyReceipt->houseBl->containernumber }}</td>
                        <td style="text-align: center">
                            {{ Str::upper($moneyReceipt->pay_mode) }} <br>
                            {{ Str::upper($moneyReceipt->pay_number ?? null) }}
                        </td>
                        <td>
                            @foreach ($moneyReceipt->MoneyreceiptDetail as $moneyReceiptDetail)
                                {{ $moneyReceiptDetail->particular }} <br>
                            @endforeach
                        </td>
                        <td style="text-align: right">
                            @foreach ($moneyReceipt->MoneyreceiptDetail as $moneyReceiptDetail)
                                {{ number_format($moneyReceiptDetail->amount, 2) }}/- <br>
                                @php($grandTotal += $moneyReceiptDetail->amount)
                            @endforeach
                        </td>
                        @if (!$principal && $loop->first && $groupByPrincipal->isNotEmpty())
                            <td class="align-middle textRight" rowspan="{{ $groupByPrincipal->count() }}">
                                <?php $principalSum = \Illuminate\Support\Facades\DB::table('egm_moneyreceipts')
                                    ->join('egm_moneyreceipt_details', 'moneyreceipt_id', 'egm_moneyreceipts.id')
                                    ->whereIn('egm_moneyreceipts.id', $groupByPrincipal->flatten()->pluck('id'))
                                    ->get();
                                ?>
                                {{ number_format($principalAmount = $principalSum->sum('amount'), 2) }}/-
                                @php($principalGrandTotal += $principalAmount)
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="{{ !$principal ? 12 : 11 }}" class="textRight"><strong>Total Amount</strong></td>
                <td style="text-align: right">{{ number_format($grandTotal, 2) }}/-</td>
                @if (!$principal)
                    <td style="text-align: right">{{ number_format($principalGrandTotal, 2) }}/-</td>
                @endif
            </tr>
        </table>
    </div> <!-- end billingArea -->


    <footer>
        <p style="clear: both; text-align: center">
            <small> Printing Time: {{ date('d-M-y h:i:s a', strtotime(now())) }};</small>
        </p>
        <p style="clear: both; text-align: center">
            Software Developed By <strong>Magnetism Tech Limited</strong> |
            Website: <strong>www.magnetismtech.com</strong> <br>
            Email: <strong>info@magnetismtech.com</strong> | Cell: +88 01717 103 605; +88 01713 220 257
        </p>
    </footer>
</body>

</html>
