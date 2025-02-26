<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Order PDF</title>
    <style>
        body{margin: 0;padding: 0;font-family: sans-serif;font-size:14px;}
        body p{margin-top: 1px;margin-bottom: 1px;}
        header{position: relative;}
        .overFlow{overflow: hidden;}
        #logo{position: absolute;top: 5px;left: 0;}
        .textUpper{text-transform: uppercase;}
        .textCenter{text-align: center;}
        .textRight{text-align:right;}
        .pullLeft{float:left;width:55%;display: block;}
        .pullRight{float:right;width: 35%;display: block;}
        .pullLeft, .pullRight{margin-bottom: 10px;    }

        #companyName{
            font-size: 36px;
            font-family: 'Book Antiqua', arial;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 36px;
            font-weight: normal;
        }
        #seal{
            font-family: 'Book Antiqua', arial;
            font-size: 18px;
            font-weight: normal;
        }
        #seal h4{
            font-size: 18px;
            font-weight: normal;
        }
        #addressArea h2{
            padding:10px 5px;
            color: #000;
            border: 2px solid #000;
            border-radius: 5px;
            font-size:18px;
        }
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #000;}
        table th, table td{padding:5px;}
        #doInfo{border: 1px solid #000;}
        #doInfo p{border-top: 1px solid #000;padding: 5px;}
        #flotNone{margin: 0 auto;display: block;text-align: center;width: 40%;}

        table table, table table th, table table td {border: none;}

        footer {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
            display: block;
        }

        #footerTop{
            position: fixed;
            bottom: 15%;
        }
        #barcode img{
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header class="overFlow">
    <div id="logo">
        <img src="{{ public_path('img/logo.jpeg')}}" alt="Logo">
    </div>
    <div id="brand" class="textCenter">
        <h1 id="companyName"> QC Logistics Limited </h1>
        <p ><small> C&F Tower, 4th Floor, 1222 Sk. Mujib Road, Agrabad, Chittagong. Tel : +88 02333315926-7.</small></p>
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
            <p> D/O No. <strong>QCLOGFRD-{{$moneyReceipt->deliveryOrder->id}}</strong> </p>
            <p> ISSUE DATE. <strong>{{date('d-M-Y', strtotime($moneyReceipt->deliveryOrder->issue_date))}}</strong></p>
        </div>
    </div>
</div> <!-- end contentArea -->
<div class="" style="clear: both; "></div>

<div id="tableArea overFlow">
    <table>
        <tr>
            <td colspan="3"> <strong>Custom B/E No.</strong> {{$moneyReceipt->deliveryOrder->BE_No}} </td>
            <td colspan="4"> <strong> BE DATE:</strong> {{$moneyReceipt->deliveryOrder->BE_Date ? date('d-M-Y', strtotime($moneyReceipt->deliveryOrder->BE_Date)) : null}}</td>
        </tr>
        <tr>
            <td colspan="3"> <strong>MBL NO:</strong> {{$moneyReceipt->houseBl->masterbl->mblno}} </td>
            <td colspan="4"> <strong>HB/L NO:</strong> {{$moneyReceipt->houseBl->bolreference}} </td>
        </tr>
        <tr>
            <td colspan="7"> Please delivery to <strong>{{$moneyReceipt->client_name}}</strong> the under mentioned goods.</td>
        </tr>
        <tr>
            <td colspan="3"> <strong> V. Name:  </strong>{{$moneyReceipt->houseBl->masterbl->fvessel}} V.{{$moneyReceipt->houseBl->masterbl->voyage}}</td>
            <td colspan="2"> <strong> Arrival DT: </strong> {{$moneyReceipt->houseBl->masterbl->arrival ? date('d-M-Y', strtotime($moneyReceipt->houseBl->masterbl->arrival)) : null}} </td>
            <td colspan="2"> <strong> Reg No.</strong> {{$moneyReceipt->houseBl->masterbl->rotno}} </td>
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

        <tr>
            <td> {{$moneyReceipt->houseBl->shippingmark}} </td>
            <td> {{$moneyReceipt->houseBl->packageno}} {{$moneyReceipt->houseBl->packagetype}} </td>
            <td style="word-wrap: break-word"> {{$moneyReceipt->houseBl->description}} </td>
            <td> {{$moneyReceipt->houseBl->grosswt}} KGS </td>
            <td>
                <table>
                    @foreach($containers as $container)
                        <tr>
                            <td> {{$container->contref}} {{$loop->first ? "": null}} </td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                <table>
                    @foreach($containers as $container)
                        <tr>
                            <td> {{$container->type}} </td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                <table>
                    @foreach($containers as $container)
                        <tr>
                            <td> {{$container->status}} </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="7"> VALID UP TO :<strong> {{$moneyReceipt->deliveryOrder->upto_date ? date('d-M-Y', strtotime($moneyReceipt->deliveryOrder->upto_date)) : null}}</strong> </td>
        </tr>
        <tr>
            <td colspan="7"> <strong>Remarks:</strong> <br><br> </td>
        </tr>
    </table>
</div> <!-- tableArea -->

<div id="footerTop">
    <div id="seal">
        <div class="pullRight textCenter">
            <h4> For: QC Logistics Limited </h4>
            <br>
            <p>AS Agents</p>
        </div>
    </div>

    <div id="barcode">
        <img src="data:image/png;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)
    ->generate("BL: ".$moneyReceipt->houseBl->bolreference. "\nDO: QCLOGFRD-".$moneyReceipt->deliveryOrder->id."\nIssue Date: ".date('d-m-Y', strtotime($moneyReceipt->deliveryOrder->issue_date))."\n Client: ".$moneyReceipt->client_name)) }} ">
    </div>
</div>


<footer>
    <p style="clear: both; text-align: center">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
    <p style="clear: both; text-align: center">
        Software Developed By <strong>Magnetism Tech Limited</strong> |
        Website: <strong>www.magnetismtech.com</strong> <br>
        Email: <strong>info@magnetismtech.com</strong> | Cell: +88 01717 103 605; +88 01713 220 257
    </p>
</footer>
</body>
</html>
