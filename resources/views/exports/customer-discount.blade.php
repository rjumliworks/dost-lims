<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Export</title>
    </head>
    <body>
        <table border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No.</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">TSR No.</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Customer Name</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No. of Samples</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No. of Services</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Fees Collected</th>
                    <th colspan="3" style="text-align: center;">Gratis</th>
                    <th colspan="5" style="text-align: center;">Discount</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Gross Amount</th>
                </tr>
                <tr>
                    <th style="text-align: center;">Calibration</th>
                    <th style="text-align: center;">QC</th>
                    <th style="text-align: center;">R&amp;D</th>
                    <th style="text-align: center;">Health Units</th>
                    <th style="text-align: center;">Student</th>
                    <th style="text-align: center;">Senior Citizen</th>
                    <th style="text-align: center;">PWD</th>
                    <th style="text-align: center;">Women&#39;s</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $index => $item)
                    <tr>
                        <td style="width: 35px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="width: 140px; text-align: center;">{{ $item['code'] }}</td>
                        <td style="width: 500px;">{{ $item['name'] }}</td>
                        <td style="text-align: center;">{{ $item['samples'] }}</td>
                        <td style="text-align: center;">{{ $item['analyses'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['fees'] }}</td>

                        <td style="width: 100px; text-align: center;">{{ $item['calibration'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['qc'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['rd'] }}</td>

                        <td style="width: 100px; text-align: center;">{{ $item['health'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['student'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['senior'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['pwd'] }}</td>
                        <td style="width: 100px; text-align: center;">{{ $item['women'] }}</td>

                        <td style="width: 100px; text-align: center;">{{ $item['gross'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>
