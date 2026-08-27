<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{ $title }}</title>
    </head>
    <body>
        <table border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center; font-size: 14px;">{{ $title }}</th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">{{ $analyst }} &mdash; {{ $laboratory }} &mdash; {{ $period }}</th>
                </tr>
                <tr>
                    <th style="text-align: left;">Month</th>
                    <th style="width: 130px; text-align: center;">No. of Test Performed</th>
                    <th style="width: 120px; text-align: center;">Samples Handled</th>
                    <th style="width: 130px; text-align: center;">Avg. Turnaround (days)</th>
                    <th style="width: 120px; text-align: center;">Total Test Cost</th>
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
