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
                    <th colspan="3" style="text-align: center; font-size: 14px;">{{ $title }}</th>
                </tr>
                <tr>
                    <th style="width: 50px; text-align: center;">No.</th>
                    <th style="width: 400px; text-align: left;">Name</th>
                    <th style="width: 100px; text-align: center;">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $index => $row)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $row['name'] }}</td>
                        <td style="text-align: center;">{{ $row['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
