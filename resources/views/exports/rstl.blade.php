<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
    <table>
        <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
            <tr>
                <td style="width: 150px; text-align: center; font-weight: bold;">Reference no.</td>
                <td style="width: 500px; text-align: center; font-weight: bold;">Customer</td>
                <td style="width: 400px; text-align: center; font-weight: bold;">Address</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">Payment Method</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">OR Number</td>
                <td style="width: 150px; text-align: center; font-weight: bold;">Total Fees</td>
                <td style="width: 150px; text-align: center; font-weight: bold;">Discounted</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">Amount</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">Status</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">Date Paid</td>
            </tr>
        </thead>
        <tbody>
        @foreach($lists as $list)
            <tr style="text-align: center; font-size: 9px; color: #072388;">
                <td style="text-align: center;">{{$list['reference_no']}}</td>
                <td style="text-align: center;">{{$list['customer']}}</td>
                <td style="text-align: center;">{{$list['address']}}</td>
                <td style="text-align: center;">{{$list['payment']}}</td>
                <td style="text-align: center;">{{$list['ornumber']}}</td>
                <td style="text-align: center;">{{trim(str_replace(',','',$list['total_fees']),'₱ ')}}</td>
                <td style="text-align: center;">{{$list['discount']}}</td>
                <td style="text-align: center;">{{trim(str_replace(',','',$list['amount']),'₱ ')}}</td>
                <td style="text-align: center;">{{$list['status']}}</td>
                <td style="text-align: center;">{{$list['date']}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
</body>
</html>
