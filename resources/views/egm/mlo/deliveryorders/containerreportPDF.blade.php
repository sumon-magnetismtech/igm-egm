<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Container ReportPDF</title>
    <style>
        body{margin: 0;padding: 0;font-family: sans-serif;font-size:14px;}
        body p{margin-top: 1px;margin-bottom: 1px;}
        header{position: relative;}
        .overFlow{overflow: hidden;}
        #logo{position: absolute;top: 5px;left: 0;}
        .textCenter{text-align: center;}

        #companyName{
            font-size: 36px;
            font-family: 'Book Antiqua', arial;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 36px;
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
        table, table th, table td {border-spacing: 0;border: 1px solid #000;border-collapse: collapse}
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
        table{
            width: 100%;
        }
        table, table th, table td {
            border-spacing: 0;
            padding-bottom: 0;
            border-collapse: collapse;
            border:1px solid #000000;
            font-size: 10px;
            text-align: center;
        }

        table th, table td{
            padding:3px;
        }
    </style>
</head>
<body>

<header class="overFlow">
    <div id="logo">
        <img src="{{asset('img/logo.jpeg')}}" alt="Logo">
    </div>
    <div id="brand" class="textCenter">
        <h1 id="companyName"> QC Logistics Limtied </h1>
        <p ><small> C&F Tower, 4th Floor, 1222 Sk. Mujib Road, Agrabad, Chittagong. Tel : +88 02333315926-7.</small></p>
    </div>
    <hr width="100%">
</header>

<div class="addressArea overFlow">
    <h3 class="textCenter" style=""> Container List Against Delivery Order (Main Line) </h3>
    <p style="text-align: center; margin-bottom: 10px">
        DO Date:
        @if($dateType == "weekly")
            {{now()->subDays(7)->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @elseif($dateType=="monthly")
            {{now()->subDays(30)->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @elseif($dateType=="custom")
            {{$fromDate ? date('d-m-Y', strtotime($fromDate)) : null}} to {{$tillDate ? date('d-m-Y', strtotime($tillDate)) : null}}
        @else
            {{now()->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @endif
    </p>
</div> <!-- end contentArea -->
<div style="clear: both; "></div>

<div id="tableArea overFlow">
    <table id="example" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>DO Date </th>
            <th>Container </th>
            <th>Type</th>
            <th>Status</th>
            <th>Upto</th>
            <th>HBL</th>
            <th>Vessel Name</th>
            <th>Voyage</th>
            <th>Rotation</th>
            <th>Principal</th>
        </tr>
        </thead>
        <tbody>
        @forelse($mloblInformations as $key => $mloblInformation)
            @foreach($mloblInformation->blcontainers as $container)
                <tr>
                    <td> <nobr>{{$mloblInformation->mloMoneyReceipt->deliveryOrder->DO_Date ? date('d-m-Y', strtotime($mloblInformation->mloMoneyReceipt->deliveryOrder->DO_Date)) : null}}</nobr> </td>
                    <td> {{$container->contref}} </td>
                    <td> {{$container->type}} </td>
                    <td> {{$container->status}} </td>
                    <td> <nobr>{{$mloblInformation->mloMoneyReceipt->uptoDate ? date('d-m-Y', strtotime($mloblInformation->mloMoneyReceipt->uptoDate)) : null}}</nobr> </td>
                    @if($loop->first)
                        <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->bolreference}} </td>
                        <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->feederVessel}} </td>
                        <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->voyageNumber}} </td>
                        <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->rotationNo}} </td>
                        <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->principal->name}} </td>
                    @endif
                </tr>
            @endforeach
        @empty

        @endforelse

        </tbody>
    </table>
</div> <!-- tableArea -->


<footer>
    <p style="clear: both; text-align: center">
        <small> Printing Time: {{date('d-M-Y h:i:s a', strtotime(now()))}};</small>
    </p>
    <p style="clear: both; text-align: center">
        Software Developed By <strong>Magnetism Tech Limited</strong> |
        Website: <strong>www.magnetismtech.com</strong> <br>
        Email: <strong>info@magnetismtech.com</strong> | Cell: +88 01717 103 605; +88 01713 220 257
    </p>
</footer>
</body>
</html>