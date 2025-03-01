<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PDF Report</title>
    <style>
        h1 {
            text-align: center;
            font-family: Arial;
        }

        .left-space {

            position: relative;
            left: 50px;

        }

        table,
        th,
        td {

            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <h1>Import General Manifest</h1>
    <p class="first-p"><strong style="color: #8f4800">Vessel: </strong>{{ $houseblquery->vesselname }} <strong
            style="color: #8f4800">Voyage: </strong>{{ $houseblquery->voyage }} <strong style="color: #8f4800">Rotation:
        </strong> {{ $houseblquery->rotation }} <span><strong style="color: #8f4800">AIN: </strong> 301043125</span> -
        Magnetism Tech Ltd LIMITED - C&F TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG</p>
    <table>
        <thead>
            <tr>
                <th>Line</th>
                <th>BL No</th>
                <th>Num</th>
                <th>Desc</th>
                <th>Marks & No</th>
                <th>Description</th>
                <th>Exporter</th>
                <th>Consignee</th>
                <th>Notify</th>
                <th>Gross W</th>
                <th>Cbm</th>
                <th>N.Co</th>
                <th>Contr</th>
                <th>Seal No</th>
                <th>Size</th>
                <th>Sta</th>
                <th>Qty</th>
                <th>Weight</th>
                <th>Co</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($houseblquerys as $housebl)
                <tr>
                    <td>{{ $housebl->line }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
