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
    </style>
</head>
<body>
    <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">Department of Science and Technology - IX</center>
    <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">Regional Standards and Testing Laboratories</center>
    <center style="font-size: 12px; font-weight: bold; margin-top: 10px;">{{ $title }}</center>

    <table>
        <thead>
            <tr>
                <th style="width: 40px; text-align: center;">No.</th>
                <th style="text-align: left;">Name</th>
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
