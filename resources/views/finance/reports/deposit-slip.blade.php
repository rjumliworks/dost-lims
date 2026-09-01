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
    .title { font-size: 15px; font-weight: bold; text-align: center; }
    .sub { font-size: 11px; text-align: center; }
</style>
</head>
<body>
    <div class="sub">Republic of the Philippines</div>
    <div class="title">DEPARTMENT OF SCIENCE AND TECHNOLOGY</div>
    <div class="sub">Pettit Barracks, Zamboanga City</div>
    <br/>
    <div class="title">LIST OF DEPOSITED COLLECTIONS</div>
    <br/>

    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td width="20%" style="border: none;">Date Collected:</td>
            <td width="30%" style="border: none;">{{ $deposit['date_collected'] }}</td>
            <td width="20%" style="border: none;">Deposit No.:</td>
            <td width="30%" style="border: none;">{{ $deposit['id'] }}</td>
        </tr>
        <tr>
            <td style="border: none;">Agency:</td>
            <td style="border: none;">{{ $deposit['agency_credited'] }}</td>
            <td style="border: none;">Date of Deposit:</td>
            <td style="border: none;">{{ $deposit['date'] }}</td>
        </tr>
        <tr>
            <td style="border: none;">Collecting Officer:</td>
            <td style="border: none;">{{ strtoupper($deposit['collecting_officer']) }}</td>
            <td style="border: none;">Page</td>
            <td style="border: none;">1</td>
        </tr>
        <tr>
            <td style="border: none;">Section:</td>
            <td style="border: none;">Cashiering</td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
        </tr>
    </table>

    <table>
        <thead style="background-color:#d9d9d9;">
            <tr>
                <th width="10%">BTR Code</th>
                <th width="10%">Account</th>
                <th width="16%">Description</th>
                <th width="14%">Agency to be Credited</th>
                <th width="12%">Agency Code</th>
                <th width="14%">Funding Source Code</th>
                <th width="10%">Fund Code</th>
                <th width="14%">Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($receipts as $row)
            <tr>
                <td class="text-center">{{ $deposit['account_code'] ?: '-' }}</td>
                <td class="text-center">{{ $deposit['account'] ?: '-' }}</td>
                <td>{{ strtoupper($row['nature']) }}</td>
                <td class="text-center">{{ $deposit['agency_credited'] }}</td>
                <td class="text-center">{{ $deposit['agency_code'] }}</td>
                <td class="text-center">{{ $deposit['funding_source'] ?: '-' }}</td>
                <td class="text-center">{{ $deposit['fund_code'] ?: '-' }}</td>
                <td class="text-right">{{ $row['amount'] }}</td>
            </tr>
        @endforeach
            <tr style="background-color:#d9d9d9;" class="fw-bold">
                <td colspan="7" class="text-right">TOTAL</td>
                <td class="text-right">{{ $deposit['total'] }}</td>
            </tr>
        </tbody>
    </table>

    <br/>
    <table class="no-border" style="width: 45%;">
        <tr>
            <td style="border: none;" class="fw-bold">Breakdown:</td>
            <td style="border: none;"></td>
        </tr>
        <tr>
            <td style="border: none;">Cash Deposit</td>
            <td style="border: none;" class="text-right">{{ $breakdown['cash'] }}</td>
        </tr>
        <tr>
            <td style="border: none; border-top: .5px solid black;">Check Deposit</td>
            <td style="border: none; border-top: .5px solid black;" class="text-right">{{ $breakdown['cheque'] }}</td>
        </tr>
        <tr>
            <td style="border: none; border-top: .5px solid black;" class="fw-bold">TOTAL</td>
            <td style="border: none; border-top: .5px solid black;" class="text-right fw-bold">{{ $deposit['total'] }}</td>
        </tr>
    </table>

    <br/><br/>
    <table class="no-border" style="width: 45%;">
        <tr>
            <td style="border: none;">Prepared by:</td>
        </tr>
        <tr>
            <td style="border: none; padding-top: 35px;">
                <span class="fw-bold" style="text-decoration: underline;">{{ strtoupper($deposit['collecting_officer']) }}</span>
                <br/>Collecting Officer
            </td>
        </tr>
    </table>
</body>
</html>
