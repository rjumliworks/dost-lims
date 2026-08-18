<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Executive Summary - {{ $month }} {{ $year }}</title>
    <style>
        html * {
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, td, th {
            border: 0.5px solid black;
        }
        th {
            padding: 4px;
            background-color: #c8c8c8;
        }
        td {
            padding: 4px;
        }
        tfoot th {
            background-color: #e8e8e8;
        }
        h2 {
            font-size: 12px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
    <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">Department of Science and Technology - IX</center>
    <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">Regional Standards and Testing Laboratories</center>
    <center style="font-size: 12px; font-weight: bold; margin-top: 10px;">Executive Summary Report</center>
    <center style="font-size: 11px;">{{ $month }} {{ $year }}</center>

    <h2>Laboratory Accomplishment</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: left;">Laboratory</th>
                <th style="width: 60px; text-align: center;">Requests</th>
                <th style="width: 60px; text-align: center;">Samples</th>
                <th style="width: 60px; text-align: center;">Analyses</th>
                <th style="width: 90px; text-align: center;">Fees Collected</th>
                <th style="width: 80px; text-align: center;">Gratis</th>
                <th style="width: 80px; text-align: center;">Discount</th>
                <th style="width: 90px; text-align: center;">Gross</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laboratories as $row)
                <tr>
                    <td>{{ $row[0] }}</td>
                    <td style="text-align: center;">{{ $row[1] }}</td>
                    <td style="text-align: center;">{{ $row[2] }}</td>
                    <td style="text-align: center;">{{ $row[3] }}</td>
                    <td style="text-align: center;">{{ $row[4] }}</td>
                    <td style="text-align: center;">{{ $row[5] }}</td>
                    <td style="text-align: center;">{{ $row[6] }}</td>
                    <td style="text-align: center;">{{ $row[7] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>{{ $totals[0] }}</th>
                <th style="text-align: center;">{{ $totals[1] }}</th>
                <th style="text-align: center;">{{ $totals[2] }}</th>
                <th style="text-align: center;">{{ $totals[3] }}</th>
                <th style="text-align: center;">{{ $totals[4] }}</th>
                <th style="text-align: center;">{{ $totals[5] }}</th>
                <th style="text-align: center;">{{ $totals[6] }}</th>
                <th style="text-align: center;">{{ $totals[7] }}</th>
            </tr>
        </tfoot>
    </table>

    <h2>Request Type Mix</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: left;">Type</th>
                <th style="width: 100px; text-align: center;">Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Local</td>
                <td style="text-align: center;">{{ $referral['Local'] }}</td>
            </tr>
            <tr>
                <td>Referral</td>
                <td style="text-align: center;">{{ $referral['Referral'] }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Top Customers</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 40px; text-align: center;">No.</th>
                <th style="text-align: left;">Customer</th>
                <th style="width: 100px; text-align: center;">No. of Requests</th>
            </tr>
        </thead>
        <tbody>
            @forelse($top_customers as $index => $customer)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $customer['name'] }}</td>
                    <td style="text-align: center;">{{ $customer['count'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No data for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
