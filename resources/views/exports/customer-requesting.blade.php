<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Customers Requesting</title>
    </head>
    <body>
        @php
            $categories = [
                'monthly'    => 'At least once a month',
                'quarterly'  => 'At least once every three months',
                'semiannual' => 'At least once every six months',
                'yearly'     => 'At least once in a year',
            ];
        @endphp
        <table border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center; font-size: 14px;">Customers Requesting ({{ $year }})</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laboratories as $lab)
                    <tr>
                        <td colspan="3" style="font-weight: bold; background-color: #072388; color: #fff;">{{ $loop->iteration }}. {{ $lab['laboratory'] }}</td>
                    </tr>
                    @foreach($categories as $key => $label)
                        <tr>
                            <td colspan="3" style="font-weight: bold; background-color: #eaeaea;">{{ $label }} ({{ $lab[$key] }})</td>
                        </tr>
                        <tr>
                            <th style="width: 50px; text-align: center;">No.</th>
                            <th style="width: 400px; text-align: left;">Customer Name</th>
                            <th style="width: 150px; text-align: left;">Months</th>
                        </tr>
                        @forelse($lab['customers'][$key] as $index => $customer)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $customer['customer'] }}</td>
                                <td>{{ $customer['months'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #888;">None</td>
                            </tr>
                        @endforelse
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</html>
