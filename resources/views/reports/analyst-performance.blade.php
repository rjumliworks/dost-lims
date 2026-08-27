<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
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
            margin-top: 12px;
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
        .meta-table, .meta-table td {
            border: none;
        }
    </style>
</head>
<body>
    <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">Department of Science and Technology - IX</center>
    <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">Regional Standards and Testing Laboratories</center>
    <center style="font-size: 12px; font-weight: bold; margin-top: 10px;">{{ $title }}</center>

    <table class="meta-table">
        <tr>
            <td style="padding: 2px;"><strong>Analyst:</strong> {{ $analyst }}</td>
            <td style="padding: 2px;"><strong>Laboratory:</strong> {{ $laboratory }}</td>
            <td style="padding: 2px;"><strong>Period:</strong> {{ $period }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="text-align: left;">Month</th>
                <th style="text-align: center;">No. of Test Performed</th>
                <th style="text-align: center;">Samples Handled</th>
                <th style="text-align: center;">Avg. Turnaround (days)</th>
                <th style="text-align: center;">Total Test Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthly as $month => $row)
                <tr>
                    <td>{{ $month }}</td>
                    <td style="text-align: center;">{{ $row['tests_performed'] }}</td>
                    <td style="text-align: center;">{{ $row['samples_handled'] }}</td>
                    <td style="text-align: center;">{{ $row['avg_turnaround_days'] ?? '-' }}</td>
                    <td style="text-align: right;">{{ number_format($row['total_cost'], 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total</strong></td>
                <td style="text-align: center;"><strong>{{ $summary['tests_performed'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $summary['samples_handled'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $summary['avg_turnaround_days'] ?? '-' }}</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($summary['total_cost'], 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
