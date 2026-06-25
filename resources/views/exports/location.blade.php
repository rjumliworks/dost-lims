<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<table border="1">
    <thead>
        <tr>
            <th style="width: 30px; text-align: center; font-weight: bold;" rowspan="3">No.</th>
            <th style="width: 500px; text-align: center; font-weight: bold;" rowspan="3">Customer Name</th>
            <th style=" text-align: center; font-weight: bold;" colspan="12">Address / District</th>
            <th style=" text-align: center; font-weight: bold;" colspan="2">Firm</th>
            <th style="text-align: center; font-weight: bold;" colspan="5">Individual</th>
            <th style=" text-align: center; font-weight: bold;" rowspan="3">New</th>
        </tr>
        <tr>
            <th style="text-align: center;" rowspan="2">IC</th>
            <th style="text-align: center;" rowspan="2">Sulu</th>
            <th style="text-align: center;" colspan="2">ZC</th>
            <th style="text-align: center;" colspan="3">ZDN</th>
            <th style="text-align: center;" colspan="2">ZDS</th>
            <th style="text-align: center;" colspan="2">ZSP</th>
            <th style="text-align: center;" rowspan="2">Outside</th>
            <th style="text-align: center;" colspan="2">Sex</th>
            <th style="text-align: center;" colspan="3">Status</th>
        </tr>
        <tr>
            <th style="text-align: center;">1st</th>
            <th style="text-align: center;">2nd</th>
            <th style="text-align: center;">1st</th>
            <th style="text-align: center;">2nd</th>
            <th style="text-align: center;">3rd</th>
            <th style="text-align: center;">1st</th>
            <th style="text-align: center;">2nd</th>
            <th style="text-align: center;">1st</th>
            <th style="text-align: center;">2nd</th>
            <th style="text-align: center;">Paying</th>
            <th style="text-align: center;">Non-Pay</th>
            <th style="text-align: center;">Male</th>
            <th style="text-align: center;">Female</th>
            <th style="text-align: center;">Student</th>
            <th style="text-align: center;">Senior</th>
            <th style="text-align: center;">PWD</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lists as $index => $item)
            <tr >
                <td style="text-align: center;" >{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $item['name'] }}</td>

                <td style="text-align: center;">{{ $item['ic'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['sulu'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zc1'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zc2'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zdn1'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zdn2'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zdn3'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zds1'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zds2'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zsp1'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['zsp2'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['outside'] ? '✔' : '' }}</td>

                <td style="text-align: center;">{{ $item['paying'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['nonpay'] ? '✔' : '' }}</td>

                <td style="text-align: center;">{{ $item['male'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['female'] ? '✔' : '' }}</td>

                <td style="text-align: center;">{{ $item['student'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['senior'] ? '✔' : '' }}</td>
                <td style="text-align: center;">{{ $item['pwd'] ? '✔' : '' }}</td>

                <td style="text-align: center;">{{ $item['isnew'] ? '✔' : '✖' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
