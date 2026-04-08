<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Styles for the footer */
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
            /* vertical-align: top; */
            /* text-align: center; */
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
        <center style="margin-top: 15px; font-size: 10px; background-color: #000; color:#fff; font-weight: bold; padding: 4px; text-transform: uppercase">{{$title}}</center>
         <table style="border: 1px solid black; font-size: 10px; margin-top: 0px;">
            <tbody>
                <tr>
                    <td width="25%">Year : </td>
                    <td width="25%"><span style="color: #072388;">{{($year) ? $year : '-'}}</span></td>
                    <td width="25%">{{$by}} :</td>
                    <td width="25%">
                        <span style="color: #072388;">
                            {{
                                $by == 'Month' ? ($month ?? '-') :
                                ($by == 'Quarter' ? ($quarter ?? '-') :
                                ($by == 'Semester' ? ($semester ?? '-') : '-'))
                            }}
                        </span>
                    </td>
                </tr>
                   <tr>
                    <td width="25%">Classification : </td>
                    <td width="25%"><span style="color: #072388;">{{($classification) ? $classification.'s' : '-'}}</span></td>
                    <td width="25%">Type :</td>
                    <td width="25%"><span style="color: #072388;">{{$external}} Customers</span></td>
                </tr>
            </tbody>
        </table>
        <table style="border: 1px solid black; font-size: 10px; margin-top: 22px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr>    
                    <th style="vertical-align: middle;" width="5%">#</th>
                    <th style="vertical-align: middle; text-align: left;" width="87%">Customer Name</th>
                    <th style="vertical-align: middle;" width="15%">No. of Request</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $dtr)  <!-- 🔥 THIS IS THE FIX -->
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td>{{ $dtr['fullname'] }}</td>
                        <td style="text-align:center;">{{ $dtr['tsrs_count'] }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>
</html>