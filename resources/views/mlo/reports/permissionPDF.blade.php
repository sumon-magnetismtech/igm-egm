<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permission Letter PDF</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 16px;
        }

        body p {
            margin-top: 1px;
            margin-bottom: 1px;
            line-height: 25px
        }

        header {
            position: relative;
            display: block;
            font-size: 11px;
            height: 120px;
        }

        #company {
            width: 520px;
            float: left;
        }

        #company h1 {
            font-family: 'Book Antiqua', arial;
            margin-top: 48px;
            font-size: 50px;
            line-height: 0;
        }

        .spacing {
            font-size: 12px;
            letter-spacing: .24em;
            text-align: center;
            margin-right: -30px;
        }

        #companyContact {
            float: right;
            width: 170px;
        }

        #companyContact p {
            line-height: 18px;
        }

        #companyContact p span {
            width: 40px;
            display: inline-block;
        }

        footer {
            position: fixed;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 30px;
            width: 100%;
        }

        footer p {
            font-size: 14px;
            line-height: 14px;
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
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .mrTB {
            margin-top: 15px;
            margin-bottom: 15px
        }

        #brand p {
            text-transform: uppercase;
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

        .page_break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($blinformationGroups as $unloadingKey => $blinformationGroup)
        <header>
            <div class="">
                <div id="company">
                    <h1> Magnetism Tech Ltd</h1>
                </div>

                <div id="companyContact">
                    <p><span> Tell</span> : 88 031 720415, 721659</p>
                    <p><span> </span> : 2510220</p>
                    <p><span> Fax </span> : 88 031 2527591</p>
                    <p style="margin-bottom: 0"><span> E-mail </span> : info@qclogistics.com</p>
                </div>
                <hr width="100%" style="display: block; clear: both; margin: 0 -50px">
                <p class="spacing"> C & F Tower (4th Floor), 1222, Sk. Mujib Road, Agrabad, Chittagong, Bangladesh. </p>
            </div>
        </header>

        <div class="addressArea">
            <p class="textRight"> Date: {{ now()->format('d F, Y') }} </p>
            <div class="mrTB">
                <p> The Terminal Manager </p>
                <p> Container Terminal Bhaban </p>
                <p> Chittagong Port Authority </p>
                <p> Chittagong. </p>
            </div>
        </div> <!-- end contentArea -->
        <div id="subject">
            <p>
                <strong> Subject: </strong>
                Permission of removal of

                @php
                    $typeCount = App\MLO\Blcontainer::whereIn('mloblinformation_id', $blinformationGroup->pluck('id'))
                        ->get('type')
                        ->groupBy('type')
                        ->map(function ($item, $key) {
                            return collect($item)->count();
                        });
                @endphp

                @foreach ($typeCount as $type => $count)
                    <strong>
                        <nobr>{{ $count }}x{{ $type }}
                    </strong></nobr>{{ !$loop->last ? ' + ' : null }}
                @endforeach
                FCL
                {{ $unloadingKey == 'BDPNG' ? 'Pangaon' : 'ICD' }}
                Containers from Chittagong Port Yard to
                {{ $unloadingKey == 'BDPNG' ? 'Pangaon, Dhaka by Bangladesh Costal vessel carried' : 'Kamalapur, Dhaka ICD by Bangladesh Railway carried per' }}
                the vessel
                <strong>{{ $blinformationGroup->first()->mlofeederInformation->feederVessel }}</strong>.<br>
                REG No. <strong>{{ $blinformationGroup->first()->mlofeederInformation->rotationNo }}</strong>
            </p>
        </div>
        <div class="" style="clear: both"></div>

        <div class="contentArea overFlow" style="text-align: justify">
            @if ($unloadingKey == 'BDPNG')
                <p class="mrTB"> Dear Sir, </p>
                <p class="mrTB">
                    We Shall be highly obliged if you would kindly allow us to remove the above containers from
                    Chittagong Port Authority to Pangaon, Dhaka.
                </p>
                <p class="mrTB">
                    The necessary port charges and costal freight for Pangaon destined container at Pangaon will be
                    adjusted from our RDA Account No: 63239003 and 63951005 respectively maintaining with One Bank port
                    branch, Chittagong and 02 (Two) copies of Manifest are enclosed herewith for doing by the needful at
                    your end.
                </p>
                <p class="mrTB">
                    The removal operation will be down by Chittagong Port Authority, Chittagong.
                </p>
            @endif

            @if ($unloadingKey == 'BDKAM')
                <p class="mrTB"> Dear Sir, </p>
                <p class="mrTB">
                    We Shall be highly obliged if you would kindly allow us to remove the above containers from
                    Chittagong Port Authority Container will be done by Chittagong Port Authority CTG..
                </p>
                <p class="mrTB">
                    The necessary Port charges and Railway freight for ICD destined container at Dhaka will be adjusted
                    from our RDA Account no-3623903 and 63951005 respectively maintaining with one Bank, port branch,
                    Chittagong and 2 (two) copies of Manifest are enclosed herewith for doing by the needful at your
                    end.
                </p>
                <p class="mrTB">
                    The removal operation will be down by Chittagong Port Authority, Chittagong.
                </p>
                <p class="mrTB">
                    We hereby declare that no dangerous goods of hazardous cargo carried in thus here ICD Container.
                </p>
            @endif

            <p>Truly Yours,</p><br><br><br>
            <p> As Agents</p>
            <p> For: <strong> Magnetism Tech Ltd.</strong></p>
        </div> <!-- end contentArea -->

        <footer class="">
            <p style="clear: both; text-align: center">
                <small> Sanmar Tower (7th Floor), Plot No # 38/A, Road # 35, Gulshan-2, Dhaka-1212.</small> <br>
                <small> Tell: 88 02 8836811, Fax: 88 02 8836812 </small><br>
                <strong> Registered Office: Goods Hill, Rahmatgonj, Chittagong, Bangladesh. </strong>
            </p>
        </footer>
        @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
