<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Order PDF</title>
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
            margin-bottom: 10px;
        }

        #companyName {
            font-size: 36px;
            font-family: 'Book Antiqua', arial;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 36px;
            font-weight: normal;
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
            border: 1px solid #000;
            border-collapse: collapse
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

        #tableArea td {
            font-size: 11px;
        }


        table table,
        table table th,
        table table td {
            border: none;
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
            bottom: 10%;
        }

        #barcode img {
            margin-top: 0px;
        }
    </style>
</head>

<body>

    <header class="overFlow">
        <div id="logo">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div id="brand" class="textCenter">
            <h1 id="companyName">  Magnetism Tech Ltd </h1>
            <p><small>Admin Future Park, 5th Floor, Barik Building, Chittagong. Tel : +88 02333315926-7.</small>
            </p>
        </div>
        <hr width="100%">
    </header>

    <div class="addressArea">
        <div id="flotNone" style="position: absolute; left: 50%; top: 70px; transform: translateX(-50%)">
            <h2 class="textCenter" style="font-weight: normal"> DELIVERY ORDER </h2>
        </div>

        <div class="pullLeft">
            <br>
            <br>
            <br>
            <p> To </p>
            <p> <strong> The Terminal Manager </strong></p>
            <p> Chittagong Port Authority </p>
            <p> Chittagong </p>
        </div>
        <div class="pullRight">
            <div id="doInfo">
                <br><br><br><br> <br><br>
                <p> D/O No. <strong>{{ $deliveryInfo->id }}</strong> </p>
                <p> ISSUE DATE.
                    <strong>{{ $deliveryInfo->DO_Date ? date('d-M-Y', strtotime($deliveryInfo->DO_Date)) : null }}</strong>
                </p>
            </div>
        </div>
    </div> <!-- end contentArea -->
    <div class="" style="clear: both; "></div>

    <div id="tableArea overFlow">
        <table>
            <tr>
                <td colspan="3"> <strong>Custom B/E No.</strong> {{ $deliveryInfo->BE_No }} </td>
                <td colspan="4"> <strong> BE DATE:</strong>
                    {{ $deliveryInfo->BE_Date ? date('d-M-Y', strtotime($deliveryInfo->BE_Date)) : null }}</td>
            </tr>
            <tr>
                <td colspan="7"> <strong>B/L NO:</strong> {{ $deliveryInfo->moneyReceipt->bolRef }} </td>
            </tr>
            <tr>
                <td colspan="7"> Please delivery to
                    <strong>{{ $deliveryInfo->moneyReceipt->client->cnfagent }}</strong> the under mentioned goods.
                </td>
            </tr>
            <tr>
                <td colspan="3"> <strong> V. Name:
                    </strong>{{ $deliveryInfo->moneyReceipt->molblInformations->mlofeederInformation->feederVessel }}({{ $deliveryInfo->moneyReceipt->molblInformations->mlofeederInformation->voyageNumber }})
                </td>

                <td colspan="2"> <strong> Arrival DT: </strong>
                    {{ $deliveryInfo->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate ? date('d-M-Y', strtotime($deliveryInfo->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate)) : null }}
                </td>
                <td colspan="2"> <strong> Reg No.</strong>
                    {{ $deliveryInfo->moneyReceipt->molblInformations->mlofeederInformation->rotationNo }} </td>
            </tr>
            <tr>
                <td> MARKS & NOS</td>
                <td> QTY </td>
                <td> DESCRIPTIONS </td>
                <td> GROSS WEIGHT </td>
                <td> CONTAINER NO </td>
                <td> SIZE & TYPE </td>
                <td> STATUS / MODE </td>
            </tr>
            @php($countContainers = count($deliveryInfo->moneyReceipt->molblInformations->blcontainers))
            @foreach ($deliveryInfo->moneyReceipt->molblInformations->blcontainers as $blcontainer)
                <tr>
                    @if ($loop->first)
                        <td rowspan="{{ $countContainers }}">
                            {{ $deliveryInfo->moneyReceipt->molblInformations->shippingmark }} </td>
                        <td rowspan="{{ $countContainers }}">
                            {{ $deliveryInfo->moneyReceipt->molblInformations->packageno }}
                            {{ $deliveryInfo->moneyReceipt->molblInformations->package->description }} </td>
                        <td rowspan="{{ $countContainers }}" style="word-wrap: break-word">
                            {{ $deliveryInfo->moneyReceipt->molblInformations->description }} </td>
                        <td rowspan="{{ $countContainers }}">
                            {{ $deliveryInfo->moneyReceipt->molblInformations->grosswt }} </td>
                    @endif
                    <td> {{ $blcontainer->contref }} </td>
                    <td class="textCenter"> {{ $blcontainer->type }} </td>
                    <td class="textCenter"> {{ $blcontainer->status }} </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7"> VALID UP TO :<strong>
                        {{ $deliveryInfo->moneyReceipt->uptoDate ? date('d-M-Y', strtotime($deliveryInfo->moneyReceipt->uptoDate)) : null }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="7"> <strong>Remarks:</strong> <br><br> </td>
            </tr>
        </table>
    </div> <!-- tableArea -->
    <div id="footerTop">
        <div id="seal">
            <div class="pullRight textCenter">
                <h4 style="margin: 0"> For:  Magnetism Tech Ltd </h4>
                <br>
                <p style="margin: 0">AS Agents</p>
            </div>
        </div>
        <div id="barcode">
            <img
                src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(100)->generate(
                    'BL: ' . $deliveryInfo->moneyReceipt->bolRef . "\nDO: " .
                    $deliveryInfo->id . "\nIssue Date: " .
                    date('d-m-Y', strtotime($deliveryInfo->DO_Date)) . "\nClient: " .
                    $deliveryInfo->moneyReceipt->client->cnfagent
                )) }}">
        </div>
    </div>

    <footer>
        <p style="clear: both; text-align: center">
            <small> Printing Time: {{ date('d-M-Y h:i:s a', strtotime(now())) }};</small>
            <small> Created By : {{ $deliveryInfo->createdBy }}; </small>
            @if ($deliveryInfo->updatedBy)
                <small> Updated By : {{ $deliveryInfo->updatedBy }} </small>
            @endif
        </p>
        <p style="clear: both; text-align: center">
            Software Developed By <strong>Magnetism Tech Limited</strong> |
            Website: <strong>www.magnetismtech.com</strong> <br>
            Email: <strong>info@magnetismtech.com</strong> | Cell: +88 01717 103 605; +88 01713 220 257
        </p>
    </footer>
</body>

</html>
