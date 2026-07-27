<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
    <table>
        <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
            <tr>
                <td style="width: 300px; text-align: center; font-weight: bold;">Name</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Email</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Contact no.</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">TSR</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Services</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Total</td>
            </tr>
        </thead>
        <tbody>
        @foreach($lists as $list)
            <tr style="text-align: center; font-size: 9px; color: #072388;">
                <td style="text-align: center;">{{$list['name']}}</td>
                <td style="text-align: center;">{{$list['email']}}</td>
                <td style="text-align: center;">{{$list['contact_no']}}</td>
                <td style="text-align: center;">{{$list['count']}}</td>
                <td style="text-align: center;">{{$list['services']}}</td>
                <td style="text-align: center;">{{$list['total']}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
</body>
</html>
