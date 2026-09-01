<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
    <table>
        <thead>
            <tr>
                <td colspan="8" style="text-align: center; font-weight: bold; font-size: 13px;">CASH RECEIPTS RECORD</td>
            </tr>
            <tr>
                <td colspan="8" style="text-align: center; font-size: 10px;">For the month of {{ $header['month'] }} {{ $header['year'] }}</td>
            </tr>
            <tr><td colspan="8"></td></tr>
            <tr>
                <td colspan="4" style="font-size: 10px;">Accountable Officer: {{ $header['officer'] }}</td>
                <td colspan="4" style="font-size: 10px;">Station: {{ $header['station'] }}</td>
            </tr>
            <tr><td colspan="8"></td></tr>
            <tr style="background-color:#c8c8c8; font-size: 9px;">
                <td style="width: 90px; text-align: center; font-weight: bold;">Date</td>
                <td style="width: 110px; text-align: center; font-weight: bold;">Reference No.</td>
                <td style="width: 220px; text-align: center; font-weight: bold;">Payor</td>
                <td style="width: 150px; text-align: center; font-weight: bold;">Nature of Collection</td>
                <td style="width: 110px; text-align: center; font-weight: bold;">Collection</td>
                <td style="width: 110px; text-align: center; font-weight: bold;">BTR</td>
                <td style="width: 110px; text-align: center; font-weight: bold;">Trust Fund</td>
                <td style="width: 130px; text-align: center; font-weight: bold;">Undeposited Collection</td>
            </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr style="font-size: 9px;">
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['reference'] }}</td>
                <td>{{ $row['payor'] }}</td>
                <td>{{ $row['nature'] }}</td>
                <td style="text-align: right;">{{ $row['collection'] }}</td>
                <td style="text-align: right;">{{ $row['btr'] }}</td>
                <td style="text-align: right;">{{ $row['trust'] }}</td>
                <td style="text-align: right;">{{ $row['undeposited'] }}</td>
            </tr>
        @endforeach
            <tr style="font-size: 10px; font-weight: bold; background-color:#e6e6e6;">
                <td colspan="4" style="text-align: right; padding-right: 10px;">TOTAL</td>
                <td style="text-align: right;">{{ $totals['collection'] }}</td>
                <td style="text-align: right;">{{ $totals['btr'] }}</td>
                <td style="text-align: right;">{{ $totals['trust'] }}</td>
                <td style="text-align: right;">{{ $totals['undeposited'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
