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
    }

    table th,
    table td {
        padding: 10px;
    }

    header {
        display: block;
        font-size: 11px;
        height: 110px;
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

    footer {
        position: fixed;
        bottom: 0px;
        left: 0;
        right: 0;
        height: 30px;
        width: 100%;
        display: block;
    }

    #footerTop {
        position: fixed;
        bottom: 17%;
    }

    #barcode img {
        margin-top: 40px;
    }
</style>

<body>

    <header>
        <div id="company">
            <h1> Magnetism Tech Ltd</h1>
            <p><strong>Chittagong Office : </strong> C & F Tower (4th Floor), 1222, Sk. Mujib Road, Agrabad, Chittagong,
                Bangladesh. </p>
            <p><strong>Dhaka Office : </strong>Sanmar Tower (7th Floor), Plot No # 38/A, Road # 35, Gulshan-2,
                Dhaka-1212.</p>
        </div>
        <div id="companyContact">
            <p><strong>Chittagong Office : </strong></p>
            <p><span> Tell</span> : +88 02333315926-7</p>
            <p><span> Fax </span> : 88 031 2527591</p>
            <p><span> E-mail </span> : info@qclogistics.com</p>

            <p><strong>Dhaka Office : </strong></p>
            <p><span> Tell</span> : 88 02 8836811</p>
            <p><span> Fax </span> : 88 02 8836812</p>
        </div>
    </header>


    <div id="infoArea" class="mainArea">
        <div class="textCenter">
            <h2 class="textUpper"
                style="border-radius: 7px; padding: 5px 15px; border:1px solid #000; display: inline-block; margin-left: 33%; margin-bottom:0">
                Money Receipt </h2>
        </div>
        <div class="pullLeft" style="width: 500px;">
            <p> SL NO.<strong>
                    QCLOGMLO-{{ $moneyReceipt->id }}{{ $moneyReceipt->extensionNo ? "-EX-$moneyReceipt->extensionNo" : null }}</strong>
            </p>
            <p> Received with thanks from M/s. <strong class="textUpper"> {{ $moneyReceipt->client->cnfagent }}</strong>
            </p>
            <p>As handling, documentation, B/L Charges etc.</p>
            <p> A/C <strong class="textUpper"> {{ $moneyReceipt->molblInformations->principal->name }} </strong></p>
        </div>
        <div class="pullRight" style="width: 180px; margin-top:-20px">
            <p> Issue Date :<span>
                    {{ $moneyReceipt->issueDate ? date('d-M-Y', strtotime($moneyReceipt->issueDate)) : null }} </span>
            </p>
            <p> Berthing Date :<span>
                    {{ $moneyReceipt->molblInformations->mlofeederInformation->berthingDate ? date('d-m-Y', strtotime($moneyReceipt->molblInformations->mlofeederInformation->berthingDate)) : null }}
                </span></p>
            <p> From Date :<span>
                    @if (!empty($moneyReceipt->fromDate))
                        {{ date('d-m-Y', strtotime($moneyReceipt->fromDate)) }}
                    @endif
                </span></p>
            <p> Up To Date :<span>
                    @if (!empty($moneyReceipt->uptoDate))
                        {{ date('d-m-Y', strtotime($moneyReceipt->uptoDate)) }}
                    @endif
                </span></p>
            <p> Duration : <span>
                    @if (!empty($moneyReceipt->duration))
                        {{ $moneyReceipt->duration }} Day(s)
                    @endif
                </span> </p>
            <p> Free Time : <span> {{ $moneyReceipt->freeTime ? "$moneyReceipt->freeTime Day(s)" : null }} </span> </p>
            @if (!empty($moneyReceipt->chargeableDays))
                <p> Charge : <span> {{ $moneyReceipt->chargeableDays }} Day(s) </span> </p>
            @endif
        </div>
    </div> <!-- end infoArea -->

    <div id="billingArea" class="mainArea">
        <table id="billingTable">
            <tr>
                <th>B/L Nos.</th>
                <th width="120px">Charges</th>
                <th width="113px">Amount in Taka</th>
            </tr>
            <tr>
                <td class="">
                    <p> <strong>BL Ref:</strong> {{ $moneyReceipt->molblInformations->bolreference }} </p>
                    <p> <strong>Vessel:</strong>
                        {{ $moneyReceipt->molblInformations->mlofeederInformation->feederVessel }};</p>
                    <p><strong>Voyage:</strong>
                        {{ $moneyReceipt->molblInformations->mlofeederInformation->voyageNumber }}; <strong>IMP. REG.
                            No:</strong> {{ $moneyReceipt->molblInformations->mlofeederInformation->rotationNo }}</p>
                    <p> <strong>Quantity:</strong> {{ $moneyReceipt->molblInformations->packageno }}
                        {{ $moneyReceipt->molblInformations->package->description }}</p>

                    <p> Number of Contr:
                        @foreach ($contTypeCount as $key => $cont)
                            {{ $key }} x {{ $cont }}{{ !$loop->last ? ',' : null }}
                        @endforeach
                    </p>
                </td>
                <td style="width:200px">
                    @foreach ($moneyReceipt->mloMoneyReceiptDetails as $mrData)
                        {{ $mrData->particular }}<br>
                    @endforeach
                </td>
                <td class="textRight">
                    @php  $totalAmount = 0;  @endphp
                    @foreach ($moneyReceipt->mloMoneyReceiptDetails as $mrData)
                        {{ number_format($amount = $mrData->amount, 2) }}<br>
                        @php $totalAmount += $amount @endphp
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong> In word : </strong> <br>
                        Taka
                        @php
                            $digit = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                            echo ucwords($digit->format($totalAmount)) . ' Only.';
                        @endphp
                    </p>
                </td>
                <td class="textRight">
                    Total Tk. =
                </td>
                <td class="textRight">
                    <strong> {{ number_format($totalAmount, 2) }} </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3">Remarks: {{ $moneyReceipt->remarks ?? null }} </td>
            </tr>
        </table>

    </div> <!-- end billingArea -->

    <div id="footerTop">
        <div id="seal">
            <div class="pullRight textCenter">
                <h4> For: Magnetism Tech Ltd </h4>
                <br><br><br>
                <p>AS Agents</p>
            </div>
        </div>
        <div id="barcode">
            <br>
            <img
                src="data:image/png;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($moneyReceipt->clientName . ' ' . $moneyReceipt->id . ' ' . $totalAmount)) }} ">
        </div>
    </div>


    <footer>
        <p style="clear: both; text-align: center">
            <small> Print Time: {{ date('d-M-Y H:i:s a', strtotime(now())) }};</small>
            <small> Created By : {{ $moneyReceipt->createdBy }}; </small>
            @if ($moneyReceipt->updatedBy)
                <small> Updated By : {{ $moneyReceipt->updatedBy }} </small>
            @endif
        </p>
        <p style="clear: both; text-align: center">
            Software Developed By <strong>Magnetism Tech Limited</strong> |
            Website: <strong>www.magnetismtech.com</strong> <br>
            Email: <strong>info@magnetismtech.com</strong> | Cell: +88 01894 883 522;
        </p>
    </footer>
</body>

</html>
