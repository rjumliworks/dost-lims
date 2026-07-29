<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
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
            vertical-align: top;
        }
        .lab-row th {
            background-color: #072388;
            color: #fff;
        }
        .category-row th {
            background-color: #eaeaea;
            text-align: left;
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
        <center style="margin-top: 15px; font-size: 10px; background-color: #000; color:#fff; font-weight: bold; padding: 4px; text-transform: uppercase">Customers Requesting</center>
        <table style="border: 1px solid black; font-size: 10px; margin-top: 0px;">
            <tbody>
                <tr>
                    <td width="25%">Year : </td>
                    <td width="75%"><span style="color: #072388;">{{ $year ?? '-' }}</span></td>
                </tr>
            </tbody>
        </table>

        @php
            $categories = [
                'monthly'    => 'At least once a month',
                'quarterly'  => 'At least once every three months',
                'semiannual' => 'At least once every six months',
                'yearly'     => 'At least once in a year',
            ];
        @endphp

        @foreach($laboratories as $lab)
            <table style="margin-top: 15px;">
                <thead>
                    <tr class="lab-row">
                        <th style="text-align: left;">{{ $loop->iteration }}. {{ $lab['laboratory'] }}</th>
                    </tr>
                </thead>
            </table>

            @foreach($categories as $key => $label)
                <table style="margin-top: 4px;">
                    <thead>
                        <tr class="category-row">
                            <th colspan="5">{{ $label }} ({{ $lab[$key] }})</th>
                        </tr>
                        <tr>
                            <th width="6%" style="text-align:center;">#</th>
                            <th width="34%" style="text-align:left;">Customer Name</th>
                            <th width="20%" style="text-align:left;">Email</th>
                            <th width="15%" style="text-align:left;">Mobile</th>
                            <th width="25%" style="text-align:left;">Months</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lab['customers'][$key] as $index => $customer)
                            <tr>
                                <td style="text-align:center;">{{ $index + 1 }}</td>
                                <td>{{ $customer['customer'] }}</td>
                                <td>{{ $customer['email'] ?? '-' }}</td>
                                <td>{{ $customer['mobile'] ?? '-' }}</td>
                                <td>{{ $customer['months'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#666;">None</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endforeach
        @endforeach
    </div>
</body>
</html>
