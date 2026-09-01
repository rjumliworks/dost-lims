<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
    html * { font-family: Arial, Helvetica, sans-serif; }
    body { margin: 20px 30px; font-size: 10px; }
    table { width: 100%; border-collapse: collapse; }
    table, td, th { border: .5px solid black; }
    th, td { padding: 3px; }
    .no-border, .no-border td { border: none !important; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .fw-bold { font-weight: bold; }
    .title { font-size: 14px; font-weight: bold; text-align: center; }
    .sub { font-size: 11px; text-align: center; }
</style>
</head>
<body>
    <div class="title">CASH RECEIPTS RECORD</div>
    <div class="sub">For the month of {{ $header['month'] }} {{ $header['year'] }}</div>
    <br/>

    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td width="70%" style="vertical-align: top;">
                <div class="fw-bold">DEPARTMENT OF SCIENCE AND TECHNOLOGY</div>
                <table style="margin-top: 6px;">
                    <tr>
                        <td width="50%" class="text-center fw-bold">{{ $header['officer'] }}</td>
                        <td width="50%" class="text-center fw-bold">{{ $header['station'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Accountable Officer</td>
                        <td class="text-center">Station</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table>
        <thead style="background-color:#d9d9d9;">
            <tr>
                <th rowspan="2" width="8%">Date</th>
                <th rowspan="2" width="10%">Reference No.</th>
                <th rowspan="2" width="20%">Payor</th>
                <th rowspan="2" width="14%">Nature of Collection</th>
                <th rowspan="2" width="10%">Collection</th>
                <th colspan="2" width="20%">Deposit</th>
                <th rowspan="2" width="12%">Undeposited Collection</th>
            </tr>
            <tr>
                <th width="10%">BTR</th>
                <th width="10%">Trust Fund</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['reference'] }}</td>
                <td>{{ $row['payor'] }}</td>
                <td>{{ $row['nature'] }}</td>
                <td class="text-right">{{ $row['collection'] }}</td>
                <td class="text-right">{{ $row['btr'] }}</td>
                <td class="text-right">{{ $row['trust'] }}</td>
                <td class="text-right">{{ $row['undeposited'] }}</td>
            </tr>
        @endforeach
            <tr style="background-color:#d9d9d9;" class="fw-bold">
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right">{{ $totals['collection'] }}</td>
                <td class="text-right">{{ $totals['btr'] }}</td>
                <td class="text-right">{{ $totals['trust'] }}</td>
                <td class="text-right">{{ $totals['undeposited'] }}</td>
            </tr>
        </tbody>
    </table>

    <br/><br/>
    <table class="no-border">
        <tr>
            <td style="border: none;">
                I hereby certify on my official oath that the foregoing is a correct and complete record of all collection and deposits had by me in my capacity as Cashier during the period indicated, as indicated in the corresponding columns.
            </td>
        </tr>
        <tr>
            <td style="border: none; padding-top: 40px;" class="text-center">
                <span class="fw-bold" style="text-decoration: underline;">{{ strtoupper($header['officer']) }}</span>
                <br/>Signature over Printed Name
            </td>
        </tr>
    </table>
</body>
</html>
