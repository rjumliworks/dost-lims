<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Styles for the footer */
        @page {

        }

        html * {
            font-family:Arial, Helvetica, sans-serif;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        .content {
            margin-bottom:55px; /* Space for the footer */
        }

        table,
        td,
        th {
            border: .5px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            padding: 3px;
            vertical-align: top;
        }
        td {
            padding: 3px;
            /* vertical-align: top; */
            /* text-align: center; */
        }
        </style>
    </head>
<body>
    <div class="content">
        <div style="font-family:Arial;">
            <img src="{{ public_path('images/logo-sm.png') }}" alt="tag" style="position: absolute; top: -4; left: 60; width: 50px; height: 50px;">
            <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">DEPARTMENT OF SCIENCE AND TECHNOLOGY - IX</center>
            <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">REGIONAL STANDARDS AND TESTING LABORATORIES</center>
            <center style="font-size: 11px;">Pettit Barracks, Zamboanga City | ord@ro9.dost.gov.ph</center>


        </div>
        <center style="margin-top: 15px; font-size: 10px; background-color: #000; color:#fff; font-weight: bold; padding: 4px; text-transform: uppercase">Customers from {{ $province ?? '-' }}</center>
         <table style="border: 1px solid black; font-size: 10px; margin-top: 0px;">
            <tbody>
                <tr>
                    <td width="25%">Year : </td>
                    <td width="25%"><span style="color: #072388;">{{($year) ? $year : '-'}}</span></td>
                    <td width="25%">Laboratory :</td>
                    <td width="25%"><span style="color: #072388;">{{($laboratory) ? $laboratory : '-'}}</span></td>
                </tr>
                   <tr>
                    <td width="25%">Classification : </td>
                    <td width="25%"><span style="color: #072388;">{{($classification) ? $classification.'s' : '-'}}</span></td>
                    <td width="25%">No. of Customers :</td>
                    <td width="25%"><span style="color: #072388;">{{count($lists)}}</span></td>
                </tr>
            </tbody>
        </table>
        <table style="border: 1px solid black; font-size: 10px; margin-top: 22px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr>
                    <th style="vertical-align: middle;" width="5%">#</th>
                    <th style="vertical-align: middle; text-align: left;" width="45%">Customer Name</th>
                    <th style="vertical-align: middle;" width="20%">Classification</th>
                    <th style="vertical-align: middle;" width="15%">No. of Request</th>
                    <th style="vertical-align: middle;" width="15%">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $dtr)
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td>{{ $dtr['fullname'] }}</td>
                        <td>{{ $dtr['customer_name']['classification']['name'] ?? '-' }}</td>
                        <td style="text-align:center;">{{ $dtr['tsrs_count'] }}</td>
                        <td style="text-align:center;">P{{ number_format($dtr['total_amount'], 2) }}</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr style="background-color:#c8c8c8; font-weight: bold;">
                    <td colspan="3" style="text-align:right;">Total :</td>
                    <td style="text-align:center;">{{ $lists->sum('tsrs_count') }}</td>
                    <td style="text-align:center;">P{{ number_format($lists->sum('total_amount'), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
