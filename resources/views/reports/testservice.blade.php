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
        input[type=checkbox] {
            transform: scale(.7);
        }
        .a {
            width: 55px; 
            height: 55px;
        }
        label {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
        }
        input {
            width: 13px;
            height: 13px;
            padding: 0;
            margin:0;
            vertical-align: bottom;
            position: relative;
            top: -5px;
            left: 7px;
            *overflow: hidden;
        }
        input[type=checkbox] { display: inline; }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        label {
            display: inline-block;
        }
        .footer {
            position: fixed;
            bottom: -10;
            width: 100%;
            left: 0;
            margin-left: auto;
            margin-right: auto;
        }
        .page-break {
            page-break-after: always;
        }
        .letter-p {
        position: relative;
        font-size: 100px;
        font-weight: bold;
        display: inline-block;
        color: black;
    }

    /* First line */
    .letter-p::before {
        content: '';
        position: absolute;
        width: 60%; /* adjust length */
        height: 5px; /* line thickness */
        background-color: red; /* line color */
        top: 20%; /* vertical position */
        left: 20%; /* horizontal start */
        transform: rotate(-10deg); /* optional tilt */
    }

    /* Second line */
    .letter-p::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 5px;
        background-color: blue;
        top: 50%;
        left: 25%;
        transform: rotate(5deg);
    }
        </style>
    </head>

<body>
    



    <div class="content">
        @foreach($samples as $page)
        <div style="font-family:Arial;">
            <img src="{{ public_path('images/logo-sm.png') }}" alt="tag" style="position: absolute; top: -4; left: 60; width: 50px; height: 50px;">
            <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">DEPARTMENT OF SCIENCE AND TECHNOLOGY - IX</center>
            <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">REGIONAL STANDARDS AND TESTING LABORATORIES</center>
            <center style="font-size: 11px;">Pettit Baracks, Zamboanga City | (062) 991-1024 | dost9info@gmail.com</center>
           
            <br/>
            <center style="margin-top: 8px; font-size: 12px;  color:#000; font-weight: bold; padding: 2px;">SAMPLES WITH TEST SERVICES</center>
        </div>

        <table style="border: 1px solid black; font-size: 10px; margin-top: 15px;">
            <tbody>
                <tr>
                    <td width="25%">Sample Name : </td>
                    <td width="25%"><span style="font-weight: bold; color: #072388;"> {{ ucwords($page['sample_name']) }}</span></td>
                    <td width="25%">Total Amount :</td>
                    <td width="25%">
                        <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                            <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                            <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                            P
                        </span> {{ number_format(trim(str_replace([',', '₱'], '', $page['total_fee'])), 2, ".", ",") }}
                </tr>
            </tbody>
        </table>
       

         <h6 style="font-size: 10px; margin-top: 12px;">1.TESTING OR CALIBRATION SERVICES</h6>
        <table style="border: 1px solid black; font-size: 10px; margin-top: -22px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr>    
                    <th style="vertical-align: middle;" width="50%">Test Services</th>
                    <th style="vertical-align: middle;" width="25%">No. of Times Performed</th>
                    <th style="vertical-align: middle;" width="25%">Total Amount</th>
                </tr>
            </thead>
            @foreach($page['testnames'] as $index=>$test)
                <tr style="text-align: center; font-size: 9px; color: #072388;">
                    <td>{{$test['name']}}</td>
                    <td>{{$test['count']}}</td>
                    <td>
                        <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                            <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                            <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                            P
                        </span>
                        {{number_format(trim(str_replace(',','',$test['total_fee']),'₱ '),2,".",",")}}</td>
                </tr>
            @endforeach
        </table>
        @if(!$loop->last)
        <div class="page-break"></div>
        @endif
        @endforeach
    </div>
</body>
</html>