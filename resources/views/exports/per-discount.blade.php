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
                    <th style="text-align: center; vertical-align: middle;">No.</th>
                    <th style="text-align: center; vertical-align: middle;">TSR No.</th>
                    <th style="text-align: center; vertical-align: middle;">Customer Name</th>
                    <th style="text-align: center; vertical-align: middle;">No. of Samples</th>
                    <th style="text-align: center; vertical-align: middle;">No. of Services</th>
                    <th style="text-align: center; vertical-align: middle;">Fees Collected</th>
                    <th style="text-align: center;">Discount</th>
                    <th style="text-align: center; vertical-align: middle;">Gross Amount</th>
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

                        <td style="width: 100px; text-align: center;">{{ $item['discount'] }}</td>
                       

                        <td style="width: 100px; text-align: center;">{{ $item['gross'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>
