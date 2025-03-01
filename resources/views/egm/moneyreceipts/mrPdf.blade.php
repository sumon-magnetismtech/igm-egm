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
        bottom: 0;
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
            <h1> Magnetism Tech Ltd Limited</h1>
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
                style="border-radius: 7px; padding: 5px 15px; border:1px solid #000; display: inline-block; margin-left: 33%">
                Money Receipt </h2>
        </div>
        <div class="pullLeft" style="width: 510px;">
            <p> SL NO.<strong>
                    QCLOGFRD-{{ $data->id }}{{ $data->extension_no ? "-EX-$data->extension_no" : null }}</strong>
            </p>
            <p class="my-10"> Received with thanks from M/s. <strong class="textUpper">
                    {{ $data->client_name }}</strong></p>
            <p class="my-10">As handling, documentation, B/L Charges etc.</p>
            <p class="my-10"> A/C: <strong class="textUpper"> {{ $data->accounts }} </strong></p>
        </div>
        <div class="pullRight" style="width: 200px; margin-top:-10px">
            <p> Issue Date :<span> {{ $data->issue_date ? date('d-M-Y', strtotime($data->issue_date)) : null }} </span>
            </p>
            <p> Berthing Date :<span>
                    {{ $data->houseBl->masterbl->berthing ? date('d-M-Y', strtotime($data->houseBl->masterbl->berthing)) : null }}
                </span></p>
            @if (!empty($data->from_date))
                <p> From Date :<span> {{ date('d-m-Y', strtotime($data->from_date)) }}</span></p>
            @endif
            @if (!empty($data->upto_date))
                <p> Up To Date :<span> {{ date('d-m-Y', strtotime($data->upto_date)) }} </span></p>
            @endif
            @if (!empty($data->duration))
                <p> Duration : <span> {{ $data->duration }} Day(s) </span> </p>
            @endif
            <p> Free Time : <span> {{ $data->free_time ? "$data->free_time Day(s)" : '0 Day(s)' }}</span> </p>
            @if (!empty($data->chargeable_days))
                <p> Charge : <span> {{ $data->chargeable_days }} Day(s) </span> </p>
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
                    <p class="my-5"> HBL: <strong>{{ $data->houseBl->bolreference }}</strong> </p>
                    <p class="my-5"> Vessel: <strong>{{ $data->houseBl->masterbl->fvessel }} </strong> V.
                        <strong>{{ $data->houseBl->masterbl->voyage }}</strong></p>
                    <p class="my-5">IMP. REG. No: <strong>{{ $data->houseBl->masterbl->rotno }}</strong></p>
                    <p class="my-5"> Quantity: <strong>{{ $data->quantity }}
                            {{ $data->houseBl->packagetype }}</strong> </p>

                    <p class="my-5"> Number of Contr:
                        <strong>
                            @foreach ($contTypeCount as $key => $cont)
                                {{ $key }} x {{ $cont }}{{ !$loop->last ? ',' : null }}
                            @endforeach
                        </strong>
                    </p>
                </td>
                <td style="width:200px">
                    @foreach ($data->MoneyreceiptDetail as $mrData)
                        {{ $mrData->particular }}<br>
                    @endforeach
                </td>
                <td class="textRight">
                    @foreach ($data->MoneyreceiptDetail as $mrData)
                        @php
                            echo number_format($amount = $mrData->amount, 2);
                        @endphp
                        <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong> In word : </strong> <br>
                        Taka
                        {{ Str::title($inWord) }}.
                    </p>
                </td>
                <td class="textRight">
                    Total Tk. =
                </td>
                <td class="textRight">
                    <strong>
                        @php
                            echo number_format($total, 2);
                        @endphp
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3">Remarks: {{ $data->remarks ?? null }} </td>
            </tr>
        </table>
    </div> <!-- end billingArea -->

    <div id="footerTop">
        <div id="seal">
            <div class="pullRight textCenter">
                <h4> For: Magnetism Tech Ltd Limited </h4>
                <br>
                <p>AS Agents</p>
            </div>
        </div>
        <div id="barcode">
            <br>
            <img
                src="data:image/png;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($data->client_name . ' ' . $data->id . ' ' . $total)) }} ">
        </div>
    </div>


    <footer>
        <p style="clear: both; text-align: center">
            <small> Printing Time: {{ date('d-M-y h:i:s a', strtotime(now())) }};</small>
            <small> Created By : {{ $data->createdBy }}; </small>
            @if ($data->updatedBy)
                <small> Updated By : {{ $data->updatedBy }} </small>
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
