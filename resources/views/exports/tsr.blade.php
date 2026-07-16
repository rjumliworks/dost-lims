<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
    <table>
        <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
            <tr>
                <td style="width: 150px; text-align: center; font-weight: bold;">TSR Code</td>
                <td style="width: 130px; text-align: center; font-weight: bold;">Subtotal</td>
                <td style="width: 130px; text-align: center; font-weight: bold;">Discount</td>
                <td style="width: 130px; text-align: center; font-weight: bold;">Total</td>
                <td style="width: 130px; text-align: center; font-weight: bold;">Gratis</td>
                <td style="width: 350px; text-align: center; font-weight: bold;">Customer</td>
                <td style="width: 400px; text-align: center; font-weight: bold;">Address</td>
                <td style="width: 150px; text-align: center; font-weight: bold;">Sample Code</td>
                <td style="width: 150px; text-align: center; font-weight: bold;">Samplename</td>
                <td style="width: 250px; text-align: center; font-weight: bold;">Testname</td>
                <td style="width: 250px; text-align: center; font-weight: bold;">Analyst</td>
                <td style="width: 160px; text-align: center; font-weight: bold;">Date Paid</td>
            </tr>
        </thead>
        <tbody>
        @foreach($lists as $list)
            <tr>
                <td style="{{ $list['code'] == '-' ? 'text-align: center;' : '' }}">{{$list['code']}}</td>
                <td style="text-align: center;">{{trim(str_replace(',','',$list['subtotal']),'₱ ')}}</td>
                <td style="text-align: center;">{{($list['discount'] == '₱0.00') ? '-' : trim(str_replace(',','',$list['discount']),'₱ ')}}</td>
                <td style="text-align: center;">{{trim(str_replace(',','',$list['total']),'₱ ')}}</td>
                <td style="text-align: center;">{{$list['gratis']}}</td>
                <td style="{{ $list['code'] == '-' ? 'text-align: center;' : '' }}">{{$list['customer']}}</td>
                <td style="{{ $list['code'] == '-' ? 'text-align: center;' : '' }}">{{$list['address']}}</td>
                <td style="text-align: center;">{{$list['samplecode']}}</td>
                <td style="text-align: center;">{{$list['samplename']}}</td>
                <td style="text-align: center;">{{$list['testname']}}</td>
                <td style="text-align: center;">{{$list['analyst']}}</td>
                <td style="text-align: center;">{{$list['date']}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            @php
                $totalSubtotal = 0;
                $totalDiscount = 0;
                $totalAmount = 0;
                $totalGratis = 0;

                foreach ($lists as $list) {
                    $subtotal = str_replace(['₱ ', '₱', ',', ' '], '', $list['subtotal']);
                    $discount = str_replace(['₱ ', '₱', ',', ' '], '', $list['discount']);
                    $total = str_replace(['₱ ', '₱', ',', ' '], '', $list['total']);
                    $gratis = str_replace(['₱ ', '₱', ',', ' '], '', $list['gratis']);


                    $totalSubtotal += floatval($subtotal);
                    $totalDiscount += floatval($discount);
                    $totalAmount += floatval($total);
                    $totalGratis += floatval($gratis);
                }
            @endphp
            <tr style="font-weight: bold; text-align: center;">
                <td colspan="1"></td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($totalSubtotal, 2, ".", ",") }}</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($totalDiscount, 2, ".", ",") }}</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($totalAmount, 2, ".", ",") }}</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($totalGratis, 2, ".", ",") }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
